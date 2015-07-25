<?php get_header(); ?>

<div class="app_content content">
  <?php
    $press_releases = get_press_releases();
    $campaigns = get_campaigns();
    $intro = get_intro();

    include( locate_template( 'home-grid.php' ) );
  ?>
</div>

<div class="app_aside aside">
  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>