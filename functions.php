<?php
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

function render_post_as_grid_item($post, $size, $css_class) {
  if(!$post) {
    return false;
  }

  $html = '';

  $id = $post->ID;
  $title = $post->post_title;
  $teaser = $post->post_content;
  $date = $post->post_date;
  $link = get_post_permalink($id);

  $html .= '<div class="grid_column grid_column--' . $size . ' post ' . $css_class . '">';
    $html .= '<a href="' . $link . '" ' .
                'class="post_title--link post_title">';
      $html .= '<strong>' . $title . '</strong>';
    $html .= '</a>';
    $html .= '<span class="post_date">' . $date . '</span>';
    $html .= '<p class="post_teaser richtext">' . $teaser . '</p>';
  $html .= '</div>';

  return $html;
}

register_nav_menus( array(
  'primary' => __( 'Primary Menu',      'alarmphone' ),
  'social'  => __( 'Social Links Menu', 'alarmphone' ),
) );

add_action( 'init', 'create_post_types');

?>
