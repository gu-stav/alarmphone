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

function get_press_releases() {
  return get_posts_of_type('press-releases', null);
}

function get_campaigns() {
  return get_posts_of_type('campaigns', null);
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

add_action( 'init', 'create_post_types');

?>
