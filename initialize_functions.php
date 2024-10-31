<?php

/*
  Plugin Name: OpenBroker
  Plugin URI: https://www.openbroker.com/
  Description: Build your Real Estate website within 4 minutes. Official WordPress plugin for OpenBroker.com integration.
  Author: Openbroker
  Version: 2.0
  Text Domain: openbroker
  Domain Path: /languages
 */

define('OPENBROKER_PLUGIN_PATH', plugins_url('', __FILE__));
define('OPENBROKER_PLUGIN_LIB', __DIR__);

class WPM_Core
{

    private $settings;

    /**
     * Initialize functions
     */
    public function __construct()
    {
        // Init Functions
        add_action('init', [$this, 'save_settings']);
        add_action('init', [$this, 'load_settings']);
        add_action('init', [$this, 'load_libs']);

        // Include Styles and Scripts
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts_and_styles']);
        add_action('wp_enqueue_scripts', [$this, 'include_scripts_and_styles'], 99);

        // Redirect to API Single property
        add_filter('status_header', [$this, 'api_properties_page_redirect'], -1);

        // Admin menu
        add_action('admin_menu', [$this, 'register_menu']);

        // Ajax Functions
        add_action('wp_ajax_load_cities', [$this, 'load_cities_list']);
        add_action('wp_ajax_nopriv_load_cities', [$this, 'load_cities_list']);
        add_action('wp_ajax_get_ajax_properties', [$this, 'get_ajax_properties']);
        add_action('wp_ajax_nopriv_get_ajax_properties', [$this, 'get_ajax_properties']);
        add_action('wp_ajax_send_form_agency', [$this, 'send_form_agency']);
        add_action('wp_ajax_nopriv_send_form_agency', [$this, 'send_form_agency']);

        // Create Shortcodes
        add_shortcode('openbroker', [$this, 'create_shortcode']);

        // Frontend Functions
        add_action('template_include', [$this, 'elementor_support']);

         // Add helpers
        add_filter('title_helper', [$this, 'og_title']);
        add_filter('url_helper', [$this, 'og_url']);
        add_filter('description_helper', [$this, 'og_description']);
        add_filter('price_helper', [$this, 'formatted_price']);
        
        // Elementor Widgets
        add_action('init', [$this, 'elementor_widgets']);
        //translations
        add_action('init', [$this, 'openbroker_load_textdomain']);
       // add frontend style
       function enqueue_plugin_styles() {
        wp_enqueue_style('plugin-styles', plugin_dir_url(__FILE__) . 'templates/assets/css/frontend.css', array(), '1.0.1', 'all');
        }
        add_action('wp_enqueue_scripts', 'enqueue_plugin_styles');
    }

