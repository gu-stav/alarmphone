<?php
/*
Template Name: Safety at Sea
*/
?>

<?php get_header(); ?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--9 app_content content">
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
          <div class="release">
            <div class="grid_row post_grid">
              <?php
                $category_name = 'Safety at Sea';
                $category_id = get_cat_ID($category_name);

                $posts = query_posts(array(
                  'cat' => $category_id,
                  'post_type' => 'post',
                  'posts_per_page' => -1,
                  'post_status' => 'publish',
                  'lang' => pll_current_language(),
                ));

                if($posts) {
                  foreach($posts as $post) {
                    echo render_sae($post, '4', 'release_item', 'preview');
                  }
                }
              ?>
            </div>
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