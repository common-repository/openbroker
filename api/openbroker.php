<?php
require_once(OPENBROKER_PLUGIN_LIB . '/vendor/autoload.php');
class OpenBroker
{
  private $settings = [];
  public function __construct()
  {
    $this->settings = unserialize(get_option('wpm_core', true));
    # print the content of the settings
    
  }
  
  public function load_properties($url_query)
  {
    try {
      $client = new \GraphQL\Client(
        trim($this->settings['api_url']),
        [],
        [
          'headers' => [
            'Authorization' => trim($this->settings['api_key']) //'eyJhbGciOiJIUzI1NiJ9.eyJpZCI6MTU1LCJleHAiOjE5OTMxMTY4MTh9.bL-mk8ckK4jDqGKiJxbetVMyNp-x5RKv0h9u6ENN_DQ'
          ],
          'verify' => false
        ]
      );
    } catch (\Exception $exception) {
      print("main");
      print_r($exception->getMessage());
      exit;
    }

    $query = $this->urlToGraphq($url_query);
    $params = $query;
    $options = [];
    //If options are set in query, split it separately
    if (array_key_exists("options", $params)) {
      $options = $params['options'];
      unset($params['options']);
    }
    $ps = implode(',', $params);
    $ps .= ', options:["' . implode('","', $options) . '"]';


    $gql = <<<QUERY
                        query {
                          houses($ps){
                              collection{   
                                    id                       
                                    address {
                                        city
                                        country
                                        province
                                        name
                                      }
                                    description(language: "english")
                                    transactionType
                                    propertyType
                                    subtype
                                    forSalePrice
                                    forRentPrice
                                    beds
                                    baths
                                    exclusive
                                    builtAreaMeters
                                    plotSizeMeters
                                    resizedPictures {
                                        url
                                        position
                                        resized
                                    }
                                }
                                metadata{
                                  totalCount
                                  totalPages
                                  currentPage
                                }
                          }
                        }
                    QUERY;

    // Single property listing query
    if (isset($query['object'])) {
      if ($query['object'] == 'house') {
        unset($params["object"]);
        $options = [];
        //If options are set in query, explit it separately
        if (array_key_exists("options", $params)) {
          $options = $params['options'];
          unset($params['options']);
        }
        $ps = implode(',', $params);
        $ps .= ', options:["' . implode('","', $options) . '"]';

        $gql = <<<QUERY
        query {
          houses($ps){
              collection{   
                    id                       
                    address {
                        city
                        country
                        province
                        name
                      }
                    description(language: "english")
                    transactionType
                    propertyType
                    subtype
                    forSalePrice
                    forRentPrice
                    beds
                    builtAreaMeters
                    plotSizeMeters
                    dailyPrice
                    baths
                    parkingSlots
                    exclusive
                    pictures {
                      url
                    }
                    similarProperties {
                      id                       
                      address {
                          city
                          country
                          province
                          name
                        }
                      description(language: "english")
                      propertyType
                      transactionType
                      subtype
                      forSalePrice
                      forRentPrice
                      beds
                      builtAreaMeters
                      plotSizeMeters
                      dailyPrice
                      baths
                      parkingSlots
                      exclusive
                      pictures {
                        url
                      }
                    }
                  }
          }
        }
    QUERY;
      }
    }


    // echo "<pre>";
    // print_r($gql);
    // die();

    try {
      $results = $client->runRawQuery($gql);
    } catch (\Exception $exception) {
      print("query\n");
      print_r($exception->getMessage());
      exit;
    }
    return json_decode($results->getResponseBody(), true);
  }