    public function openbroker_load_textdomain() {
      load_plugin_textdomain('openbroker', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function load_libs()
    {
        require_once(__DIR__ . '/api/openbroker.php');
    }

    /**
     * Elementor Widgets
     */
    public function elementor_widgets()
    {
        require_once(__DIR__ . '/templates/elementors/init.php');
    }

    /**
     * Support Elementor Templates
     */
    public function elementor_support($template)
    {
        global $wp_query;

        $template_url = explode('/', $template);

        if (in_array('index.php', $template_url) && !is_archive() && !is_home() && !is_search() && !is_singular() && !$wp_query->is_404) {
            ob_start();
            get_header();
            get_template_part('template-parts/single');
            get_footer();
            $template = ob_get_clean();
        }

        return $template;
    }

    /**
     * Send Modal Form to Agency
     */
    public function send_form_agency()
    {
        if (!wp_verify_nonce($_POST['_wpnonce'], 'openboker-nonce')) {
            return;
        }

        if (isset($_POST['firstname_agency']) && isset($_POST['lastname_agency'])) {
            $data = [
                'firstName' => sanitize_text_field($_POST['firstname_agency']),
                'lastName' => sanitize_text_field($_POST['lastname_agency']),
                'email' => sanitize_text_field($_POST['email_agency']),
                'phone' => sanitize_text_field($_POST['phone_agency']),
                'message' => sanitize_text_field($_POST['message_agency']),
                'houseId' => sanitize_text_field($_POST['houseid_agency']),
                'ipAddress' => '123.123.123.123'
            ];

            $openbroker = new OpenBroker();
            $r =  $openbroker->sendAgencyRequest($data);
            if (isset($r['data']["createLead"]["id"])) {
                wp_send_json(['status' => 'true']);
            }
        }
    }
    // helpers area
    public function og_title($house)
    {   
        $in_word = __('in_word', 'openbroker');
        if($in_word == '' || $in_word == 'in_word' || $in_word == null){
            $in_word = 'in';
        }
        $title = ucwords($house['subtype']) . ' ' . $in_word . ' ' . ucwords($house['address']['name']);
        return $title;
    }
    public function og_url($house)
    {
        //url its the interpolation of the house data and the address name
        //$url = 'https://www.openbroker.com/property/' . $house['id'] ;
        $url = home_url() . "/property/" . $house['id'] ;
        return $url;
    }
    public function og_description($house)
    {
        //  [[beds, baths].join((beds.empty? || baths.empty? ? '' : ', ').to_s),
        //   agency].join((beds.empty? && baths.empty? ? '' : ' | ').to_s)].join(' | ')
       return $this->get_price($house) . $this->rent_or_sale($house) . ' | ' . $this->baths_formatter($house['baths']) . ' | ' . $this->beds_formatter($house['beds']) . ' | ' . $this->agency_formatter($house);
    }
    public function agency_formatter($house){
        //agency_formatter its the interpolation of the house data and the address name
        if($house['agencyName'] == null){
            $formatter = '';
         }else{
            $formatter = 'Via ' . $house['agencyName'];
         }
         return $formatter;
    }

    public function beds_formatter($beds)
    {
        //bed_formatter its the interpolation of the house data and the address name
        if($beds == 0){
            $formatter = '';
         }elseif($beds == 1){
            $formatter = 'Bed';
         }
         else{
            $formatter = 'Beds';
         }
         return $beds . ' ' . $formatter;
    }

    public function baths_formatter($baths)
    {
        //bath_formatter its the interpolation of the house data and the address name
        if($baths == 0){
            $formatter = '';
         }elseif($baths == 1){
            $formatter = 'Bath';
         }
         else{
            $formatter = 'Baths';
         }
         return $baths . ' ' . $formatter;
    }

    public function rent_or_sale($house)
    {
        //rent_or_sale its the interpolation of the house data and the address name
        if($house['transactionType'] == 'for_rent'){
            $pricing = '€/month';
         }else{
            $pricing = '€';
         }
         return $pricing;
    }

    public function get_price($house)
    {
        if($house['transactionType'] == 'for_rent'){
            $price = number_format($house['forRentPrice'], 0, ",", ",") ;
         }else{
            $price = number_format($house['forSalePrice'], 0, ",", ",") ;
         }
         return $price;
    }
    public function formatted_price($house)
    {
        return $this->get_price($house) . $this->rent_or_sale($house);
    }
    /**
     * Create ShortCode
     */
    public function create_shortcode($args)
    {
        // Clean Args
        $args = array_map('sanitize_text_field', $args);

        // Configure properties View
        $items_row = 4;
        $size_description = 150;
        $content = '';

        // Change Default Settings if Isset
        if (isset($args['row_items'])) {
            $items_row = $args['row_items'];
        }
        if (isset($args['size_description'])) {
            $size_description = $args['size_description'];
        }

        // Prepare String for Get Properties
        $filters = '';
        $referencePoint = '';
        if (isset($args)) {
            foreach ($args as $filter_name => $filter_value) {
                // convert all lowercase params to camel case for API v2
                if ($filter_name == "transactiontype") {
                    $filter_name = "transactionType";
                } elseif ($filter_name == "propertytype") {
                    $filter_name = "propertyType";
                } elseif ($filter_name == "minprice") {
                    $filter_name = "minPrice";
                } elseif ($filter_name == "maxprice") {
                    $filter_name = "maxPrice";
                } elseif ($filter_name == "minbuiltarea") {
                    $filter_name = "minBuiltArea";
                } elseif ($filter_name == "minplotsize") {
                    $filter_name = "minPlotSize";
                } elseif ($filter_name == "perpage") {
                    $filter_name = "perPage";
                } elseif ($filter_name == "minbedrooms") {
                    $filter_name = "minBedrooms";
                } elseif ($filter_name == "minbathrooms") {
                    $filter_name = "minBathrooms";
                }elseif ($filter_name == "search_area_id") {
                    $filter_name = "addressSearchAreaId";
                }

                $filters .= "$filter_name=$filter_value&";
            }
        }

        // echo "<pre>";print_r($filters);die();
        // Check which Template is Using
        if (isset($args['template']) && $args['template'] == 'only_properties') {
            // Get Properties by Shortcode Args
            $properties_list = $this->properties_type('ajax_filter', $filters);

            // Get Template
            ob_start();
            include('templates/frontend/catalog/only-properties.php');
            $content = ob_get_clean();
        } elseif (isset($args['template']) && $args['template'] == 'properties-search') {
            $filters_array['propertyType'] = 'all';
            // Get Template
            ob_start();
            include('templates/frontend/search/properties-search.php');
            $content = ob_get_clean();
        }

        return $content;
    }

    /**
     * Get Properties from Ajax Search
     */
    public function get_ajax_properties()
    {

        if (!wp_verify_nonce($_POST['_wpnonce'], 'openboker-nonce')) {
            return;
        }
        if (isset($_POST['filters'])) {
            $filters = $this->sanitize_my_array($_POST['filters']);
            $properties_list = $this->properties_type('ajax_filter', $filters);
            //$more_content = json_encode($_POST['filters']);
            if (isset($_POST['shortcode'])) {
                $shortcode = sanitize_text_field($_POST['shortcode']);
                //$more_content .= "&shortcode={$shortcode}";
            }

            // Configure properties View
            $items_row = 4;
            $size_description = 150;
            $filters_array = [];
            foreach ($filters as $filter) {
                $data = explode('=', $filter);
                $filters_array[$data[0]] = $data[1];
            }

            // Check if Default Value is Changed
            if (isset($filters_array['row_items'])) {
                $items_row = $filters_array['row_items'];
            }
            if (isset($filters_array['size_description'])) {
                $size_description = $filters_array['size_description'];
            }


            // Load Template for Properties
            ob_start();
            if (isset($_POST['template']) && $_POST['template'] == 'admin_properties') {
                include('templates/admin/ajax_properties.php');
            } elseif (isset($_POST['template']) && $_POST['template'] == 'only_properties') {
                include('templates/frontend/catalog/only-properties.php');
            }
            $content = ob_get_clean();

            // Load Template for Filters
            ob_start();
            include('templates/frontend/search/properties-search.php');
            $search_filter = ob_get_clean();
            if (isset($more_content)){
                $content .= $more_content;
            }
            // Return Answer to Ajax
            wp_send_json([
                'status' => 'true',
                'content' => $content,
                'search' => $search_filter
            ]);
        }
    }

    /**
     * Load Data from API
     */
    public function properties_type($type, $object = null)
    {
        if ($type == 'ajax_filter') {
            $data = is_array($object) ? implode('&', $object) : $object;
            $objects_list = $this->get_properties_data("/properties/?{$data}");
        } elseif ($type == 'similar_objects' && $object) {
            // Set Settings before Get properties
            $num_posts = 4;
            $beds = isset($object['beds']) && $object['beds'] > 0 ? $object['beds'] : '';
            $baths = isset($object['baths']) && $object['baths'] > 0 ? $object['baths'] : '';
            $prop_type = isset($object['propertyType']) ? $object['propertyType'] : '';
            $price = isset($object['forSalePrice']) ? (int) $object['forSalePrice'] : $object['forRentPrice'];

            // $fireplace = $object['climate_control']['fireplace'] == 1 ? 'true' : '';
            // $balcony = $object['feature']['has_balcony'] == 1 ? 'true' : '';
            // $garage = !empty($object['parkingSlots']) ? 'true' : '';
            // $elevator = $object['feature']['has_elevator'] == 1 ? 'true' : '';
            // $air_conditioning = $object['climate_control']['air_conditioning'] == 1 ? 'true' : '';
            // $pool = !empty(array_keys(array_filter($object['pool']))) ? 'true' : '';
            // $security = !empty(array_keys(array_filter($object['security']))) ? 'true' : '';
            // $garden = $object['view']['garden'] == 1 ? 'true' : '';
            // $furnished = $object['furniture'] == 'furnished' ? 'true' : '';
            // $exclusive = $object['exclusive'] != '' ? 'true' : '';

            // Range Price Similar Objects
            $discount = 40;
            $price_min = $price - ($price * ($discount / 100));
            $price_max = $price + ($price * ($discount / 100));

            // Get Objects from API
            // $objects_list = $this->get_properties_data("/properties/?maxPrice={$price_max}&minPrice={$price_min}&exclusive={$exclusive}&is_furnished={$furnished}&has_garden={$garden}&has_security={$security}&has_pool={$pool}&has_ac={$air_conditioning}&has_elevator={$elevator}&has_parking={$garage}&has_balcony={$balcony}&has_fireplace={$fireplace}&per_page={$num_posts}&property_type={$prop_type}&beds={$beds}&baths={$baths}");
            $objects_list = $this->get_properties_data("/properties/?maxPrice={$price_max}&minPrice={$price_min}&perPage={$num_posts}&propertyType={$prop_type}&minBedrooms={$beds}&minBathrooms={$baths}");
        } elseif ($type == 'city_list' && $object) {

            $objects_list = $this->get_properties_data("/search_areas?query={$object}");
        }

        return $objects_list;
    }

    /**
     * Load Cities List Ajax
     */
    public function load_cities_list()
    {

        $url_query = str_replace(' ', '+', sanitize_text_field($_POST['search']));

        $data = $this->loadCitiesData($url_query);
        // echo "<pre>";print_r($data);die();
        wp_send_json($data["data"]["searchAreas"]["collection"]);
    }

    /**
     * Get Properties from OpenBroker
     */
    public function get_properties_data($url_query)
    {
        $openbroker = new OpenBroker();
        return $openbroker->load_properties($url_query);
    }

    public function loadCitiesData($query)
    {
        $openbroker = new OpenBroker();
        return $openbroker->loadCities($query);
    }

    /**
     * Try to map virtual URI with property
     */
    public function api_properties_page_redirect($header)
    {
        global $wp_query, $post, $page_name, $wp;

        if (isset($wp_query->post)) {
            $single_property_page = isset($this->settings['single_property']) ? $this->settings['single_property'] : null;
            if ($wp_query->post->ID == $single_property_page) {
                $url = parse_url(sanitize_url($_SERVER['REQUEST_URI']));
                $path = explode('/', $url['path']);
                $reversed = array_reverse($path);
                $property_id = 0;
                foreach ($reversed as $k => $v) {
                    if ($v) {
                        if (is_numeric($v)) {
                            $property_id = $v;
                        }
                    }
                }
                if ($property_id) {
                    $object = $this->get_properties_data("/house/?id=" . $property_id);
                    // print_r($object);
                    #START_HERE
                    // Configure WP Query
                    $post = get_post($this->settings['single_property']);

                    $wp_query->queried_object = $post;
                    $wp_query->is_single = true;
                    $wp_query->is_404 = false;
                    $wp_query->queried_object_id = $post->ID;
                    $wp_query->post_count = 1;
                    $wp_query->current_post = -1;
                    $wp_query->posts = array($post);

                    $wp_query->current_post = $post->ID;
                    $wp_query->found_posts = 1;
                    $wp_query->is_page = true; //important part
                    $wp_query->is_singular = true; //important part
                    $wp_query->is_single = false;
                    $wp_query->is_attachment = false;
                    $wp_query->is_archive = false;
                    $wp_query->is_category = false;
                    $wp_query->is_tag = false;
                    $wp_query->is_tax = false;
                    $wp_query->is_author = false;
                    $wp_query->is_date = false;
                    $wp_query->is_year = false;
                    $wp_query->is_month = false;
                    $wp_query->is_day = false;
                    $wp_query->is_time = false;
                    $wp_query->is_search = false;
                    $wp_query->is_feed = false;
                    $wp_query->is_comment_feed = false;
                    $wp_query->is_trackback = false;
                    $wp_query->is_home = false;
                    $wp_query->is_embed = false;
                    $wp_query->is_404 = false;
                    $wp_query->is_paged = false;
                    $wp_query->is_admin = false;
                    $wp_query->is_preview = false;
                    $wp_query->is_robots = false;
                    $wp_query->is_posts_page = false;
                    $wp_query->is_post_type_archive = false;
                    $wp_query->max_num_pages = 1;
                    $wp_query->post = $post;
                    $wp_query->post_count = 1;
                    $wp_query->query_vars['error'] = '';
                    unset($wp_query->query['error']);

                    $GLOBALS['wp_query'] = $wp_query;

                    $wp->query = array();
                    $wp->register_globals();

                    // Get property Data
                    $object = $this->get_properties_data("/house/?id=" . $property_id);
                    $object = $object['data']['houses']['collection'][0];
                    $beds = $object['beds'];

                    // Get Similar Properties
                    //$objects_similar = $this->properties_type( 'similar_objects', $object );
                    $objects_similar = array();
                    // Create new Title for Page
                    if ($beds != '') {
                        $page_name = $beds . ' Bedroom ' . ucwords($object['propertyType']);
                    } else {
                        $page_name = ucwords($object['propertyType']);
                    }

                    // Set H1 title on Page
                    $post->post_title = $page_name;

                    // Set Meta Title to Page
                    add_filter('pre_get_document_title', function ($title) {
                        global $page_name;

                        return $page_name;
                    }, 99);

                    // Load Template for Properties
                    // ob_start();
                    // include( 'templates/frontend/page/single-property.php' );
                    // $template = ob_get_clean();
                    // echo $template;
                    // die();
                    // $post->post_content = $template;
                    //TEMPORARY HACK DUE TO the_content filter not working in some theme
                    ob_start();
                    get_header();
                    include('templates/frontend/page/single-property.php');
                    get_footer();
                    $template = ob_get_clean();
                    echo $template;
                    die();

                    // Set Content on Shortcode to Page

                    add_filter('the_content', function ($content) use ($object) {
                        global $post;

                        // Load Template for Properties
                        ob_start();
                        include('templates/frontend/page/single-property.php');
                        $template = ob_get_clean();

                        // Search Shortcode and Replace it
                        $new_content = str_replace("[openbroker template='single-property']", $template, $post->post_content);
                        return "<h1>Hello World</h1>";
                        return $new_content;
                    }, 99);

                    // echo "<pre>";print_r($post);die();

                    if (strpos(sanitize_url($_SERVER['REQUEST_URI']), "house_") !== false && isset($object['property_type'])) {
                        $header = "HTTP/1.0 200 OK";
                    }
                    $header = "HTTP/1.0 200 OK";
                    #END_HERE
                } else {
                    // redirect to 404
                }
            }
        }
        // die();
        elseif (is_404()) {

            // Get Request URL Parts
            $url = parse_url(sanitize_url($_SERVER['REQUEST_URI']));
            $path = explode('/', $url['path']);

            // Search property ID in URL
            $is_property = false;
            $property_id = 0;
            foreach ($path as $k => $name) {
                if ($name == 'property') {
                    $property_id = isset($path[$k + 1]) ? $path[$k + 1] : 0;
                }
            }

            // Check if its property ID from API
            if (isset($property_id) && $property_id > 0) {

                // Configure WP Query
                $post = get_post($this->settings['single_property']);

                $wp_query->queried_object = $post;
                $wp_query->is_single = true;
                $wp_query->is_404 = false;
                $wp_query->queried_object_id = $post->ID;
                $wp_query->post_count = 1;
                $wp_query->current_post = -1;
                $wp_query->posts = array($post);

                $wp_query->current_post = $post->ID;
                $wp_query->found_posts = 1;
                $wp_query->is_page = true; //important part
                $wp_query->is_singular = true; //important part
                $wp_query->is_single = false;
                $wp_query->is_attachment = false;
                $wp_query->is_archive = false;
                $wp_query->is_category = false;
                $wp_query->is_tag = false;
                $wp_query->is_tax = false;
                $wp_query->is_author = false;
                $wp_query->is_date = false;
                $wp_query->is_year = false;
                $wp_query->is_month = false;
                $wp_query->is_day = false;
                $wp_query->is_time = false;
                $wp_query->is_search = false;
                $wp_query->is_feed = false;
                $wp_query->is_comment_feed = false;
                $wp_query->is_trackback = false;
                $wp_query->is_home = false;
                $wp_query->is_embed = false;
                $wp_query->is_404 = false;
                $wp_query->is_paged = false;
                $wp_query->is_admin = false;
                $wp_query->is_preview = false;
                $wp_query->is_robots = false;
                $wp_query->is_posts_page = false;
                $wp_query->is_post_type_archive = false;
                $wp_query->max_num_pages = 1;
                $wp_query->post = $post;
                $wp_query->post_count = 1;
                $wp_query->query_vars['error'] = '';
                unset($wp_query->query['error']);

                $GLOBALS['wp_query'] = $wp_query;

                $wp->query = array();
                $wp->register_globals();

                // Get property Data
                $object = $this->get_properties_data("/house/?id=" . $property_id);
                $object = $object['data']['houses']['collection'][0];
                $beds = $object['beds'];

                // Get Similar Properties
                $objects_similar = $this->properties_type('similar_objects', $object);

                // $objects_similar = array();
                // Create new Title for Page
                if ($beds != '') {
                    $page_name = $beds . ' Bedroom ' . ucwords($object['propertyType']);
                } else {
                    $page_name = ucwords($object['propertyType']);
                }

                // Set H1 title on Page
                $post->post_title = $page_name;

                // Set Meta Title to Page
                add_filter('pre_get_document_title', function ($title) {
                    global $page_name;

                    return $page_name;
                }, 99);

                ob_start();
                get_header();
                include('templates/frontend/page/single-property.php');
                get_footer();
                $template = ob_get_clean();
                echo $template;
                die();

                // Set Content on Shortcode to Page
                add_filter('the_content', function ($content) use ($object) {
                    global $post;

                    // Load Template for Properties
                    ob_start();
                    include('templates/frontend/page/single-property.php');
                    $template = ob_get_clean();

                    // Search Shortcode and Replace it
                    $new_content = str_replace("[openbroker template='single-property']", $template, $post->post_content);
                    // return "<h1>Hello World</h1>";
                    return $new_content;
                }, 99);

                if (strpos(sanitize_url($_SERVER['REQUEST_URI']), "house_") !== false && isset($object['property_type'])) {
                    $header = "HTTP/1.0 200 OK";
                }
                $header = "HTTP/1.0 200 OK";
            }
        }

        return $header;
    }

    /**
     * Save Core Settings to Option
     */
    public function save_settings()
    {
        if (isset($_POST['wpm_core']) && is_array($_POST['wpm_core'])) {
            $data = [
                'api_url' => sanitize_text_field($_POST['wpm_core']['api_url']),
                // 'app_id' => sanitize_text_field($_POST['wpm_core']['app_id']),
                'api_key' => sanitize_text_field($_POST['wpm_core']['api_key']),
                'single_property' => sanitize_text_field($_POST['wpm_core']['single_property']),
            ];

            update_option('wpm_core', serialize($data));
        }
    }

    /**
     * Load Saved Settings
     */
    public function load_settings()
    {
        $this->settings = unserialize(get_option('wpm_core', true));
    }

    /**
     * Include Scripts And Styles on Admin Pages
     */
    public function admin_scripts_and_styles()
    {

        $openbroker_nonce = wp_create_nonce('openboker-nonce');

        // Register styles
        wp_enqueue_style('wpm-core-selectstyle', plugins_url('templates/libs/selectstyle/selectstyle.css', __FILE__));
        wp_enqueue_style('wpm-font-awesome', plugins_url('templates/libs/font-awesome/scripts/all.min.css', __FILE__));
        wp_enqueue_style('wpm-core-tips', plugins_url('templates/libs/tips/tips.css', __FILE__));
        wp_enqueue_style('wpm-core-select2', plugins_url('templates/libs/select2/select2.min.css', __FILE__));
        wp_enqueue_style('wpm-core-lightzoom', plugins_url('templates/libs/lightzoom/style.css', __FILE__));
        wp_enqueue_style('wpm-core-modal', plugins_url('templates/libs/jquery-modal/jquery.modal.min.css', __FILE__));
        wp_enqueue_style('wpm-core-admin', plugins_url('templates/assets/css/admin.css', __FILE__));

        // Register Scripts
        wp_enqueue_script('wpm-core-selectstyle', plugins_url('templates/libs/selectstyle/selectstyle.js', __FILE__));
        wp_enqueue_script('wpm-font-awesome', plugins_url('templates/libs/font-awesome/scripts/all.min.js', __FILE__));
        wp_enqueue_script('wpm-core-tips', plugins_url('templates/libs/tips/tips.js', __FILE__));
        wp_enqueue_script('wpm-core-select2', plugins_url('templates/libs/select2/select2.min.js', __FILE__));
        wp_enqueue_script('wpm-core-lightzoom', plugins_url('templates/libs/lightzoom/lightzoom.js', __FILE__));
        wp_enqueue_script('wpm-core-modal', plugins_url('templates/libs/jquery-modal/jquery.modal.min.js', __FILE__));
        wp_enqueue_script('wpm-core-admin', plugins_url('templates/assets/js/admin.js', __FILE__));
        wp_localize_script('wpm-core-admin', 'admin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'openbroker_nonce' => $openbroker_nonce,
        ));
        wp_enqueue_script('wpm-core-admin');
    }

    /**
     * Include Scripts And Styles on FrontEnd
     */
    public function include_scripts_and_styles()
    {

        $openbroker_nonce = wp_create_nonce('openboker-nonce');

        // Register styles

        wp_enqueue_style('wpm-font-awesome', plugins_url('templates/libs/font-awesome/scripts/all.min.css', __FILE__));
        wp_enqueue_style('responsiveslides', plugins_url('templates/libs/rslides/responsiveslides.css', __FILE__));
        wp_enqueue_style('virtual-select', plugins_url('templates/assets/css/virtual-select.min.css', __FILE__));
        wp_enqueue_style('wpm-core', plugins_url('templates/assets/css/frontend.css', __FILE__), false, '1.0.0', 'all');

        // Register scripts
        wp_enqueue_script('wpm-font-awesome', plugins_url('templates/libs/font-awesome/scripts/all.min.js', __FILE__), array('jquery'), '1.0.2', 'all');
        wp_enqueue_script('responsiveslides', plugins_url('templates/libs/rslides/responsiveslides.min.js', __FILE__), array('jquery'), '1.0.2', 'all');
        wp_enqueue_script('virtual-select', plugins_url('templates/assets/js/virtual-select.min.js', __FILE__), null);
        wp_register_script('wpm-core', plugins_url('templates/assets/js/frontend.js', __FILE__), array('jquery'), '1.0.2', 'all');
        wp_localize_script('wpm-core', 'admin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'openbroker_nonce' => $openbroker_nonce,
        ));

        wp_enqueue_script('wpm-core');


    }

    /**
     * Add Settings to Admin Menu
     */
    public function register_menu()
    {
        add_menu_page('OpenBroker', 'OpenBroker', 'edit_others_posts', 'wpm_core_settings');
        add_submenu_page('wpm_core_settings', 'OpenBroker', 'OpenBroker', 'manage_options', 'wpm_core_settings', function () {
            global $wp_version, $wpdb;

            // Get Saved Settings
            $settings = $this->settings;

            // Get Pages
            $args = array(
                'post_type' => 'page',
                'orderby' => 'desc',
                'posts_per_page' => -1
            );

            $pages = get_posts($args);

            include 'templates/admin/settings.php';
        });
    }

    /**
     * Sanitize function for Arrays
     */
    public function sanitize_my_array($array)
    {
        $data = [];
        foreach ($array as $item => $value) {
            $data[$item] = sanitize_text_field($value);
        }

        return $data;
    }
}

new WPM_Core();
