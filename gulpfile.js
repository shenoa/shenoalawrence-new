var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require('gulp-notify');
var browserSync = require('browser-sync');
var reload      = browserSync.reload;
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var minifyCSS = require('gulp-minify-css');


// Default task
gulp.task('default', ['sass', 'browser-sync'], function () {
    gulp.watch("sass/**/*.scss", ['sass']);
});

// Compile Sass files
gulp.task('sass', function() {
  return gulp.src('sass/**/*.scss')
        .pipe(sass({ style: 'expanded', errLogToConsole: true }))
    .pipe(gulp.dest('css'))
    .pipe(reload({stream:true}))
    .pipe(notify({ message: 'Styles task complete' }));
});

// Browser-sync task for starting the server
gulp.task('browser-sync', function() {
    browserSync({
        server: {
            baseDir: "./"
        }
    });
});

// File and folder watching
gulp.task('watch', function() {
  gulp.watch('sass/**/*.scss', ['sass']);
});

// Optimization images
//gulp.task('images' function() {
//    return gulp.src('src/images/*')
//        .pipe(imagemin({
//            progressive: true,
//            svgoPlugins: [{removeViewBox: false}],
//            use: [pngquant()]
//        }))
//        .pipe(gulp.dest('images'));
//});

// minify CSS
//gulp.task('minify-css', function() {
//   gulp.src('css/*.css')
//     .pipe(minifyCSS({keepBreaks:true}))
//     .pipe(gulp.dest('css/'))
// });

// pre-deploy prep tasks
//gulp.task('prep', ['imagemin', 'minify-css'], function() {
//});

// possibly deploy to s3 using https://gist.github.com/michaelcolenso/c9b911c3c3a0cff36e63

