<?php get_header(); ?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--9 app_content">
      <div class="grid_row">
        <div class="grid_column grid_column--12">
          <?php
            $category = get_the_category();

            if($category) {
              $category = $category[0];
              $category_id = $category->cat_ID;
              $category_name = $category->name;

              $posts = query_posts(array(
                'category_id' => $category_id,
                'post_type' => 'post',
                'posts_per_page' => -1,
                'post_status' => 'publish',
              ));
            } else {
              if(is_post_type_archive()) {
                $qu = get_queried_object();
                $post_type = $qu->name;
                $category_name = $qu->labels->name;

                $posts = query_posts(array(
                  'post_type' => $post_type,
                  'posts_per_page' => -1,
                  'post_status' => 'publish',
                ));
              }
            }
          ?>

          <h1 class="headline headline--h1"><?php _e($category_name) ?></h1>

          <div class="release">
            <?php
              if($posts) {
                foreach($posts as $post) {
                  echo '<div class="grid_row">';
                  echo render_blog_post($post, '12', 'release_item', 'preview', null);
                  echo '</div>';
                }
              }
            ?>
          </div>
        </div>
      </div>
    </div>

    <div class="grid_column grid_column--3 app_aside aside">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>