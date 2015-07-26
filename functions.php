<?php
add_image_size( 'post-thumb', 420, 420 );

function create_post_types() {
  /* PRESS RELEASE */
  register_post_type( 'press-releases',
    array(
      'labels' => array(
        'name' => __( 'Press Releases' ),
        'singular_name' => __( 'Press Release' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  /* CAMPAIGN */
  register_post_type( 'campaigns',
    array(
      'labels' => array(
        'name' => __( 'Campaigns' ),
        'singular_name' => __( 'Campaign' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}

if(function_exists('acf_add_options_page')) {
  acf_add_options_page();
  acf_add_options_sub_page('General Options');
}

function get_press_releases() {
  return get_posts_of_type('press-releases', null);
}

function get_campaigns() {
  return get_posts_of_type('campaigns', null);
}

function get_intro() {
  return '';
}

function get_posts_of_type($type, $options) {
  $args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'post_per_page' => 10,
    'order' => 'ASC',
  );

  if(!$options) {
    $options = array();
  }

  $result = new WP_Query(array_merge($args, $options));
  return $result->posts;
}

function render_post_as_grid_item($post, $size, $css_class, $type) {
  if(!$post) {
    return false;
  }

  $html = '';

  $id = $post->ID;
  $title = $post->post_title;
  $teaser = $post->post_content;
  $excerpt = get_field('excerpt', $id);
  $date = $post->post_date;
  $link = get_post_permalink($id);
  $image_id = get_field('image', $id);
  $image_attr = array(
    'class' => 'post_image',
  );

  if($excerpt && $type != 'full') {
    $teaser = $excerpt;
  }

  $html .= '<div class="grid_column grid_column--' . $size . ' post ' . $css_class . '">';
    $html .= '<a href="' . $link . '" ' .
                'class="post_title--link post_title">';

      if($image_id) {
        $html .= wp_get_attachment_image($image_id, 'post-thumb', 0, $image_attr);
      }

      $html .= '<strong>' . $title . '</strong>';
    $html .= '</a>';
    $html .= '<span class="post_date">' . $date . '</span>';
    $html .= '<p class="post_teaser richtext">' . $teaser . '</p>';
  $html .= '</div>';

  return $html;
}

function render_material($material, $post_id) {
  $file = $material['file'];
  $preview = $material['file_preview'];

  $title = $file['title'];
  $description = $file['description'];
  $download_url = $file['url'];
  $language = $material['language'];

  $html = '<li class="material_item material_item--' . $language . ' u-cf">';

  if($preview) {
    $html .= '<div class="material_preview">';
    $html .= '<a href="' . $download_url . '">';
      $html .= wp_get_attachment_image($preview['ID'], 'post-thumb', 0, $post_id);
    $html .= '</a>';
    $html .= '</div>';
  }

  $html .= '<div class="material_content">';
    $html .= '<strong class="material_title">' . $title . '</strong>';
    $html .= '<p class="material_description richtext">' . $description . '</p>';
    $html .= '<a href="' . $download_url . '" class="material_download button button--gray">' . __('Download') . '</a>';
  $html .= '</div>';
  $html .= '</li>';

  return $html;
}

register_nav_menus( array(
  'primary' => __( 'Primary Menu',      'alarmphone' ),
  'social'  => __( 'Social Links Menu', 'alarmphone' ),
) );

add_action( 'init', 'create_post_types');

?>
