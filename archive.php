<?php get_header(); ?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--9 app_content">
      <div class="grid_row">
        <div class="grid_column grid_column--12">
          <?php
            $qu = get_queried_object();
            $options = array();

            if(!$qu) {
              return;
            }

            $args = array(
              'post_type' => $qu->name,
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'lang' => pll_current_language(),
            );

            switch($qu->taxonomy) {
              case 'category':
                $category_name = $qu->cat_name;
                $category_id = $qu->cat_ID;

                $options = array(
                  'cat' => $category_id,
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
              $args = array(
                'external_links' => True,
                'strip_tags' => True,
              );

              if($posts) {
                foreach($posts as $post) {
                  echo '<div class="grid_row">';
                  echo render_blog_post($post, '12', 'release_item', 'preview', $args);
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