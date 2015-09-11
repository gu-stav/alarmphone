requirejs.config({
  baseUrl: '/js/',
  paths: {
    jquery: '../../bower_components/jquery/dist/jquery',
    shariff: '../../../../plugins/shariff/shariff',
  },
  shim: {
    'jquery': {
      exports: '$',
    },
  },
});

/* Navigation */
require(['jquery'], function($) {
  $(function() {
    var $navigation = $('.header_navigation-container');
    var timer;
    var openClass = 'sub-menu--is-open';

    var toggleMenu = function(e) {
      var $link = $(this);
      var $menu = $link.next('ul');

      if($menu.length) {
        e.preventDefault();
        $menu.toggleClass(openClass);
      }
    };

    var showMenu = function() {
      var self = this;
      var $link = $(this);
      var $menu = $link.next('ul');

      $menu
        .on('mouseenter', function() {
          clearTimeout(timer);
        })
        .on('mouseleave', function() {
          hideMenu.apply(self, arguments);
        })
        .addClass(openClass);
    };

    var hideMenu = function() {
      var $link = $(this);
      var $menu = $link.next('ul');

      $menu.removeClass('sub-menu--is-open');
    }

    $navigation
      .on('focus.navigation', 'a', toggleMenu)
      .on('mouseenter.navigation', 'a', showMenu)
      .on('mouseleave.navigation', 'a', function(e) {
        var self = this;

        timer = setTimeout(function() {
          hideMenu.apply(self, arguments);
        }, 200);
      });
  });
});

/* Language Select */
require(['jquery'], function($) {
  $(function() {
    var $container = $('.language-select');
    var $trigger = $container.children('.language-select_label');

    $trigger.on('click', function(e) {
      e.preventDefault();
      $container.toggleClass('language-select--is-open');
    });
  });
});

require(['shariff'], function() {});
