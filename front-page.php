<?php get_header(); ?>

<?php
  $posts = get_blog_posts();
  $campaigns = get_campaigns();
  $intro = get_intro();
?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--12">
      <div class="intro">
        <?php
          if($intro) {
            echo render_intro($intro[0]);
          }
        ?>
      </div>
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
            <?php _e("Latest News") ?>
          </span>

          <a href="<?php echo get_post_type_archive_link('post'); ?>"><?php _e("All Articles"); ?></a>
        </h2>

        <?php
          if($posts) {
            foreach($posts as $post) {
              echo render_blog_post($post, '12', 'release_item', 'preview');
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