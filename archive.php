<?php get_header(); ?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--9 app_content">
      <div class="grid_row">
        <div class="grid_column grid_column--12">
          <?php
            $qu = get_queried_object();
            $options = array();
            $args = array(
              'post_type' => $qu->name,
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'lang' => pll_current_language(),
            );

            switch($qu->taxonomy) {
              case 'category':
                $category_name = $qu->cat_name;
                $options = array(
                  'category_id' => $qu->cat_ID,
                  'post_type' => 'post',
                );
                break;

              default:
                if(is_post_type_archive()) {
                  $category_name = $qu->labels->name;
                }
                break;
            }

            $posts = query_posts(array_merge($args, $options));
          ?>

          <h1 class="headline headline--h1"><?php echo $category_name; ?></h1>

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