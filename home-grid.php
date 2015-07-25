<div class="grid">
  <div class="grid_row">
    <div class="grid_column grid_column--12">
      <?php
        if($intro) {
          render_post_as_grid_item($intro, '12', 'post--is-intro');
        }
      ?>
    </div>
  </div>
  <div class="grid_row">
    <div class="grid_column grid_column--6">
      <?php
        if($campaigns) {
          foreach($campaigns as $campaign) {
            echo render_post_as_grid_item($campaign, '6', '');
          }
        }
      ?>
    </div>
    <div class="grid_column grid_column--6">
      <h2><?php _e("Latest Releases") ?></h2>

      <?php
        if($press_releases) {

        }
      ?>
    </div>
  </div>
</div>
