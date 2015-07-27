<?php
  $page_title = wp_title('', false);
  $page_description = get_bloginfo('description');
  $page_name = get_bloginfo('name');
  $css_directory = get_bloginfo('template_directory');

  $donation_url = get_field('donation_button_url', 'option');

  if( !$page_title ) {
    $page_title = __($page_name);
  } else {
    $page_title .= ' | ' . __($page_name);
  }
?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <title>
      <?php echo $page_title; ?>
    </title>

    <link rel="stylesheet"
          href="<?php bloginfo('stylesheet_url'); ?>"
          type="text/css" />
    <meta name="viewport"
          content="initial-scale=1" />
    <link rel="shortcut icon"
          href="<?php bloginfo('template_url'); ?>/favicon.ico" />

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

      <header class="grid app_header header">
        <div class="grid_row">
          <div class="header_service">
            <div class="header_service-item">
              <?php echo render_social_menu(); ?>
            </div>

            <?php
              if($donation_url) {
            ?>

              <a href="<?php echo $donation_url; ?>"
                 class="header_service-item button"><?php _e("Donate") ?></a>

            <?php
              }
            ?>

            <?php
              if(function_exists('pll_the_languages')) {
            ?>
              <ul class="lang-navigation header_service-item">
                <?php pll_the_languages(); ?>
              </ul>
            <?php
              }
            ?>

          </div>
        </div>

        <div class="grid_row header_brand-phone-container">
          <div class="grid_column grid_column--9 header_brand">
            <img src="<?php bloginfo('template_url'); ?>/assets/ap-logo.svg"
                 class="header_logo"
                 alt="<?php _e("Alarmphone Logo"); ?>" />

            <div class="header_title">
              <?php
                if(!is_front_page() && !is_home()) {
                  $home = esc_url( home_url( '/' ) );
              ?>
                  <a href="<?php echo $home; ?>" class="header_title-link">
              <?php
                }
              ?>

              <p class="header_title-preheadline">Watch the med</p>
              <strong class="header_title-headline headline headline--h1">Alarmphone</strong>
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

          <div class="grid_column grid_column--3 header_phone">
            <div class="header_phone-inner">
              <p class="header_phone-label"><?php _e("In case of emergency call"); ?></p>
              <a href="tel:<?php _e("+334 86 51 71 61"); ?>"
                 class="header_phone-number headline headline--h3"><?php _e("+334 86 51 71 61"); ?> </a>
            </div>
          </div>
        </div>

        <div class="grid_row">
          <nav class="grid_column grid_column--12 header_navigation">
            <?php
              if(has_nav_menu( 'primary' )) {
                wp_nav_menu( array(
      						'menu_class'     => 'header_navigation-container',
      						'theme_location' => 'primary',
      					) );
              }
            ?>
          </nav>
        </div>
      </header>
