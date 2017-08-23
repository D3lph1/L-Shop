/**
 * Gulpfile.js for L-Shop project.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @link https://github.com/D3lph1/L-shop
 */

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglifyjs'),
    uglifycss = require('gulp-uglifycss'),
    imagemin = require('gulp-imagemin'),
    express = require('express');

// Object with configuration
var config = {
    path: {
        styles: {
            src: [
                'resources/assets/sass/*.sass',
                'resources/assets/css/Highlighter/*.css',
                'resources/assets/css/*.css'
            ],
            dest: 'public/css',
            out: 'app.min.css',
            watch: [
                'resources/assets/sass/**/*.sass',
                'resources/assets/css/**/*.css'
            ]
        },
        js: {
            src: [
                'resources/assets/js/jquery-3.1.1.min.js',
                'resources/assets/js/tether.min.js',
                'resources/assets/js/trumbowyg/trumbowyg.min.js',
                'resources/assets/js/trumbowyg/langs/ru.min.js',
                'resources/assets/js/bootstrap.min.js',
                'resources/assets/js/mdb.min.js',
                'resources/assets/js/components/*.js',
                'resources/assets/js/functions.js',
                'resources/assets/js/on-load.js',
                'resources/assets/js/common.js',
                'resources/assets/js/highlight.pack.js'
            ],
            dest: 'public/js',
            out: 'app.min.js',
            watch: 'resources/assets/js/**/*.js'
        },
        img: {
            src: 'resources/assets/img/**/*.*',
            dest: 'public/img',
            watch: 'resources/assets/img/**/*.*'
        }
    }
};

var path = config.path;

// Build styles(css, sass) to minimized css.
gulp.task('build:styles', function () {
    return gulp.src(path.styles.src)
        .pipe(sass())
        .pipe(concat(path.styles.out))
        .pipe(uglifycss({
            "uglyComments": true
        }))
        .pipe(gulp.dest(path.styles.dest))
});

// Build js to minimized js.
gulp.task('build:js', function () {
    return gulp.src(path.js.src)
        .pipe(concat(path.js.out))
        .pipe(uglify())
        .pipe(gulp.dest(path.js.dest));
});

// Optimize images.
gulp.task('build:img', function () {
    return gulp.src(path.img.src)
        .pipe(imagemin())
        .pipe(gulp.dest(path.img.dest));
});

// Run all build:* tasks
gulp.task('build', [
    'build:styles',
    'build:js',
    'build:img'
]);

gulp.task('default', ['build']);

gulp.task('watch', ['build:styles', 'build:js', 'build:img'], function () {
    gulp.watch(path.styles.watch, ['build:styles']);
    gulp.watch(path.js.watch, ['build:js']);
    gulp.watch(path.img.watch, ['build:img']);
});
