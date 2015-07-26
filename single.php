<?php get_header(); ?>

<div class="app_content content">
  <div class="grid">
    <div class="grid_row">
      <div class="grid_column grid_column--12">
        <?php
          if($post) {
            echo render_post_as_grid_item(get_post(), '12', '', 'full');
          }
        ?>

        <?php
          $post_id = $post->ID;
          $materials = $image_id = get_field('material', $post_id);

          if($materials) {
        ?>
          <h2><?php _e('Material') ?></h2>
          <ul class="material">

            <?php
              foreach($materials as $material) {
                echo render_material($material, $post_id);
              }
            ?>

          </ul>

        <?php
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
