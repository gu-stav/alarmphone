<?php
add_image_size( 'post-thumb', 420, 420 );
add_image_size( 'post', 850, 850 );

function widgets_init() {
  register_sidebar( array(
    'name'          => 'General Sidebar',
    'id'            => 'general',
    'before_widget' => '<div class="aside_widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="aside_headline headline headline--h4">',
    'after_title'   => '</h3>',
  ) );
}

function create_post_types() {
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

function get_blog_posts() {
  $options = array(
    'post_per_page' => 5,
    'order' => 'DESC',
  );

  return get_posts_of_type('post', $options);
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
    $date_format = __('F d, Y');
  }

  $id = $post->ID;
  $post_type = get_post_type($post->ID);
  $custom_post_type = get_post_type_object($post_type);
  $title = $post->post_title;
  $text = $post->post_content;
  $teaser = get_field('excerpt', $id);
  $date = mysql2date($date_format, $post->post_date, True);
  $link = get_post_permalink($id);
  $image_id = get_field('image', $id);
  $image_attr = array(
    'class' => 'post_image',
  );
  $render_post_category = True;
  $render_post_text = True;
  $render_post_teaser = True;
  $headline_hierachy = '3';

  if($type == 'full') {
    $render_post_category = False;
    $headline_hierachy = '1';
  }

  if(array_key_exists('render_post_category', $options)) {
    $render_post_category = $options['render_post_category'];
  }

  if(array_key_exists('render_post_text', $options)) {
    $render_post_text = $options['render_post_text'];
  }

  if(array_key_exists('render_post_teaser', $options)) {
    $render_post_teaser = $options['render_post_teaser'];
  }

  if(array_key_exists('headline_hierachy', $options)) {
    $headline_hierachy = $options['headline_hierachy'];
  }

  $image_size = 'post-thumb';

  if($type == 'full') {
    $image_size = 'post';
    $text = apply_filters( 'the_content', $text );
    $teaser = apply_filters( 'the_content', $teaser );
  }

  $html .= '<div class="grid_column grid_column--' . $size . ' post ' . ($type == 'full' ? 'post--full' : '') . ' ' . $css_class . '">';

    if($type != 'full') {
      $html .= '<a href="' . $link . '" ' .
                  'class="post_title--link post_title headline headline--h' . $headline_hierachy . '">';
    }

      if($image_id) {
        $html .= wp_get_attachment_image($image_id, $image_size, 0, $image_attr);
      }

      if($render_post_category) {
        $html .= '<span class="post_category">' .
                  __($custom_post_type->labels->singular_name) .
                 '</span>';
      }

    if($type != 'full') {
      $html .= '<strong>' . $title . '</strong>';
      $html .= '</a>';
    } else {
      $html .= '<strong class="post_title--link post_title headline headline--h' . $headline_hierachy . ' headline--serif headline--tt-normal">' . $title . '</strong>';
    }

    $html .= '<span class="post_date">' . $date . '</span>';

    if($render_post_teaser && $teaser) {
      $html .= '<div class="post_teaser richtext">' . $teaser . '</div>';
    }

    if($render_post_text && isset($text)) {
      $html .= '<div class="post_text richtext">' . $text . '</div>';
    }

  $html .= '</div>';

  return $html;
}

function render_blog_post($post, $size, $css_class, $type) {
  $options = array(
    'date_format' => __('M d, y'),
    'render_post_category' => False,
    'render_post_text' => False,
  );

  $rendered = render_post_as_grid_item($post, $size, $css_class, $type, $options);
  $rendered = preg_replace('/post_([a-z_\-]+)/i', 'post_$1 release_$1', $rendered);

  return $rendered;
}

function render_campaign($post, $size, $css_class, $type) {
  $options = array(
    'render_post_teaser' => False,
    'render_post_text' => False,
  );

  return render_post_as_grid_item($post, $size, $css_class, $type, $options);
}

function render_sae($post, $size, $css_class, $type) {
  $options = array(
    'render_post_teaser' => True,
    'render_post_text' => False,
    'render_post_category' => False,
  );

  return render_post_as_grid_item($post, $size, $css_class, $type, $options);
}

function render_material($material, $post_id) {
  $file = $material['file'];
  $preview = $material['file_preview'];

  if(function_exists('pll_get_post')) {
    $file = get_post(pll_get_post($file['id']));
  } else {
    $file = get_post($file['id']);
  }

  $title = $file->post_title;
  $description = $file->post_content;
  $download_url = $file->guid;
  $language = $material['language'];

  /* check, if file itself is an image */
  if(!$preview && wp_attachment_is_image($file)) {
    $preview = $file;
  }

  $html = '<li class="material_item material_item--' . $language . ' u-cf">';

  if($preview) {
    if(is_array($preview)) {
      $preview_id = $preview['ID'];
    } else {
      $preview_id = $preview->ID;
    }

    $html .= '<div class="material_preview">';
    $html .= '<a href="' . $download_url . '">';
      $html .= wp_get_attachment_image($preview_id, 'post-thumb', 0, $post_id);
    $html .= '</a>';
    $html .= '</div>';
  } else {
    $file_mime = $file->post_mime_type;

    $html .= '<div class="material_preview material_preview--wo-media">';
      $html .= '<div class="material_preview-inner">';
        $html .= '<p>' . $file_mime . '</p>';
      $html .= '</div>';
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
    $media = wp_oembed_get($video, array('width' => '850px'));
  }

  $html = '<div class="grid_column grid_column--12 intro_container">';
  $html .= '<div class="grid">';
    $html .= '<div class="grid_row">';

      if($media) {
        $html .= '<div class="grid_column grid_column--12 intro_media ' . (isset($video) ? 'intro_media--video' : '') . '">';
        $html .= $media;
        $html .= '</div>';
      }

      $html .= '<div class="grid_column grid_column--' . ($media ? '4' : '12') . ' intro_content">';
        $html .= '<h1 class="intro_headline headline headline--h2">' . $title . '</h1>';
        $html .= '<div class="intro_text richtext">' . $text . '</div>';
      $html .= '</div>';
  $html .= '</div>';

  return $html;
}

function render_social_menu() {
  $html = '<ul class="header_service-social">';

  $menu_slug = 'social';
  $locations = get_nav_menu_locations();
  $menu_items = wp_get_nav_menu_items($locations[$menu_slug]);

  foreach($menu_items as $item) {
    $html .= '<li class="header_service-social-item">';
    $has_images = array( 'twitter', 'facebook', 'tumblr' );
    $index = strtolower( $item->title );
    $template_dir = get_bloginfo( 'template_directory' );

    $html .= '<a href="' . $item->url . '">';

    if( in_array( $index, $has_images ) ) {
      $html .= '<img src="'. $template_dir . '/assets/' . $index . '.svg"' . 'class="header_service-social-image"' . ' />';
      $html .= '<span class="u-accessible-hidden">' . $item->title . '</span>';
    } else {
      $html .= $item->title;
    }

    $html .= '</a>';
    $html .= '</li>';
  }

  $html .= '</ul>';

  return $html;
}

register_nav_menus( array(
  'primary' => __( 'Primary Menu' ),
  'social'  => __( 'Social Links Menu' ),
  'footer'  => __( 'Footer Menu' ),
) );

add_action('init', 'create_post_types');
add_action('widgets_init', 'widgets_init');

?>
