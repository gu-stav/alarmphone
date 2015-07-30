<?php
/*
Template Name: Material
*/
?>

<?php get_header(); ?>

<?php
  $title = $post->post_title;

  if(!$title) {
    $title = pll__('Material');
  }
?>

<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--9 app_content content">
      <div class="grid_row">
        <div class="grid_column grid_column--12">

          <?php
            $post_id = $post->ID;
            $materials = $image_id = get_field('material', $post_id);

            if($materials) {
          ?>
            <h1 class="headline headline--h1 headline--tt-normal headline--serif">
              <?php echo $title;  ?>
            </h1>

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

    <div class="grid_column grid_column--3 app_aside aside">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
