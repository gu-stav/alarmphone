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

  if(!is_front_page() && !is_home()) {
    $home = esc_url( home_url( '/' ) );
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
    <link rel="alternate"
          type="application/rss+xml"
          title="<?php echo $page_name; ?>"
          href="<?php bloginfo('rss2_url'); ?>" />

    <?php
      if( $page_description ) {
    ?>

      <meta name="description"
            content="<?php echo wp_strip_all_tags( $page_description ); ?>" />

    <?php
      }

      wp_head();
    ?>
  </head>
  <body>
    <div class="app">

      <header class="grid app_header header">
        <div class="grid_row">
          <div class="header_service">
            <div class="grid">
              <div class="grid_row">
                <div class="grid_column grid_column--9 header_service-social-col">
                  <div class="header_service-item">
                    <?php echo render_social_menu(); ?>
                  </div>
                </div>
                <div class="grid_column grid_column--3 header_service-service">
                  <?php echo render_donation_menu(); ?>

                  <?php
                    if(function_exists('pll_the_languages')) {
                      echo render_language_select();
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid_row header_brand-phone-container">
          <div class="grid_column grid_column--3 header_phone">
            <div class="header_phone-inner">
              <div class="header_phone-text">
                <p class="header_phone-label"><?php pll_e('In case of emergency call'); ?></p>
                <a href="tel:<?php pll_e('+334 86 51 71 61'); ?>"
                   class="header_phone-number headline headline--h3"><?php pll_e('+334 86 51 71 61'); ?></a>
              </div>
            </div>
          </div>

          <div class="grid_column grid_column--9 header_brand u-cf">
            <?php
              if(isset($home)) {
            ?>
              <a href="<?php echo $home ?>"
                 rel="nofollow">
            <?php
              }
            ?>

              <img src="<?php bloginfo('template_url'); ?>/assets/ap-logo.svg"
                   class="header_logo"
                   alt="<?php pll_e('Alarmphone Logo'); ?>" />

            <?php
              if(isset($home)) {
            ?>
              </a>
            <?php
              }
            ?>


            <div class="header_title">
              <?php
                if(isset($home)) {
              ?>
                  <a href="<?php echo $home; ?>"
                    class="header_title-link">

              <?php
                }
              ?>

              <p class="header_title-preheadline">
                <?php pll_e('Watch the med'); ?>
              </p>
              <strong class="header_title-headline headline headline--h1">
                <?php pll_e('Alarmphone'); ?>
              </strong>
              <p class="header_title-postheadline">
                <?php pll_e('Hotline for boatpeople in distress. No rescue, but Alarm.'); ?>
              </p>

              <?php
                if(isset($home)) {
              ?>
                </a>
              <?php
                }
              ?>
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
