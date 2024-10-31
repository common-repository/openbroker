<div class="single-property-content">
  <meta property="og:image" content=<?php echo $object['pictures'][0]['url']; ?> />
  <meta property="og:title" content="<?php echo apply_filters('title_helper' ,$object); ?>" />
  <meta property="og:url" content="<?php echo apply_filters('url_helper' ,$object); ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:description" content= "<?php echo apply_filters('description_helper' ,$object); ?>" />

  <meta property="og:image" itemprop="image" content=<?php echo $object['pictures'][0]['url']; ?> />
  <meta property="og:site_name" content="<?php echo apply_filters('title_helper' ,$object); ?>" />

  <meta property="twitter:image"  content=<?php echo $object['pictures'][0]['url']; ?>  />
  <meta property="twitter:title"  content="<?php echo apply_filters('title_helper' ,$object); ?>" />
  <meta property="twitter:image:alt" content="<?php echo "Picture of a " . $object['subtype']; ?>" />
</div>
    <h1>
      <?php
        echo apply_filters('title_helper' ,$object);
      ?>
    </h1>
    <?php if (isset($object['pictures']) && count($object['pictures']) > 0) { ?>
        <div class="rslides_container">
            <ul class="rslides">
                <?php
                $i = 0;
                foreach ($object['pictures'] as $image) { ?>
                    <li><img src="<?php echo esc_attr($image['url']); ?>" alt="" <?php
                                                                                    if ($i >= 3) {
                                                                                        echo "loading='lazy'";
                                                                                    } ?>></li>
                <?php
                    $i++;
                } ?>
            </ul>
        </div>
    <?php } ?>
    <div class="main-features">
        <div class="price-address" style="display: none;">
            <h3 class="address-line">
                <?php
                echo $object["beds"] . " Bed " . $object["baths"] . " Bath " . $object["propertyType"] . " In " . $object["address"]["name"];
                ?></h3>
            <div class="price-line">
                <?php
                // Rent or Sale price?
                if (is_null($object['forSalePrice'])) {
                    $price = $object['forRentPrice'];
                } else {
                    $price = $object['forSalePrice'];
                }
                echo esc_html('€' . number_format($price, 0, ",", ",")) ?>
                <?php if ($object['exclusive'] != '') { ?>
                    <span class="exclusive">Exclusive</span>
                <?php } ?>
            </div>
        </div>
        <div class="main-features-property w70 grid-container">
            <div class="mitem">
                <span><?php _e('Price', 'openbroker') ?></span><br>
                <span><?php echo esc_html(number_format($price, 0, ",", ",") . " €") ?></span>
              </div>
              <div class="mitem">
                <span><?php _e('Built Area', 'openbroker') ?></span><br>
                <span><?php echo esc_html($object['builtAreaMeters']) ?> m2</span>
              </div>
              <div class="mitem">
              <span><?php _e('Bedrooms', 'openbroker') ?></span><br>
              <span><?php echo esc_html($object['beds']) ?></span>
            </div>
            <div class="mitem">
              <span><?php _e('Bathrooms', 'openbroker') ?></span><br>
              <span><?php echo esc_html($object['baths']) ?></span>
            </div>
            <div class="mitem">
              <span><?php _e('Garage', 'openbroker') ?></span><br>
              <span><?php echo esc_html($object['parkingSlots']) ?></span>
            </div>
            <div class="mitem">
              <span><?php _e('Plot Size', 'openbroker') ?></span><br>
              <span><?php echo esc_html($object['plotSizeMeters']) ?> m2</span>
            </div>
            <div class="mitem">
                <span><?php _e('Ref. Number', 'openbroker') ?></span><br>
                <span><?php echo esc_html($object['id']) ?></span>
              </div>
            </div>
            <!-- <hr /> -->
            <div class="description-property p-description">
              <?php echo nl2br(esc_html(html_entity_decode($object['description']))); ?>
            </div>
            <!-- <hr /> -->
            <div class="description-property w90 py" style="display: none;">
              <h2><?php _e('Features', 'openbroker') ?></h2>
              <hr style="width: 30px; display: block; float: left;clear:right;" />
              <ul>
                <!-- <li>Feature 1 </li>
                <li>Feature 1 </li>
                <li>Feature 1 </li>
                <li>Feature 1 </li> -->
              </ul>
            </div>
            <!-- <hr /> -->
            <div class="description-property w90 py">
              <h2><?php _e('Contact us', 'openbroker') ?></h2>
            <hr style="width: 30px; display: block; float: left;clear:right;" />
            <form id="send-agency-form" onsubmit="return false;">
                <div style="clear: both;">
                    <div class="ct-row-l">
                        <label for="firstname-agency"><?php _e('First Name', 'openbroker') ?></label><br>
                        <input type="text" id="firstname-agency">
                    </div>
                    <div class="ct-row-r">
                        <label for="lastname-agency"><?php _e('Last Name', 'openbroker') ?></label><br>
                        <input type="text" id="lastname-agency">
                    </div>
                </div>
                <div style="clear: both;">
                    <div class="ct-row-l">
                        <label for="email-agency"><?php _e('Email Address', 'openbroker') ?></label><br>
                        <input type="text" id="email-agency">
                    </div>
                    <div class="ct-row-r">
                        <label for="phone-agency"><?php _e('Phone Number', 'openbroker') ?></label><br>
                        <input type="text" id="phone-agency">
                        <input type="hidden" id="houseid_agency" name="houseid_agency" value="<?php echo $object['id'] ?>" />
                    </div>
                </div>
                <div style="clear: both;">
                    <label for="message-agency"><?php _e('Message', 'openbroker') ?></label><br><br>
                    <textarea rows="5" style="width: 100%;margin-bottom: 20px;" id="message-agency"></textarea>
                </div>
                <div style="clear: both;text-align:center" class="py">
                    <button id="send-modal-agency"><?php _e('Send', 'openbroker') ?></button>
                    <div class="message-sended" style="display: none;"><?php _e('Message is sent! We will contact you soon as possible!', 'openbroker') ?></div>
                </div>
            </form>
        </div>
    </div>

    <?php if (
        isset($object["similarProperties"])
        && count($object["similarProperties"]) > 2
    ) { ?>
        <div class="similar-objects">
            <h2><?php echo _e('Similar properties', 'openbroker') ?></h2>
            <div class="grid-container">
              <?php
                foreach ( array_slice($object["similarProperties"], 0, 3) as $similar) {?>
                  <div class="grid-item">
                    <div class="similar-property-image">
                      <a href="<?php echo esc_attr(get_home_url() . "/property/" . $similar['id']) ?>">
                        <img src="<?php echo $similar['pictures'][0]['url'] ?>" alt="" class="similar-property-image"> 
                      </a>
                    </div>
                    <div class="item-property-title">
                      <a href="<?php echo esc_attr( get_home_url() . "/property/" . esc_html( $similar['id'] ) ) ?>" target="_blank">
                        <?php
                          echo apply_filters('title_helper' ,$object);
                        ?>
                      </a>
                    </div>
                    <div class="item-property-description">
							        <?php //echo esc_html( substr( $similar['description'], 0, 100 ) ) ?>
                    </div>
                    <div class="item-property-price">
							        <?php echo apply_filters('price_helper', $similar);?>
                    </div>
                  </div>
               <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
