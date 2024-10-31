<div id="settings-panel">
    <div class="section-company">
      <div class="left-side">
          <ul>
              <li><a class="change-table active" data-table="general-settings-table"><i class="fas fa-tools"></i> <?php echo esc_html__( 'General Setting', 'wpm-core' ) ?></a></li>
              <li><a class="change-table" data-table="collections-table"><i class="fas fa-sitemap"></i> <?php echo esc_html__( 'Collections', 'wpm-core' ) ?></a></li>
              <li><a class="change-table" data-table="shortcodes-table"><i class="fas fa-code"></i> <?php echo esc_html__( 'Shortcodes', 'wpm-core' ) ?></a></li>
              <li><a class="change-table" data-table="instructions-table"><i class="fas fa-question-circle"></i> <?php echo esc_html__( 'Instructions', 'wpm-core' ) ?></a></li>
              <li><a class="change-table" data-table="system-info-table"><i class="fas fa-shield-alt"></i> <?php echo esc_html__( 'System Info', 'wpm-core' ) ?></a></li>
              <li><a class="support-item" href="https://openbroker.com" target="_blank"><i class="fas fa-life-ring"></i> <?php echo esc_html__( 'Plugin Support', 'wpm-core' ) ?></a></li>
          </ul>
      </div>
      <div class="right-side">
          <a href="https://openbroker.com" target="_blank"><img src="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/logo.png' ) ?>" alt=""></a>
      </div>
    </div>
    <div class="select-table" id="general-settings-table">
      <form action="" method="post">
          <div class="section_data">
              <div class="title"><?php echo esc_html__( 'API Authorization', 'wpm-core' ) ?></div>
              <div class="head_items">
                  <div class="item-table"><?php echo esc_html__( 'API URL:', 'wpm-core' ) ?> <a href="#" data-tooltip="<?php echo esc_html__( 'API URL on the OpenBroker', 'wpm-core' ) ?>" class="help-icon clicktips"><i class="fas fa-question-circle"></i></a></div>
                  <!-- <div class="item-table"><?php echo esc_html__( 'App ID:', 'wpm-core' ) ?> <a href="#" data-tooltip="<?php echo esc_html__( 'App ID on the OpenBroker', 'wpm-core' ) ?>" class="help-icon clicktips"><i class="fas fa-question-circle"></i></a></div> -->
                  <div class="item-table"><?php echo esc_html__( 'Authorization Token:', 'wpm-core' ) ?> <a href="#" data-tooltip="<?php echo esc_html__( 'API Key on the OpenBroker', 'wpm-core' ) ?>" class="help-icon clicktips"><i class="fas fa-question-circle"></i></a></div>
              </div>
              <div class="items-list">
                  <div class="item-content">
                      <div class="item-table"><input type="text" name="wpm_core[api_url]" value="<?php if ( isset( $settings['api_url'] ) ) {
              echo esc_html( $settings['api_url'] );
            } ?>"></div>
                    <!--   <div class="item-table"><input type="text" name="wpm_core[app_id]" value="<?php if ( isset( $settings['app_id'] ) ) {
              echo esc_html( $settings['app_id'] );
            } ?>"></div> -->
                      <div class="item-table"><input type="text" name="wpm_core[api_key]" value="<?php if ( isset( $settings['api_key'] ) ) {
              echo esc_html( $settings['api_key'] );
            } ?>"></div>
                  </div>
              </div>
          </div>
          <div class="section_data">
              <div class="title"><?php echo esc_html__( 'Settings', 'wpm-core' ) ?></div>
              <div class="head_items">
                  <div class="item-table"><?php echo esc_html__( 'Single Property Page:', 'wpm-core' ) ?> <a href="#" data-tooltip="<?php echo esc_html__( 'Select page where to show Single Property Data', 'wpm-core' ) ?>" class="help-icon clicktips"><i class="fas fa-question-circle"></i></a></div>
              </div>
              <div class="items-list">
                  <div class="item-content">
                      <div class="item-table">
                          <select name="wpm_core[single_property]" class="select" data-search="true">
              <?php foreach ( $pages as $page ) {
                // Check Selected Item from Settings
                $selected = $page->ID == esc_html( $settings['single_property'] ) ? 'selected' : '';
                ?>
                                  <option value="<?php echo esc_attr( $page->ID ) ?>" <?php echo esc_attr( $selected ) ?>><?php echo esc_html( $page->post_title ) ?> </option>
              <?php } ?>
                          </select>
                      </div>
                  </div>
              </div>
          </div>
          <button class="button button-primary button-large" id="save-settings" type="submit"><?php echo esc_html__( 'Save settings', 'wpm-core' ) ?></button>
      </form>
    </div>
    <div class="select-table" id="collections-table" style="display: none">
        <div class="section_data">
            <div class="alert-help">
                <i class="fas fa-question-circle"></i> <?php echo esc_html__( 'On this page you can see a list of objects divided into categories by type, see their number, and also make a preview.', 'wpm-core' ) ?>
            </div>
            <div class="collections-table">
                <div class="collections-filters">
                    <div class="collections-features-select">Properties Filter</div>
                    <div class="collections-options">
                        <div class="col-option">
                            <label for="transactionType">Sale/Rent</label> <select name="transactionType" id="transactionType">
                                <option value="for_sale">For Sale</option>
                                <option value="for_rent">For Rent</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="propertyType">Property Type</label> <select name="propertyType" id="propertyType">
                                <option value="">All</option>
                                <option value="house">House</option>
                                <option value="apartment">Apartment</option>
                                <option value="plot">Plot</option>
                                <option value="commercial">Commercial</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="minBedrooms">Bedrooms</label> <select name="minBedrooms" id="minBedrooms">
                                <option value="">Any</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                                <option value="6">6+</option>
                                <option value="7">7+</option>
                                <option value="8">8+</option>
                                <option value="9">9+</option>
                                <option value="10">10+</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="minBathrooms">Bathrooms</label> <select name="minBathrooms" id="minBathrooms">
                                <option value="">Any</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                                <option value="6">6+</option>
                                <option value="7">7+</option>
                                <option value="8">8+</option>
                                <option value="9">9+</option>
                                <option value="10">10+</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="minPrice">Price Min</label> <select name="type" id="minPrice">
                                <option value="">Any</option>
                                <option value="1000">€1,000</option>
                                <option value="5000">€5,000</option>
                                <option value="10000">€10,000</option>
                                <option value="50000">€50,000</option>
                                <option value="100000">€100,000</option>
                                <option value="200000">€200,000</option>
                                <option value="300000">€300,000</option>
                                <option value="400000">€400,000</option>
                                <option value="500000">€500,000</option>
                                <option value="600000">€600,000</option>
                                <option value="700000">€700,000</option>
                                <option value="800000">€800,000</option>
                                <option value="900000">€900,000</option>
                                <option value="1000000">€1,000,000</option>
                                <option value="1500000">€1,500,000</option>
                                <option value="2000000">€2,000,000</option>
                                <option value="2500000">€2,500,000</option>
                                <option value="5000000">€5,000,000</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="maxPrice">Price Max</label> <select name="type" id="maxPrice">
                                <option value="">Any</option>
                                <option value="5000">€5,000</option>
                                <option value="10000">€10,000</option>
                                <option value="50000">€50,000</option>
                                <option value="100000">€100,000</option>
                                <option value="200000">€200,000</option>
                                <option value="300000">€300,000</option>
                                <option value="400000">€400,000</option>
                                <option value="500000">€500,000</option>
                                <option value="600000">€600,000</option>
                                <option value="700000">€700,000</option>
                                <option value="800000">€800,000</option>
                                <option value="900000">€900,000</option>
                                <option value="1000000">€1,000,000</option>
                                <option value="1500000">€1,500,000</option>
                                <option value="2000000">€2,000,000</option>
                                <option value="2500000">€2,500,000</option>
                                <option value="5000000">€5,000,000</option>
                                <option value="10000000">€10,000,000</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="minBuiltArea">Built Area</label> <input placeholder="Min (m2)" type="text" name="minBuiltArea" id="minBuiltArea">
                        </div>
                        <div class="col-option">
                            <label for="minPlotSize">Plot Size</label> <input placeholder="Min (m2)" type="text" name="minPlotSize" id="minPlotSize">
                        </div>
                    </div>
                    <div class="collections-options two">
                        <div class="col-option">
                            <label for="search_city">Location City/State (ID)</label> <input type="text" id="search_city" placeholder="All">
                            <div id="auto-city"></div>
                        </div>
                        <div class="col-option"  style="display: none;">
                            <label for="sort_by">Sort By</label> <select name="sort-properties" id="sort_by">
                                <option value="">Default</option>
                                <option value="created_at_desc">Newest First</option>
                                <option value="created_at_asc">Oldest First</option>
                                <option value="price_asc">Price (Low - High)</option>
                                <option value="price_desc">Price (High - Low)</option>
                                <option value="price_square_asc">Price per m2 (Low - High)</option>
                                <option value="price_square_desc">Price per m2 (High - Low)</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="show-pagination">Show Pagination</label> <select name="show-pagination" id="show-pagination">
                                <option value="">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-option">
                            <label for="perPage">Count Properties</label> <input type="number" id="perPage" value="15">
                        </div>
                        <div class="col-option">
                            <label for="row_items">Properties in Row</label> <input type="number" id="row_items" value="4">
                        </div>
                        <div class="col-option">
                            <label for="size_description">Size Description</label> <input type="number" id="size_description" value="150">
                        </div>
                        <div class="col-option" style="display: none;">
                            <label for="page">Page</label> <input type="number" id="page" value="1">
                        </div>
                        <div class="col-option" style="display: none;">
                            <input type="hidden" id="search_area_id">
                        </div>
                        <div class="col-option" style="display: none;">
                            <input type="hidden" id="template" value="only_properties">
                        </div>
                    </div>
                    <div class="collections-features-tabs">
                        <div class="collections-features-title">Additional Features:</div>
                        <div class="collection-tab-content">
                            <ul class="ks-cboxtags">
                                <li><input type="checkbox" id="feature-exclusive" value="exclusive"><label for="feature-exclusive">Exclusive</label></li>
                                <li><input type="checkbox" id="feature-has_parking" value="has_parking"><label for="feature-has_parking">Parking</label></li>
                                <li><input type="checkbox" id="feature-has_ac" value="has_climate_control"><label for="feature-has_ac">A/C & Heating</label></li>
                                <li><input type="checkbox" id="feature-has_pool" value="has_pool"><label for="feature-has_pool">Pool</label></li>
                                <li><input type="checkbox" id="feature-has_balcony" value="has_terrace"><label for="feature-has_balcony">Balcony</label></li>
                                <li><input type="checkbox" id="feature-is_furnished" value="has_furniture"><label for="feature-is_furnished">Furnished</label></li>
                                <li><input type="checkbox" id="feature-has_elevator" value="has_elevator"><label for="feature-has_elevator">Elevator</label></li>
                                <li><input type="checkbox" id="feature-has_garden" value="has_garden"><label for="feature-has_garden">Garden</label></li>
                                <li><input type="checkbox" id="feature-has_fireplace" value="has_fireplace"><label for="feature-has_fireplace">Fireplace</label></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section_data">
            <div class="properties-list-items"></div>
        </div>
    </div>
    <div class="select-table" id="shortcodes-table" style="display: none">
        <div class="section_data">
            <div class="alert-help">
                <i class="fas fa-question-circle"></i> <?php echo esc_html__( 'On this page, you can copy the shortcode that will display objects inside the post anywhere in the middle of the page text (POST), or in any required place in the template (PHP).', 'wpm-core' ) ?>
            </div>
            <div class="title"><?php echo esc_html__( 'Available Shortcodes', 'wpm-core' ) ?></div>
            <div class="shortcodes-row">
                <div class="shortcode-item">
                    <div class="short-image"><a href="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/shortcodes/single-property.jpg' ) ?>" class="lightzoom"><img src="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/shortcodes/single-property.jpg' ) ?>" alt=""></a></div>
                    <div class="short-details">
                        <div class="short-title">Single Property Page</div>
                        <div class="short-description">Create a new page and place this shortcode on it. Then go to the main plugin settings (first tab) and select the page where this shortcode is installed. After that, when selecting objects, you can go to the individual object page.</div>
                        <div class="short-code-title">Shortcode:</div>
                        <div class="short-code"><code>[openbroker template='single-property']</code></div>
                    </div>
                </div>
                <div class="shortcode-item">
                    <div class="short-image"><a href="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/shortcodes/only-properties.jpg' ) ?>" class="lightzoom"><img src="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/shortcodes/only-properties.jpg' ) ?>" alt=""></a></div>
                    <div class="short-details">
                        <div class="short-title">Properties objects</div>
                        <div class="short-description">This shortcode can be placed both on the page and inside the post in the middle of the text. You can also add parameters from the "Collections" tab to this shortcode to filter the displayed objects, or also add pagination.</div>
                        <div class="short-code-title">Shortcode:</div>
                        <div class="short-code"><code>[openbroker template='only_properties' per_page='15' row_items='3']</code></div>
                    </div>
                </div>
                <div class="shortcode-item">
                    <div class="short-image"><a href="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/shortcodes/filter-properties.jpg' ) ?>" class="lightzoom"><img src="<?php echo esc_attr( OPENBROKER_PLUGIN_PATH . '/templates/assets/img/shortcodes/filter-properties.jpg' ) ?>" alt=""></a></div>
                    <div class="short-details">
                        <div class="short-title">Search Objects by Filters</div>
                        <div class="short-description">Filtering objects by parameters. It can be placed in any convenient place. Preserves shortcode options and also allows you to filter objects by options on the same page without reloading.</div>
                        <div class="short-code-title">Shortcode:</div>
                        <div class="short-code"><code>[openbroker template='properties-search']</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="select-table" id="instructions-table" style="display: none">
        <div class="section_data">
            <div class="title">How Setup Plugin</div>
            <p>Before starting work with the plugin, you need to fill in the data for interacting with the API, with which we receive objects and can display them on pages using shortcodes. To obtain the above data, you need to purchase a subscription on the <a href="https://www.openbroker.com/" target="_blank">official OpenBroker website</a> with access to the API.</p>
            <p>After purchasing access to the API, you need to fill in the parameters in the first settings tab, namely: <b>API URL</b>, <b>App ID</b> and <b>API Key</b>.</p>
            <p>After that, you need to create 2 pages - one for the page of one object and the second for the page with a list of all objects. It is not necessary to create a page for the list of objects - you can use already existing pages, it is enough to place a shortcode on them.</p>
            <p>After creating a page for viewing one object, you need to go to the first tab of the plug-in settings and select this page in the <b>Single Property Page</b>. After that, you need to go to editing the page and add the shortcode <code>[openbroker template='single-property']</code> to the text of the page</p>
            <div class="title">How Use Shortcodes</div>
            <p>There are 3 shortcodes available on the "Shortcodes" page. There are 2 ways to use shortcodes in total. The first one through the output in the text of the page, and the second through the output inside the site templates (advanced level), if it is necessary to draw a conclusion in an individual place.</p>
            <p><b>Using shortcode in description:</b></p>
            <p><code>[openbroker template='only_properties' per_page='15' row_items='3']</code></p>
            <p>Pay attention to the parameters included in the shortcode - they affect the display of objects on the page, as well as their filtering. You can add your parameters by copying the necessary values and shortcodes from the "Collections" tab, where you can filter and generate a shortcode with a specific category of objects filtered by special parameters. It is also useful for SEO when writing articles for objects based on selected criteria.</p>
            <p><b>Using shortcode in theme template (PHP):</b></p>
            <p><code>do_shortcode("[openbroker template='only_properties' per_page='15' row_items='3']")</code></p>
            <p>The second method allows you to display the shortcode anywhere in the template, not just in the article or page description. You can display objects with this code anywhere.</p>
            <p>The above methods of using shortcodes are suitable for all shortcodes from the "Shortcodes" page.</p>
        </div>
    </div>
    <div class="select-table" id="system-info-table" style="display: none">
        <div class="section_data">
            <div class="alert-help">
                <i class="fas fa-question-circle"></i> <?php echo esc_html__( 'The following is a system report containing useful technical information for troubleshooting issues. If you need further help after viewing the report, do the screenshots of this page and send it to our Support.', 'wpm-core' ) ?>
            </div>
            <table class="status-table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2"><?php echo esc_html__( 'WordPress', 'wpm-core' ) ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo esc_html__( 'Home URL', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( get_home_url() ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Site URL', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( get_site_url() ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'REST API Base URL', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( rest_url() ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Version', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $wp_version ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Memory Limit', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( WP_MEMORY_LIMIT ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Debug Mode', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( WP_DEBUG ? 'Yes' : 'No' ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Debug Log', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( WP_DEBUG_LOG ? __( 'Yes', 'wpm-core' ) : __( 'No', 'wpm-core' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Script Debug Mode', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( SCRIPT_DEBUG ? __( 'Yes', 'wpm-core' ) : __( 'No', 'wpm-core' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Cron', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ? __( 'Yes', 'wpm-core' ) : __( 'No', 'wpm-core' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'WordPress Alternate Cron', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( defined( 'ALTERNATE_WP_CRON' ) && ALTERNATE_WP_CRON ? __( 'Yes', 'wpm-core' ) : __( 'No', 'wpm-core' ) ) ?></td>
                </tr>
                </tbody>
            </table>
            <table class="status-table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2"><?php echo esc_html__( 'Web Server', 'wpm-core' ) ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo esc_html__( 'Software', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Port', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $_SERVER['SERVER_PORT'] ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Document Root', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $_SERVER['DOCUMENT_ROOT'] ) ?></td>
                </tr>
                </tbody>
            </table>
            <table class="status-table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2"><?php echo esc_html__( 'PHP', 'wpm-core' ) ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo esc_html__( 'Version', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( phpversion() ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Memory Limit (memory_limit)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( ini_get( 'memory_limit' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Maximum Execution Time (max_execution_time)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( ini_get( 'max_execution_time' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Maximum File Upload Size (upload_max_filesize)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( ini_get( 'upload_max_filesize' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Maximum File Uploads (max_file_uploads)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( ini_get( 'max_file_uploads' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Maximum Post Size (post_max_size)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( ini_get( 'post_max_size' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Maximum Input Variables (max_input_vars)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( ini_get( 'max_input_vars' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'cURL Enabled', 'wpm-core' ) ?></td>
                    <td><?php $curl = curl_version();
						if ( isset( $curl['version'] ) ) {
							echo esc_html( "Yes (version $curl[version])" );
						} else {
							echo esc_html( "No" );
						} ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Mcrypt Enabled', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( function_exists( 'mcrypt_encrypt' ) ? 'Yes' : 'No' ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Mbstring Enabled', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( function_exists( 'mb_strlen' ) ? 'Yes' : 'No' ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Loaded Extensions', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( implode( ', ', get_loaded_extensions() ) ) ?></td>
                </tr>
                </tbody>
            </table>
            <table class="status-table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2"><?php echo esc_html__( 'Database Server', 'wpm-core' ) ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo esc_html__( 'Database Character Set', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $wpdb->get_var( 'SELECT @@character_set_database' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'Database Collation', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $wpdb->get_var( 'SELECT @@collation_database' ) ) ?></td>
                </tr>
                </tbody>
            </table>
            <table class="status-table" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th colspan="2"><?php echo esc_html__( 'Date and Time', 'wpm-core' ) ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo esc_html__( 'WordPress (Local) Timezone', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( get_option( 'timezone_string' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'MySQL (UTC)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( $wpdb->get_var( 'SELECT utc_timestamp()' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'MySQL (Local)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( date( "F j, Y, g:i a", strtotime( $wpdb->get_var( 'SELECT utc_timestamp()' ) ) ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'PHP (UTC)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( date( 'Y-m-d H:i:s' ) ) ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__( 'PHP (Local)', 'wpm-core' ) ?></td>
                    <td><?php echo esc_html( date( "F j, Y, g:i a" ) ) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
