<?php
  $page_title = wp_title('', false);
  $page_description = get_bloginfo('description');
  $page_name = get_bloginfo('name');
  $css_directory = get_bloginfo('template_directory');

  $donation_url = get_field('donation_button_url', 'option');

  if( !$page_title ) {
    $page_title = $page_name;
  } else {
    $page_title .= ' | ' + $page_name;
  }
?>

<!doctype html>
<html>
  <head>
    <title>
      <?php echo $page_title; ?>
    </title>

    <link rel="stylesheet"
          href="<?php bloginfo('stylesheet_url'); ?>"
          type="text/css" />
    <meta name="viewport"
          content="initial-scale=1" />

    <?php
      if( $page_description ) {
    ?>

      <meta name="description"
            content="<?php echo wp_strip_all_tags( $page_description ); ?>" />

    <?php
      }
    ?>
  </head>
  <body>
    <div class="app">

      <header class="app_header header">
        <div class="u-cf">
          <div class="header_service">
            <div class="header_service-item">
              <?php
                if(has_nav_menu( 'social' )) {
                  wp_nav_menu( array(
        						'menu_class'     => 'header_service-social',
        						'theme_location' => 'social',
        					) );
                }
              ?>
            </div>

            <?php
              if($donation_url) {
            ?>

              <a href="<?php echo $donation_url; ?>"
                 class="header_service-item button"><?php _e("Donate") ?></a>

            <?php
              }
            ?>

            <select class="header_service-item">
              <option>English</option>
            </select>
          </div>
        </div>

        <div class="header_brand-phone-container u-cf">
          <div class="header_brand">
            <img src=""
                 class="header_logo"
                 alt="Alarmphone Logo" />

            <div class="header_title">
              <?php
                if(!is_front_page() && !is_home()) {
              ?>
                  <a href="/" class="header_title-link">
              <?php
                }
              ?>

              <p class="header_title-preheadline">Watch the med</p>
              <strong class="header_title-headline">Alarmphone</strong>
              <p class="header_title-postheadline">Hotline for boatpeople in distress. no rescue, but alarm</p>

              <?php
                if(!is_front_page() && !is_home()) {
              ?>
                </a>
              <?php
                }
              ?>
            </div>

          </div>

          <div class="header_phone">
            <p class="header_phone-label">In case of emergency call:</p>
            <a href="tel:+334 86 51 71 61"
               class="header_phone-number">+334 86 51 71 61 </a>
            <!-- Phone Number as field of the blog ? -->
          </div>
        </div>

        <nav class="header_navigation">
          <?php
            if(has_nav_menu( 'primary' )) {
              wp_nav_menu( array(
    						'menu_class'     => 'header_navigation-container',
    						'theme_location' => 'primary',
    					) );
            }
          ?>
        </nav>
      </header>

      <ul class="app_breadcrumbs breadcrumbs">
        <!-- li elements -->
      </ul>

      <div class="app_content content">
