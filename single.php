<?php get_header(); ?>

<div class="app_content content">
  <div class="grid">
    <div class="grid_row">
      <div class="grid_column grid_column--12">
        <?php
          if($post) {
            echo render_post_as_grid_item(get_post(), '12', '');
          }
        ?>
      </div>
    </div>
  </div>
</div>

<div class="app_aside aside">
  <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
