      <div class="grid_column grid_column--9">
        <footer class="footer">
          <?php
            if(has_nav_menu( 'footer' )) {
              wp_nav_menu( array(
                'menu_class'     => 'footer_navigation-container',
                'theme_location' => 'footer',
              ) );
            }
          ?>
        </footer>
      </div>
    </div>

    <script src="<?php bloginfo('template_url'); ?>/js/dist/main.js"
            async
            defer></script>
  </body>
</html>