  public function urlToGraphq($url)
  {

    $objects = parse_url($url);

    if (strpos($objects['path'], '/house/') !== false) {
      $query = isset($objects['query']) ? $objects['query'] : '';
      $query = str_replace("=", ":", $query);
      $params = array();

      $params = explode('&', $query);
      $params['object'] = 'house';
      $options = [];
      foreach ($params as $k => $v) {
        $temp = explode(":", $v);
        // remove default params that don't need to be send to API
        if (in_array($temp[0], ["row_items", "size_description", "template", "show-pagination"])) {
          unset($params[$k]);
        }
        // add double qoute in string value
        if (in_array($temp[0], ["transactionType", "propertyType", "city"])) {
          $params[$k] = $temp[0] . ":" . '"' . $temp[1] . '"';
        }

        // if options checked build a separate array
        if (in_array($temp[0], [
          "has_parking", "has_climate_control", "has_pool", "has_terrace", "has_furniture",
          "has_elevator", "has_garden", "has_fireplace"
        ])) {
          $options[] = $temp[0];
          unset($params[$k]);
        }
      }
      // Search area id is build as array
      if ($temp[0] == "search_area_id") {
        $params[$k] = "addressSearchAreaId:" . '[' . $temp[1] . ']';
      }

      //options are not empty then
      if (!empty($options)) {
        $params["options"] = $options;
      }

      return $params;
    } else {

      $query = isset($objects['query']) ? $objects['query'] : '';
      $query = str_replace("=", ":", $query);
      $params = explode('&', $query);
      foreach ($params as $k => $v) {
        $temp = explode(":", $v);
        if (in_array($temp[0], ["lat"])) {
          $lat = $temp[1];
          unset($params[$k]);
        }
        if (in_array($temp[0], ["lng"])) {
          $lng = $temp[1];
          unset($params[$k]);
        }
        if (isset($lat) && isset($lng)) {
          $referencePoint = "referencePoint:" . '{' . "lat:" . $lat . "," . "lng:" . $lng . "}";
          $params['referencePoint'] = $referencePoint;
        }
        // remove default params that don't need to be send to API
        if (in_array($temp[0], ["row_items", "size_description", "template", "show-pagination", "search_city"])) {
          unset($params[$k]);
        }

        // add double qoute in string value
        if (in_array($temp[0], ["transactionType", "propertyType", "city"])) {
          $params[$k] = $temp[0] . ":" . '"' . $temp[1] . '"';
        }

        // if options checked build a separate array
        if (in_array($temp[0], [
          "has_parking", "has_climate_control", "has_pool", "has_terrace", "has_furniture",
          "has_elevator", "has_garden", "has_fireplace"
        ])) {
          $options[] = $temp[0];
          unset($params[$k]);
        }

        // Search area id is build as array
        if ($temp[0] == "search_area_id") {
          $params[$k] = "addressSearchAreaId:" . '[' . $temp[1] . ']';
        }
      }
      //options are not empty then
      if (!empty($options)) {
        $params["options"] = $options;
      }

      return $params;
    }
  }

  public function sendAgencyRequest($params)
  {
    try {
      $client = new \GraphQL\Client(
        trim($this->settings['api_url']),
        [],
        [
          'headers' => [
            'Authorization' => trim($this->settings['api_key']) //'eyJhbGciOiJIUzI1NiJ9.eyJpZCI6MTU1LCJleHAiOjE5OTMxMTY4MTh9.bL-mk8ckK4jDqGKiJxbetVMyNp-x5RKv0h9u6ENN_DQ'
          ],
          'verify' => false
        ]
      );
    } catch (\Exception $exception) {
      print("main");
      print_r($exception->getMessage());
      exit;
    }

    try {
      // Send Agency form for mutation lead
      $gql = $gql = <<<QUERY
      mutation {
        createLead(input: { 
          firstName: "{$params["firstName"]}", 
          lastName: "{$params["lastName"]}", 
          email: "{$params["email"]}", 
          phone: "{$params["phone"]}", 
          message: "{$params["message"]}", 
          houseId: "{$params["houseId"]}", 
          ipAddress: "{$params["ipAddress"]}"
        }) 
        {
          id
          firstName
          lastName
          email
          phone
          message
          userId
          ipAddress
          houseId
        }
      }
      QUERY;

      $result =  $client->runRawQuery($gql);
    } catch (\Exception $exception) {
      print("query\n");
      print_r($exception->getMessage());
      exit;
    }
    return json_decode($result->getResponseBody(), true);
  }

  public function loadCities($query)
  {
    try {
      $client = new \GraphQL\Client(
        trim($this->settings['api_url']),
        [],
        [
          'headers' => [
            'Authorization' => trim($this->settings['api_key']) //'eyJhbGciOiJIUzI1NiJ9.eyJpZCI6MTU1LCJleHAiOjE5OTMxMTY4MTh9.bL-mk8ckK4jDqGKiJxbetVMyNp-x5RKv0h9u6ENN_DQ'
          ],
          'verify' => false
        ]
      );
    } catch (\Exception $exception) {
      print("main");
      print_r($exception->getMessage());
      exit;
    }

    try {

      $gql = $gql = <<<QUERY
      query { searchAreas(name: "{$query}") {
        collection {
            id
            name
            
        }
      }
    }
    QUERY;
      // echo "<pre>";
      // print_r($gql);
      // die();

      $result =  $client->runRawQuery($gql);
    } catch (\Exception $exception) {
      print("query\n");
      print_r($exception->getMessage());
      exit;
    }
    return json_decode($result->getResponseBody(), true);
  }
}
