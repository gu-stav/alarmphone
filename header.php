<?php
  $page_title = wp_title('', false);
  $page_description = get_bloginfo('description');
  $page_name = get_bloginfo('name');
  $css_directory = get_bloginfo('template_directory');

  if( !$page_title ) {
    $page_title = $page_name;
  } else {
    $page_title .= ' | ' + $page_name;
  }
?>

<!doctype html>
<html>
  <head>
    <title>
      <?php echo $page_title; ?>
    </title>

    <link rel="stylesheet"
          href="/css/style.css" />
    <meta name="viewport"
          content="initial-scale=1" />

    <?php
      if( $page_description ) {
    ?>

      <meta name="description"
            content="<?php echo wp_strip_all_tags( $page_description ); ?>" />

    <?php
      }
    ?>
  </head>
  <body>
