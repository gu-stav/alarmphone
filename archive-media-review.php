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

            $category_name = $qu->labels->name;

            $args = array(
              'orderby' => 'title',
              'order' => 'DESC',
              'post_type' => 'media-review',
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'lang' => pll_current_language(),
            );
          ?>

          <h1 class="headline headline--h1"><?php echo $category_name; ?></h1>

          <div class="release">
            <?php
              $taxonomy_items = get_terms('langgroups');
              $post_args = array(
                'render_post_text' => true,
                'text_to_teaser' => true,
              );

              if($taxonomy_items) {
                foreach($taxonomy_items as $taxonomy_item) {
                  $options = array(
                    'langgroups' => $taxonomy_item->slug,
                  );
                  $posts = query_posts(array_merge($args, $options));

                  echo '<h2>' . $taxonomy_item->name . '</h2>';

                  foreach($posts as $post) {
                    echo '<div class="grid_row">';
                      echo render_blog_post($post, '12', 'release_item', 'preview', $post_args);
                    echo '</div>';
                  }

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
