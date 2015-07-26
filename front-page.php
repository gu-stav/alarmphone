<?php get_header(); ?>

<?php
  $press_releases = get_press_releases();
  $campaigns = get_campaigns();
  $intro = get_intro();
?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--12">
      <?php
        if($intro) {
          echo render_intro($intro[0]);
        }
      ?>
    </div>
  </div>

  <div class="grid_row">
    <div class="grid_column grid_column--9">
      <div class="grid_column grid_column--12 app_content">
        <?php
          if($campaigns) {
            foreach($campaigns as $campaign) {
              echo render_post_as_grid_item($campaign, '6', '', 'preview');
            }
          }
        ?>
      </div>
      <div class="grid_column grid_column--12">
        <h2><?php _e("Latest Releases") ?></h2>

        <div class="release">
          <?php
            if($press_releases) {
              foreach($press_releases as $press_release) {
                echo render_press_release($press_release, '12', 'release_item', 'preview');
              }
            }
          ?>
        </div>
      </div>
    </div>

    <div class="grid_column grid_column--3 app_aside aside">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>