<?php
add_image_size( 'post-thumb', 420, 420 );
add_image_size( 'post', 850, 850 );

function translate_static_strings() {
  $strings = array(
    'All {{category_name}}',
    'Latest News',
    'Alarmphone',
    'Hotline for boatpeople in distress. No rescue, but Alarm.',
    'Watch the med',
    '+334 86 51 71 61',
    'In case of emergency call',
    'Material',
    'Alarmphone Logo',
  );

  foreach($strings as $string) {
    pll_register_string($string, $string);
  }
}

function widgets_init() {
  class Full_Recent_Posts extends WP_Widget {
    function __construct() {
        parent::__construct(
          'full-recent-posts',
          __('Recent Posts (Full)', 'alarmphone'),
          array(
            'description' => __('Displays the recent 3 posts', 'alarmphone' ),
          )
        );
    }

    public function widget($args, $instance) {
      $count = !empty($instance['count']) ? $instance['count'] : 3;
      $category_id = !empty($instance['category']) ? $instance['category'] : null;

      if(function_exists('pll_get_term')) {
        $category_id_translated = pll_get_term($category_id);

        if($category_id_translated) {
          $category_id = $category_id_translated;
        }
      }

      $options = array(
        'post_per_page' => 5,
        'order' => 'DESC',
        'cat' => $category_id,
      );
      $posts = get_posts_of_type('post', $options);

      if($posts) {
        echo $args['before_widget'];

        if(!empty($instance['title'])) {
          echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        echo '<div class="grid">';
          echo '<div class="grid_row">';
            foreach($posts as $post) {
              echo render_sidebar_post($post, '12', 'release_item widget_full-recent-posts_post', 'preview');
            }
          echo '</div>';
        echo '</div>';

        echo $args['after_widget'];
      }
    }

    public function form( $instance ) {
      $title = !empty($instance['title']) ? $instance['title'] : __( 'New title', 'text_domain' );
      $count = !empty($instance['count']) ? $instance['count'] : 3;
      $category = !empty($instance['category']) ? $instance['category'] : null;
      $categories = get_categories();
      ?>

      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">
          <?php _e( 'Title:' ); ?>
        </label>
        <input class="widefat"
               id="<?php echo $this->get_field_id('title'); ?>"
               name="<?php echo $this->get_field_name('title'); ?>"
               type="text"
               value="<?php echo esc_attr($title); ?>">
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('count'); ?>">
          <?php _e( 'Number of posts to show:' ); ?>
        </label>
        <input class="widefat"
               id="<?php echo $this->get_field_id('count'); ?>"
               name="<?php echo $this->get_field_name('count'); ?>"
               type="text"
               value="<?php echo esc_attr($count); ?>">
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('category'); ?>">
          <?php _e( 'Show posts of category:' ); ?>
        </label>
        <select id="<?php echo $this->get_field_id('category'); ?>"
                name="<?php echo $this->get_field_name('category'); ?>">
          <?php
            foreach($categories as $category) {
              $selected = '';

              if($category->cat_ID == $category) {
                $selected = 'selected="selected"';
              }

              echo '<option ' . $selected . ' value="' . $category->cat_ID . '">' . $category->name . '</option>';
            }
          ?>
        </select>
      </p>

      <?php
    }
  }

  register_widget('Full_Recent_Posts');

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

  /* Media Review */
  register_post_type('media-review',
    array(
      'labels' => array(
        'name' => __( 'Media Reviews' ),
        'singular_name' => __( 'Media Review' )
      ),
      'taxonomies' => array('langgroups'),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_taxonomy('langgroups', 'media-review', array(
    'labels' => array(
      'name' => __('Languages'),
      'singular_name' => __('Language'),
      'edit_item' => __('Edit Language'),
      'all_items' => __('All Languages'),
      'add_new_item' => __('Add New Language'),
    ),
    'public' => false,
    'show_ui' => true,
    'hierarchical' => true,
  ));
}

if(function_exists('acf_add_options_page')) {
  acf_add_options_page();
  acf_add_options_sub_page('General Options');
}

function get_home_posts_category() {
  $id = get_field('front-page_news_category', 'option');
  $id_trans = pll_get_term($id);

  return $id_trans ? $id_trans : $id;
}

function get_home_posts_all_link() {
  $category_id = get_home_posts_category();
  $category_name = get_cat_name($category_id);
  $category_name_trans = pll__('All {{category_name}}');
  $link = get_category_link($category_id);

  $category_name_trans = str_replace('{{category_name}}', $category_name, $category_name_trans);

  $markup = '<a href="' . $link . '">' . $category_name_trans . '</a>';
  return $markup;
}

function get_home_posts() {
  $category_id = get_home_posts_category();

  if(!$category_id) {
    return;
  }

  if(function_exists('pll_get_term')) {
    $category_id_translated = pll_get_term($category_id);

    if($category_id_translated) {
      $category_id = $category_id_translated;
    }
  }

  $options = array(
    'posts_per_page' => 5,
    'order' => 'DESC',
    'cat' => $category_id,
  );

  return get_posts_of_type('post', $options);
}

function get_blog_posts() {
  $options = array(
    'post_per_page' => 5,
    'order' => 'DESC',
  );

  return get_posts_of_type('post', $options);
}

function get_campaigns() {
  return get_posts_of_type('campaigns');
}

function get_intro() {
  $args = array(
    'post_per_page' => 1,
  );

  return get_posts_of_type('intros', $args);
}

function get_posts_of_type($type, $options=array()) {
  $args = array(
    'post_type' => $type,
    'post_status' => 'publish',
    'post_per_page' => 10,
    'order' => 'ASC',
    'lang' => pll_current_language(),
  );

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
  $external_link = get_field('external_link', $id);
  $image_attr = array(
    'class' => 'post_image',
  );
  $render_post_category = True;
  $render_post_text = True;
  $render_post_teaser = True;
  $render_post_date = True;
  $text_to_teaser = False;
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

  if(array_key_exists('render_post_date', $options)) {
    $render_post_date = $options['render_post_date'];
  }

  if(array_key_exists('text_to_teaser', $options)) {
    $text_to_teaser = $options['text_to_teaser'];
  }

  $image_size = 'post-thumb';

  if($type == 'full') {
    $image_size = 'post';
  }

  $html .= '<div class="grid_column grid_column--' . $size . ' post ' . ($type == 'full' ? 'post--full' : '') . ' ' . $css_class . '">';

    if($type != 'full') {
      $html .= '<a href="' . $link . '" ' .
                  'class="post_title--link post_title headline headline--h' . $headline_hierachy . '">';
    } else {
      $html .= '<h1 class="post_title headline headline--h1 headline--serif headline--tt-normal">';
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
      $html .= $title . '</h1>';
    }

    if($render_post_date) {
      $html .= '<span class="post_date">' . $date . '</span>';
    }

    if($render_post_teaser && $teaser) {
      if(array_key_exists('strip_tags', $options)) {
        if($options['strip_tags']) {
          $teaser = wp_strip_all_tags($teaser, True);
          $teaser = '<p>' . $teaser . '</p>';
        }
      } else {
        $teaser = apply_filters('the_teaser', $teaser);
      }

      $html .= '<div class="post_teaser richtext">' . $teaser . '</div>';
    }

    if($render_post_text && isset($text)) {
      if(array_key_exists('strip_tags', $options)) {
        if($options['strip_tags']) {
          $text = wp_strip_all_tags($text, True);
          $text = '<p>' . $text . '</p>';
        }
      } else {
        $text = apply_filters('the_content', $text);
      }

      if($text_to_teaser) {
        $textclass = 'post_teaser';
      } else {
        $textclass = 'post_text';
      }

      $html .= '<div class="' . $textclass . ' richtext">';
        $html .= $text;

        if($external_link) {
          $html .= '<a class="post_external-link" href="' . $external_link . '">';
          $html .= '<img src="' . get_bloginfo('template_directory') . '/assets/arrow-right-black.svg"
                         alt="' . __('External Link: ') . '"
                         class="post_external-link-icon" />';
          $html .= $title . '</a>';
        }

      $html .= '</div>';
    }

  $html .= '</div>';

  return $html;
}

function render_blog_post($post, $size, $css_class, $type, $options) {
  $opt = array(
    'date_format' => __('M d, y'),
    'render_post_category' => False,
    'render_post_text' => False,
    'strip_tags' => False,
    'external_links' => False,
    'text_to_teaser' => False,
  );

  if(!$options) {
    $options = array();
  }

  $options = array_merge($opt, $options);
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

function render_sidebar_post($post, $size, $css_class, $type) {
  $options = array(
    'render_post_teaser' => True,
    'render_post_text' => False,
    'render_post_category' => False,
    'render_post_date' => False,
    'headline_hierachy' => 5,
  );

  return render_post_as_grid_item($post, $size, $css_class, $type, $options);
}

function render_material($material, $post_id) {
  $file = $material['file'];
  $preview = $material['file_preview'];

  if(!$file) {
    return;
  }

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

    /* Replace application/ so it renders only the type */
    $file_mime = str_replace('application/', '', $file_mime);

    $html .= '<div class="material_preview material_preview--wo-media">';
      $html .= '<div class="material_preview-inner">';
        $html .= '<p class="material_mime">' . $file_mime . '</p>';
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
  $link = get_permalink($id);
  $text = get_field('excerpt', $id);
  $action = get_field('action', $id);

  $image = get_field('image', $id);
  $image = wp_get_attachment_image($image['id'], 'large', 0);

  $video = get_field('youtube_video_url', $id);
  $video = wp_oembed_get($video, array('width' => '850px'));

  $html = '<div class="grid_column grid_column--12 intro_container">';
  $html .= '<div class="grid">';
    $html .= '<div class="grid_row">';
      $html .= '<div class="grid_column grid_column--12 intro_media">';
        $html .= '<a href="' . $link . '" class="intro_link">';
          $html .= '<button class="intro_play">';
            $html .= '<img src="' . get_bloginfo('template_directory') . '/assets/play-circle.svg"
                           alt="' . __('Play Video') . '"
                           class="intro_play-icon" />';
            $html .= '<span class="intro_play-label">View Clip</span>';
          $html .= '</button>';
          $html .= $image;
        $html .= '</a>';
        $html .= '<div class="responsive-video">';
          $html .= $video;
        $html .= '</div>';
      $html .= '</div>';

      $html .= '<div class="grid_column grid_column--4 intro_content">';
        $html .= '<a href="' . $link . '">';
          $html .= '<h1 class="intro_headline headline headline--h2">' . $title . '</h1>';
        $html .= '</a>';
        $html .= '<div class="intro_text richtext">' . $text . '</div>';
        $html .= '<div class="intro_action">';
          $html .= '<img src="' . get_bloginfo('template_directory') . '/assets/arrow-right.svg"
                         alt="" />';
          $html .= $action;
        $html .= '</div>';
      $html .= '</div>';
  $html .= '</div>';

  return $html;
}

function fill_categories($field) {
  $choices = get_categories();

  if(is_array($choices)) {
    $field['choices'] = array();

    foreach($choices as $choice) {
      $field['choices'][ $choice->cat_ID ] = $choice->name;
    }
  }

  return $field;
}

function render_social_menu() {
  $html = '<ul class="header_service-social">';

  $menu_slug = 'social';
  $locations = get_nav_menu_locations();

  if(!is_array($locations) || !array_key_exists($menu_slug, $locations)) {
    return '';
  }

  $menu_items = wp_get_nav_menu_items($locations[$menu_slug]);

  if(!$menu_items) {
    return '';
  }

  foreach($menu_items as $item) {
    $html .= '<li class="header_service-social-item">';
    $has_images = array( 'twitter', 'facebook', 'tumblr' );
    $index = strtolower( $item->title );
    $svg_path = __DIR__ . '/assets/' . $index .'.svg';
    $svg_exists = file_exists($svg_path);
    $svg = False;

    if($svg_exists) {
      $svg  = file_get_contents($svg_path);
    }

    $html .= '<a href="' . $item->url . '" target="_blank">';

    if(in_array($index, $has_images)) {
      $html .= '<div class="header_service-social-image">';
      $html .= $svg;
      $html .= '</div>';
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

function render_donation_menu() {
  $menu_slug = 'donation';
  $locations = get_nav_menu_locations();

  if(!is_array($locations) || !array_key_exists($menu_slug, $locations)) {
    return '';
  }

  $menu_items = wp_get_nav_menu_items($locations[$menu_slug]);
  $html = '';

  foreach($menu_items as $item) {
    $html .= '<a href="' . $item->url . '" class="header_service-item button">';
    $html .= $item->title;
    $html .= '</a>';
  }

  return $html;
}

function render_language_select() {
  $select_args = array('raw' => True);
  $raw = pll_the_languages($select_args);
  $html_buffer = '<ul class="language-select_list">';

  foreach($raw as $lang) {
    if($lang['current_lang']) {
      $active = $lang;
      continue;
    }

    $html_buffer .= '<li class="language-select_list-item">';
      $html_buffer .= '<a href="' . $lang['url'] . '">';
        $html_buffer .= $lang['name'];
      $html_buffer .= '</a>';
    $html_buffer .= '</li>';
  }

  $html_buffer .= '</ul>';

  $html = '<div class="language-select header_service-item">';
  $html .= '<button class="language-select_label">';
  $html .= '<span>' . $active['name'] . '</span>';
  $html .= '</button>';
  $html .= $html_buffer;
  $html .= '</div>';

  return $html;
}

register_nav_menus( array(
  'primary' => __( 'Primary Menu' ),
  'social'  => __( 'Social Links Menu' ),
  'donation'  => __( 'Donation Menu' ),
  'footer'  => __( 'Footer Menu' ),
) );

function add_langgroups_to_pll($taxonomies, $hide) {
    if ($hide)
        unset($taxonomies['langgroups']);
    else
        $taxonomies['langgroups'] = 'langgroups';

    return $taxonomies;
}

function shortcode_bulletpoint($atts, $content = null) {
  ob_start();
  $label = $atts['label'];
  $headline = null;

  if(array_key_exists('headline', $atts)) {
    $headline = $atts['headline'];
  }

  ?>

  <div class="bulletpoint">
    <strong class="bulletpoint_label"><?php echo $label; ?></strong>
    <div class="bulletpoint_content">

      <?php if($headline) { ?>
        <strong class="bulletpoint_headline">
          <?php echo $headline; ?>
        </strong>
      <?php } ?>

      <?php echo $content; ?>
    </div>
  </div>

  <?php
  return ob_get_clean();
}

add_action('init', 'create_post_types');
add_action('widgets_init', 'widgets_init');

add_shortcode('bulletpoint', 'shortcode_bulletpoint');

add_filter('acf/load_field/name=front-page_news_category', 'fill_categories');
add_filter('acf/load_field/name=front-page_intro_category', 'fill_categories');
add_filter('acf/load_field/name=front-page_grid_category', 'fill_categories');

add_filter('pll_get_taxonomies', 'add_langgroups_to_pll', 10, 2);

if(function_exists('pll_register_string')) {
  translate_static_strings();
}
?>
