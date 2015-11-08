var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var connect = require('gulp-connect');

var dst = './public/assets';
var src = './resources/assets';

gulp.task('default', function() {

});

gulp.task('connect', function() {
    connect.server({
        root: './',
        livereload: true
    });
});

gulp.task('html', function() {
    gulp.src(src + '/html/*/html')
        .pipe(connect.reload());
});

gulp.task('sass', function() {
    console.log('---- sass task ----');
    return sass (src + '/sass/*.scss', {style: 'expanded'})
        .pipe(autoprefixer())
        .pipe(gulp.dest(dst + '/css'));
});

gulp.task('cssmin', function() {
    console.log('---- cssmin task ----');
    gulp.src(dst + '/css/*.css')
        .pipe(cssmin())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(dst + '/css/'));
});

gulp.task('uglify', function(){
    console.log('---- uglify task ----');
    gulp.src(src+'/js/**/*.js')
        .pipe(uglify({preserveComments: 'some'}))
        .pipe(gulp.dest(src+'/jsmin/'))
    ;
});

gulp.task('concat', function(){
    console.log('---- concat task ----');
    gulp.src(src+'/jsmin/**/*.js')
        .pipe(concat('main.min.js'))
        .pipe(gulp.dest(dst+'/js/'))
    ;
});

//watch
gulp.task('w', function(){
    var w_html = gulp.watch(src + 'html/*/html', ['html']);
    var w_sass = gulp.watch(src+'/scss/*.scss', ['sass']);
    var w_cssmin = gulp.watch(dst+'/css/*.css', ['cssmin']);
    var w_uglify = gulp.watch(src+'/js/**/*.js', ['uglify']);
    var w_concat = gulp.watch(src+'/js/**/*.js', ['concat']);

    w_html.on('change', function(event){
        console.log('html File ' + event.path + ' was ' + event.type + ', running task sass...');
    });

    w_sass.on('change', function(event){
        console.log('CSS File ' + event.path + ' was ' + event.type + ', running task sass...');
    });

    w_cssmin.on('change', function(event){
        console.log('CSS File ' + event.path + ' was ' + event.type + ', running task cssmin...');
    });

    w_uglify.on('change', function(event){
        console.log('javascript File ' + event.path + ' was ' + event.type + ', running task uglify...');
    });

    w_concat.on('change', function(event){
        console.log('javascript File ' + event.path + ' was ' + event.type + ', running task concat...');
    });
});

gulp.task('default', ['connect', 'w']);
