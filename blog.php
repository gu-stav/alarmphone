<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--9">
      <div class="grid_row">
        <div class="grid_column grid_column--12">
          <?php
            $options = array(
              'render_post_date' => False
            );
            echo render_post_as_grid_item(get_post(), '12', '', 'full', $options);
          ?>
        </div>
      </div>

      <div class="grid_row">
        <div class="grid_column grid_column--12">
          <h1 class="headline headline--h1"><?php echo $category_name; ?></h1>

          <div class="release">
            <?php
              $paged = get_query_var('paged');
              $current_page = $paged ? $paged : 1;

              $posts = query_posts(array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'post_status' => 'publish',
                'paged' => $current_page,
              ));

              $max_pages = $wp_query->max_num_pages;
              wp_reset_query();
              $pagination = paginate_links( array(
                'base' => @add_query_arg('paged','%#%'),
                'format' => '?paged=%#%',
                'current' => $current_page,
                'total' => $max_pages,
                'prev_text' => __('Newer'),
                'next_text' => __('Older'),
                'prev_next' => False,
              ) );

              if($posts) {
                foreach($posts as $post) {
                  echo '<div class="grid_row">';
                  echo render_blog_post($post, '12', 'release_item', 'preview', null);
                  echo '</div>';
                }

                if($pagination) {
            ?>
                <div class="grid_row pagination">
                  <?php echo $pagination; ?>
                </div>
            <?php
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