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

  /* Intro */
  register_post_type( 'intros',
    array(
      'labels' => array(
        'name' => __( 'Intros' ),
        'singular_name' => __( 'Intro' )
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
  $args = array(
    'post_per_page' => 1,
  );

  return get_posts_of_type('intros', null);
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

function render_post_as_grid_item($post, $size, $css_class, $type, $options=array()) {
  if(!$post) {
    return false;
  }

  $html = '';

  if(array_key_exists('date_format', $options)) {
    $date_format = $options['date_format'];
  } else {
    $date_format = __('d. F Y');
  }

  $id = $post->ID;
  $title = $post->post_title;
  $teaser = $post->post_content;
  $excerpt = get_field('excerpt', $id);
  $date = mysql2date($date_format, $post->post_date, True);
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

function render_press_release($post, $size, $css_class, $type) {
  $options = array(
    'date_format' => __('d M y'),
  );

  $rendered = render_post_as_grid_item($post, $size, $css_class, $type, $options);
  $rendered = preg_replace('/post_([a-z_\-]+)/i', 'post_$1 release_$1', $rendered);

  return $rendered;
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

function render_intro($intro) {
  $id = $intro->ID;
  $title = $intro->post_title;
  $text = apply_filters( 'the_content', $intro->post_content );
  $image = get_field('image', $id);

  if($image) {
    $media = wp_get_attachment_image($image['id'], 'large', 0);
  } else {
    $video = get_field('youtube_video_url', $id);
    $media = $video;
  }

  $html = '<div class="grid_column grid_column--12 intro">';
  $html .= '<div class="grid">';
    $html .= '<div class="grid_row">';

      if($media) {
        $html .= '<div class="grid_column grid_column--9 intro_media">';
        $html .= $media;
        $html .= '</div>';
      }

      $html .= '<div class="grid_column grid_column--' . ($media ? '3' : '12') . '">';
        $html .= '<div class="intro_content">';
          $html .= '<h1 class="intro_headline">' . $title . '</h1>';
          $html .= '<div class="intro_text richtext">' . $text . '</div>';
        $html .= '</div>';
      $html .= '</div>';
  $html .= '</div>';

  return $html;
}

register_nav_menus( array(
  'primary' => __( 'Primary Menu',      'alarmphone' ),
  'social'  => __( 'Social Links Menu', 'alarmphone' ),
) );

add_action( 'init', 'create_post_types');

?>
