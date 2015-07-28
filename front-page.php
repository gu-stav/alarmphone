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
    <div class="grid_column grid_column--9 app_content">
      <div class="grid_row">
        <?php
          if($campaigns) {
            foreach($campaigns as $campaign) {
              echo render_campaign($campaign, '6', '', 'preview');
            }
          }
        ?>
      </div>

      <div class="release grid_row">
        <h2 class="headline headline--h2 headline--serif headline--tt-normal release_headline release_headline--front-page">
          <span>
            <?php _e("Latest Releases") ?>
          </span>

          <a href="<?php echo get_post_type_archive_link('press-releases'); ?>"><?php _e("All Releases"); ?></a>
        </h2>

        <?php
          if($press_releases) {
            foreach($press_releases as $press_release) {
              echo render_press_release($press_release, '12', 'release_item', 'preview');
            }
          }
        ?>
      </div>
    </div>

    <div class="grid_column grid_column--3 app_aside aside">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>