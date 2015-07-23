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

add_action( 'init', 'create_post_types');
