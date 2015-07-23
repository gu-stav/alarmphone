<?php get_header(); ?>

<?php
  $press_releases = get_press_releases();
  $campaigns = get_campaigns();
  var_dump($press_releases);
  include( locate_template( 'home-grid.php' ) );
?>

<?php get_footer(); ?>