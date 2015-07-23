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

    watch: {
      less: {
        files: ['less/**/*.less',],
        tasks: ['less',],
        options: {
          spawn: false,
        },
      },
    },
  });

  grunt.registerTask('compile', ['less',]);
};
