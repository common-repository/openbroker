<?php
if (isset($properties_list['data']) && !empty($properties_list['data']) && count($properties_list['data']) > 0) { ?>
    <style>
        .properties-list-items .items-properties .item-property {
            width: <?php echo esc_html(100 / max($items_row, 1) - 3) ?>%;
        }

        /* Mobiles */
        @media (max-width: 767px) {
            .properties-list-items .items-properties .item-property {
                width: 100% !important;
            }

            .red-label {
                font-size: 15px;
            }

        }

        /* Tablets */
        @media (min-width: 768px) and (max-width: 1024px) {
            .red-label {
                font-size: 12px;
            }


        }

        /* Desktop */
        @media (min-width: 1025px) {
            .properties-list-items .items-properties .item-property img {
                <?php
                if ($items_row < 4) :
                    echo "height: 350px !important;";
                    echo "width: 100%";
                elseif ($items_row >= 4) :
                    echo "height: 190px !important;";
                endif;
                ?>
            }
        }


        .red-label {
            <?php
            if ($items_row >= 4) :
                echo "font-size: 13px;";
            endif;
            ?>
        }
    </style>
    <div class="properties-list-items wait-ajax">
        <div class="items-properties">
            <?php
            foreach ($properties_list['data']['houses']['collection'] as $object) { ?>
                <div class="item-property">
                    <div class="item-property-image">
                        <a href="<?php echo esc_attr(get_home_url() . "/property/" . esc_html($object['id'])) ?>">
                            <img src="<?php
                                        echo isset($object['resizedPictures'][0]['url']) ?
                                            esc_attr($object['resizedPictures'][0]['url']) :
                                            "" ?>" alt=""> </a>
                    </div>
                    <div class="item-property-title">
                        <a href="<?php echo esc_attr(get_home_url() . "/property/" . esc_html($object['id'])) ?>">
                          <?php
                            if ($object['propertyType'] === 'apartment') {
                                echo esc_html(ucfirst(_e('Apartment in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                              } elseif ($object['propertyType'] === 'plot') {
                                echo esc_html(ucfirst(_e('Plot in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                                // we dont have subtypes so we are checking for the word villa in the description
                              } elseif (stripos(strtolower($object['description']), 'villa') !== false) {
                                echo esc_html(ucfirst(_e('Villa in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                              } elseif (stripos(strtolower($object['description']), 'penthouse') !== false) {
                                echo esc_html(ucfirst(_e('Penthouse in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                              } elseif (stripos(strtolower($object['description']), 'duplex') !== false) {
                                echo esc_html(ucfirst(_e('Duplex in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                              } elseif ($object['propertyType'] === 'house') {
                                echo esc_html(ucfirst(_e('House in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                              } elseif ($object['propertyType'] === 'commercial') {
                              echo esc_html(ucfirst(_e('Commercial Space in ', 'openbroker')) . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                            } else {
                                // Handle other property types or provide a default case
                                echo esc_html(ucfirst($object['propertyType']) . " in " . ucwords($object['address']['city']) . ", " . ucwords($object['address']['province']));
                            }
                          ?>
                        </a>
                    </div>
                    <div class="item-property-price">
                        <?php
                        // Rent or Sale price?
                        if (is_null($object['forSalePrice'])) {
                            $price = $object['forRentPrice'];
                        } else {
                            $price = $object['forSalePrice'];
                        }
                        echo esc_html(number_format($price, 0, ",", ",") . ' €') ?>
                    </div>
                    <div class="item-property-description">
                        <?php echo esc_html(substr($object['description'], 0, $size_description)) ?>...
                    </div>

                    <!-- <a href="<?php echo esc_attr(get_home_url() . "/property/" . $object['id']) ?>"  class="item-property-btn">View property</a> -->

                    <p class="red-label">
                      <span><?php echo $object["builtAreaMeters"] ?>&nbsp;<?php _e('m²', 'openbroker')?></span>,&nbsp;
                      <span><?php echo $object["beds"] ?>&nbsp;<?php _e('Beds', 'openbroker')?></span>,&nbsp;
                      <span><?php echo $object["baths"] ?>&nbsp;<?php _e('Baths', 'openbroker')?></span>,&nbsp;
                      <span><?php echo $object["plotSizeMeters"] ?>&nbsp;<?php _e('m² Plot', 'openbroker')?></span>
                    </p>
                </div>
            <?php } ?>
        </div>
        <?php if (isset($filters)) {
            if (!is_array($filters)) {
                $mFilters = array_filter(explode("&", $filters));
            } else {
                $mFilters = $filters;
            }

            if (in_array('show-pagination=yes', $mFilters)) {
        ?>
                <div class="pagination-properties">
                    <div id="pagination-settings">
                        <?php
                        foreach ($mFilters as $mFilter) {
                            $filter_data = explode('=', $mFilter);
                        ?>
                            <input type="hidden" data-id="<?php echo esc_attr($filter_data[0]) ?>" value="<?php echo esc_attr($filter_data[1]) ?>">
                        <?php
                        }
                        ?>
                    </div>
                    <button data-current="<?php echo esc_attr($properties_list['data']['houses']['metadata']['currentPage']); ?>" class="left-page-properties" <?php if ($properties_list['data']['houses']['metadata']['currentPage'] == 1) {
                                                                                                                                                                    echo esc_attr('disabled');
                                                                                                                                                                } ?>><i class="fas fa-arrow-left"></i></button>
                    <span class="properties-pages"><?php _e('Page: ', 'openbroker')?><span id="properties-pages-current"><?php echo esc_html($properties_list['data']['houses']['metadata']['currentPage']); ?></span><?php echo '/' . $properties_list['data']['houses']['metadata']['totalPages']; ?></span>
                    <button data-current="<?php echo esc_attr($properties_list['data']['houses']['metadata']['currentPage']); ?>" data-total="<?php echo esc_attr($properties_list['data']['houses']['metadata']['totalPages']); ?>" class="right-page-properties" <?php if ($properties_list['data']['houses']['metadata']['currentPage'] == $properties_list['data']['houses']['metadata']['totalPages']) {
                                                                                                                                                                                                                                                                        echo esc_attr('disabled');
                                                                                                                                                                                                                                                                    } ?>><i class="fas fa-arrow-right"></i></button>
                </div>
        <?php
            }
        } ?>
    </div>

<?php
} else { ?>
    <div class="no-properties-found"><?php _e('No Properties Found. Please, change your filters.', 'openbroker') ?></div>
<?php }
