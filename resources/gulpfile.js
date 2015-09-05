var path = require('path'),
    gulp = require('gulp'),
    $    = require('gulp-load-plugins')(),
    browserSync = require('browser-sync'),
    reload = browserSync.reload;

var sass = require('gulp-sass');

var autoprefixer = [
    'ie >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4'
];

// Sass
gulp.task('styles', function() {
    gulp.src('assets/sass/**/*scss')
        .pipe($.plumber())
        .pipe(sass())
        .pipe($.autoprefixer({browsers: autoprefixer}))
        .pipe(gulp.dest('../public/assets/css'))
        .pipe(reload({stream: true, once: true}));
});

// Other
gulp.task('serve', ['styles'], function() {
    browserSync({
        server: {baseDir: "../public/assets/css"}
    });
});

// Watch
gulp.task('start', ['serve'], function() {
    //gulp.watch('../public/**/*.{html, json}, reload');
    gulp.watch('assets/sass/**/*', ['styles']);
    //gulp.watch('assets/js/**/*', ['scripts']);
});
