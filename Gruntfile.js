module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt);

  grunt.initConfig({
    less: {
      dev: {
        options: {
          paths: ['less/']
        },
        files: {
          'style.css': 'less/index.less',
        }
      }
    },

    requirejs: {
      dist: {
        options: {
          baseUrl: 'js/dev',
          name: 'main',
          mainConfigFile: 'js/dev/main.js',
          out: 'js/dist/main.js',
          optimize: 'uglify2',
          paths: {
            requireLib: '../../bower_components/requirejs/require',
          },
          include: [
            'requireLib',
          ],
          uglify2: {
            output: {
              beautify: false,
            },
          }
        },
      },
    },

    watch: {
      less: {
        files: ['less/**/*.less',],
        tasks: ['less',],
        options: {
          spawn: false,
        },
      },
      js: {
        files: ['js/**/*.js',],
        tasks: ['requirejs',],
        options: {
          spawn: false,
        },
      },
    },
  });

  grunt.registerTask('compile', ['less', 'requirejs']);
};
