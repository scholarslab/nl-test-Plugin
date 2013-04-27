
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=2 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

module.exports = function(grunt) {

  grunt.loadNpmTasks('grunt-contrib-jasmine');
  grunt.loadNpmTasks('grunt-contrib-connect');
  grunt.loadNpmTasks('grunt-symbolic-link');
  grunt.loadNpmTasks('grunt-shell');

  var nlCfg = grunt.file.readJSON('../Neatline/config.json');

  grunt.initConfig({

    shell: {
      options: {
        stdout: true
      },
      phpunit: {
        command: 'phpunit --color',
        options: {
          execOptions: {
            cwd: './tests/phpunit'
          }
        }
      }
    },

    symlink: {
      neatline: {
        link: './Neatline',
        target: '../Neatline',
        options: {
          overwrite: true
        }
      }
    },

    connect: {
      server: {
        options: {
          keepalive: true,
          port: 1337
        }
      }
    },

    jasmine: {

      options: {
        helpers: [
          './Neatline/'+nlCfg.vendor.js.jasmine_jquery,
          './Neatline/'+nlCfg.vendor.js.jasmine_async,
          './Neatline/'+nlCfg.vendor.js.sinon,
          './Neatline/'+nlCfg.jasmine+'/helpers/*.js'
        ]
      },

      editor: {
        src: './Neatline/'+nlCfg.payloads.shared.js+'/neatline-editor.js',
        options: {
          specs: './tests/jasmine/suites/editor/**/*.spec.js'
        }
      }

    }

  });

  // Run tests.
  grunt.registerTask('default', 'phpunit');

  // Run PHPUnit.
  grunt.registerTask('phpunit', 'shell:phpunit');

  // Mount editor Jasmine suite.
  grunt.registerTask('jasmine:editor:server', [
    'jasmine:editor:build',
    'connect'
  ]);

};
