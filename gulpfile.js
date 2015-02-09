var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require('gulp-notify');
var browserSync = require('browser-sync');
var reload      = browserSync.reload;

// Default task
gulp.task('default', ['sass', 'browser-sync'], function () {
    gulp.watch("sass/**/*.scss", ['sass']);
});

gulp.task('sass', function() {
 	return gulp.src('sass/**/*.scss')
		.pipe(sass({
            style: 'expanded',
            errLogToConsole: true
        }))
		.pipe(gulp.dest('css'))
    .pipe(reload({stream:true}))
		.pipe(notify({ message: 'Styles task complete' }));
});

// browser-sync task for starting the server.
gulp.task('browser-sync', function() {
    browserSync({
        server: {
            baseDir: "./"
        }
    });
});

gulp.task('watch', function() {

  // Watch .scss files
  gulp.watch('sass/**/*.scss', ['sass']);

});
