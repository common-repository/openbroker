<div class="select-table" id="collections-table">
    <h1><?php _e('Search', 'openbroker') ?></h1>
    <div class="section_data">
        <div class="collections-table">
            <div class="collections-filters">
                <div class="collections-options">
                    <div class="col-option">
                        <select name="transactionType" id="transactionType">
                            <option value="for_sale"><?php _e('For Sale', 'openbroker') ?></option>
                            <option value="for_rent"><?php _e('For Rent', 'openbroker') ?></option>
                        </select>
                    </div>
                    <div class="col-option">
                        <select name="propertyType" id="propertyType">
                            <option value=""><?php _e('All Types', 'openbroker')?></option>
                            <option value="house"><?php _e('House', 'openbroker')?></option>
                            <option value="apartment"><?php _e('Apartment', 'openbroker')?></option>
                            <option value="plot"><?php _e('Plot', 'openbroker')?></option>
                            <option value="commercial"><?php _e('Commercial', 'openbroker')?></option>
                        </select>
                    </div>
                    <div class="col-option">
                        <select name="minBedrooms" id="minBedrooms">
                            <option value=""><?php _e('Any Bedrooms', 'openbroker')?></option>
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
                    <div class="col-option btnSearchWide">
                        <button class="btnSearch"><?php _e('Search', 'openbroker')?></button>
                    </div>
                </div>
                <div class="collections-options">
                    <div class="col-option">
                        <select name="minBathrooms" id="minBathrooms">
                            <option value=""><?php _e('Any Bathrooms', 'openbroker')?></option>
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
                        <select name="minPrice" id="minPrice">
                            <option value=""><?php _e('Min. Price', 'openbroker')?></option>
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
                        <select name="maxPrice" id="maxPrice">
                            <option value=""><?php _e('Max. Price', 'openbroker')?></option>
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
                        <input placeholder="<?php _e('Built Area Min (m2)', 'openbroker')?>" type="text" name="minBuiltArea" id="minBuiltArea">
                    </div>
                    <div class="col-option">
                        <input placeholder="<?php _e('Plot Size Min (m2)', 'openbroker')?>" type="text" name="minPlotSize" id="minPlotSize">
                    </div>
                </div>
                <div class="collections-options">
                    <div class="search_place">
                    <input type="text" id="search_input" placeholder="<?php _e('Search Location', 'openbroker')?>">
                    </div>
                    <div class="col-option">
                        <p id="radius_ouput"></p>
                        <input type="range" min="1" max="1000" value="500" class="slider" id="radius" name="radius">
                    </div>
                    <div class="col-option" style='width:1px;'>
                        <input type="hidden" id="lng" name="lng" >
                    </div>
                    <div class="col-option" style='width:1px;'>
                        <input type="hidden" id="lat" name="lat" >
                    </div>
                </div>
                <div class="collections-options two" style="display: none;">
                    <div class="col-option" style="display: none;">
                        <label for="sort_by"><?php _e('Sort By', 'openbroker')?></label> <select name="sort-properties" id="sort_by">
                            <option value=""><?php _e('Default', 'openbroker')?></option>
                            <option value="created_at_desc"><?php _e('Newest First', 'openbroker')?></option>
                            <option value="created_at_asc"><?php _e('Oldest First', 'openbroker')?></option>
                            <option value="price_asc"><?php _e('Price (Low - High)', 'openbroker')?></option>
                            <option value="price_desc"><?php _e('Price (High - Low)', 'openbroker')?></option>
                            <option value="price_square_asc"><?php _e('Price per m2 (Low - High)', 'openbroker')?></option>
                            <option value="price_square_desc"><?php _e('Price per m2 (High - Low)', 'openbroker')?></option>
                        </select>
                    </div>
                    <div class="col-option" style="visibility: hidden;">
                        <label for="show-pagination"><?php _e('Show Pagination', 'openbroker')?></label>
                        <select name="show-pagination" id="show-pagination">
                            <option value=""><?php _e('No', 'openbroker')?></option>
                            <option selected value="yes"><?php _e('Yes', 'openbroker')?></option>
                        </select>
                    </div>
                    <div class="col-option" style="visibility: hidden;">
                        <label for="perPage"><?php _e('Count Properties', 'openbroker')?></label> <input type="number" id="perPage" value="16">
                    </div>
                    <div class="col-option" style="visibility: hidden;">
                        <label for="row_items"><?php _e('Properties per Row', 'openbroker')?></label> <input type="number" id="row_items" value="2">
                    </div>
                    <div class="col-option" style="visibility: hidden;">
                        <label for="size_description"><?php _e('Description size', 'openbroker')?></label> <input type="number" id="size_description" value="150">
                    </div>
                    <div class="col-option" style="display: none;">
                        <label for="page"><?php _e('Page', 'openbroker')?></label> <input type="number" id="page" value="1">
                    </div>
                    <div class="col-option" style="display: none;">
                        <input type="hidden" id="search_area_id">
                    </div>
                    <div class="col-option" style="display: none;">
                        <input type="hidden" id="template" value="only_properties">
                    </div>
                </div>
                <div class="collections-features-tabs">
                    <div class="collection-tab-content">
                        <ul class="ks-cboxtags">
                            <li><input type="checkbox" id="feature-exclusive" value="exclusive"><label for="feature-exclusive"><?php _e('Exclusive', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_parking" value="has_parking"><label for="feature-has_parking"><?php _e('Parking', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_ac" value="has_climate_control"><label for="feature-has_ac"><?php _e('A/C & Heating', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_pool" value="has_pool"><label for="feature-has_pool"><?php _e('Pool', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_balcony" value="has_terrace"><label for="feature-has_balcony"><?php _e('Balcony', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-is_furnished" value="has_furniture"><label for="feature-is_furnished"><?php _e('Furnished', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_elevator" value="has_elevator"><label for="feature-has_elevator"><?php _e('Elevator', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_garden" value="has_garden"><label for="feature-has_garden"><?php _e('Garden', 'openbroker')?></label></li>
                            <li><input type="checkbox" id="feature-has_fireplace" value="has_fireplace"><label for="feature-has_fireplace"><?php _e('Fireplace', 'openbroker')?></label></li>
                        </ul>
                    </div>
                    <div class="col-option btnSearchMob">
                        <button class="btnSearch"><?php _e('search', 'openbroker')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section_data">
        <div class="properties-list-items"></div>
    </div>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyBf4qSvri9cw8hk-ExjVuYaK0gR5b-zxl4&language=es"></script>
<script>
    jQuery(document).ready(function(){
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('search_input'));
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            jQuery('#lat').val(place.geometry.location.lat());
            jQuery('#lng').val(place.geometry.location.lng());
        });
    });
</script>
<script>
    var slider = document.getElementById("radius");
    var output = document.getElementById("radius_ouput");
    output.innerHTML = "<?php _e('Search Radius: ', 'openbroker') ?>" + slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
    output.innerHTML = this.value;
    }
</script>
