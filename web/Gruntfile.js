module.exports = function (grunt) {
    'use strict';
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        autoprefixer: {
            options: {
            },
            no_dest: {
                src: 'app/view/css/main.css'
            }
        },
        sass_compile_imports: {
            options: {
                importPath: 'modulo/'
            },
            compile: {
                target: 'dev/css/sass/_imported.scss',
                files: [{
                        expand: true,
                        cwd: 'dev/css/sass/modulo/',
                        src: ['**/*.scss']
                    }]
            }
        },
        compile: {
            options: {
                cssDir: 'app/view/css/'
            }
        },
        compass: {
            main_pcagenda: {
                options: {
                    sassDir: 'dev/css/sass/',
                    cssDir: 'app/view/css/'
                }
            },
        },
        jshint: {
            options: {
                node: true,
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                unused: true,
                eqnull: true,
                browser: true,
                globals: {jQuery: true},
                boss: true
            },
            gruntfile: {
                src: 'gruntfile.js'
            },
            lib_test: {
                src: ['lib/**/*.js', 'test/**/*.js']
            }
        },
        qunit: {
            files: ['test/**/*.html']
        },
        uglify: {
            my_target: {
                files: {
                    'app/view/css/uglify': ['app/view/css/uglify/uglifed/*']
                }
            }
        },
        watch: {
            gruntfile: {
                files: '<%= jshint.gruntfile.src %>',
                tasks: ['jshint:gruntfile']
            },
            sassPcagenda: {
                files: ['dev/css/**/*.scss'],
                tasks: ['sass_compile_imports:compile', 'compass:main_pcagenda']
            },
        },
    });
    // These plugins provide necessary tasks
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-webfont');
    grunt.loadNpmTasks('grunt-sass-compile-imports');
    // Default task
    grunt.registerTask('default', [
        'compass',
        'concat',
        'jshint',
        'qunit',
        'uglify',
        'sass-import'
    ]);
    // Update Dispo Engine Style
    grunt.registerTask('dispo', [
        'compass:dispo',
        'cssmin',
    ]);
};