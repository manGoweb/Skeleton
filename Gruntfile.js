/**
 * Configuration part of following grunt tasks
 */

var STYLE_FILES = [
	'www/styles/screen.styl'
];

var JS_FILES = [
	'www/js/plugins.js',
	'www/js/init.js'
];

var DIST_FOLDER = 'www/build';

var HASH_SOURCES = [
	DIST_FOLDER + '/*.css',
	DIST_FOLDER + '/*.js'
];

var WATCH_FILES = [
	DIST_FOLDER + '/*'
];


/**
 * Grunt project itself with defined tasks and theirs options
 */
module.exports = function(grunt) {
	grunt.initConfig({

		// Clean dist folder from obsolete files
		clean: {
			dist: DIST_FOLDER + '/*'
		},

		// Compile Stylus styles into CSS
		stylus: {

			dev: {
				options: {
					'include css': true,
					compress: false
				},
				expand: true,
				flatten: true,
				src: STYLE_FILES,
				dest: DIST_FOLDER + '/',
				ext: '.css'
			},

			dist: {
				options: {
					'include css': true
				},
				expand: true,
				flatten: true,
				src: STYLE_FILES,
				dest: DIST_FOLDER + '/',
				ext: '.css'
			}

		},

		// Concat and minify JavaScript files to single app.js file
		uglify: {

			dev: {
				options: {
					compress: false,
					sourceMap: true
				},
				files: (function() {
					var files = {};
					files[DIST_FOLDER + '/app.js'] = JS_FILES;
					return files;
				})()
			},

			dist: {
				files: (function() {
					var files = {};
					files[DIST_FOLDER + '/app.js'] = JS_FILES;
					return files;
				})()
			}

		},

		// Minify CSS even more, every byte counts
		cssmin: {
			dist: {
				expand: true,
				cwd: DIST_FOLDER + '/',
				src: '*.css',
				dest: DIST_FOLDER + '/'
			}
		},

		// Development mode with resources auto reload and browser actions synchronizations
		browserSync: {

			dev: {
				options: {
					watchTask: true,
					debugInfo: true,
					// Only static files
					server: {
						baseDir: '.',
						index: DIST_FOLDER + '/index.html'
					},
					// Dynamic files (PHP etc) - proxy to running server
					// proxy: 'localhost',
					ghostMode: {
						clicks: true,
						scroll: true,
						links: false,
						forms: true
					}
				},
				bsFiles: {
					src: WATCH_FILES
				}
			}

		},

		// Watch sources for change and compile them. Starts Livereload server as fallback of browserSync.
		watch: {

			options: {
				spawn: false
			},

			styles: {
				files: 'www/styles/**/*.styl',
				tasks: 'stylus:dev'
			},

			js: {
				files: 'www/js/**/*.js',
				tasks: 'uglify:dev'
			},

			livereload: {
				files: WATCH_FILES,
				options: {
					livereload: true
				}
			}

		}

	});

	// Load plugins
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-notify');

	// Register tasks
	grunt.registerTask('default', ['clean:dist', 'stylus:dist', 'uglify:dist', 'cssmin:dist']);
	grunt.registerTask('dev', ['clean:dist', 'stylus:dev', 'uglify:dev', 'browserSync:dev', 'watch']);

};
