var gulp = require('gulp'),
	gutil = require('gulp-util'),
	notify = require('gulp-notify'),
	watch = require('gulp-watch'),
	ftp = require('vinyl-ftp');

var gulpftp = require('./gulpconfig.js');


/**
 * Deploy Task
 * Upload changed files to remote server
 *
 * Usage: `gulp deploy`
 */
gulp.task( 'deploy', function () {
	var conn = ftp.create({
		host:     gulpftp.config.host,
		user:     gulpftp.config.user,
		password: gulpftp.config.pass,
		parallel: 20,
		log:      gutil.log,
		secure:   true,
		secureOptions: {
			rejectUnauthorized: false
		}
	});

	var globs = [
		'**/*',
		'*',
		'!node_modules',
		'!node_modules/**',
		'!src',
		'!src/**',
		'!gulpconfig.js',
		'!.git',
		'!.git/**',
		'!.gitignore',
		'!.sass-cache',
		'!.sass-cache/**',
		'!.ftpconfig',
		'!sftp-config.json',
		'!ftpsync.settings',
	];

	gulp.src(globs, { base: '.', buffer: false })
		.pipe(conn.newer( gulpftp.config.path )) // only upload newer files!
		.pipe(conn.dest( gulpftp.config.path ));
});

/**
 * Watch Task
 * Watches files and runs other tasks when changes are detected
 *
 * Usage: `gulp watch`
 */
gulp.task('watch', function() {
	// Watch PHP files and run the Deploy Task if changes are detected
	watch('*.php', function() {
		gulp.start('deploy');
	});
});
