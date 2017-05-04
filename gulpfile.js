var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglifyjs'),
    uglifycss = require('gulp-uglifycss'),
    imagemin = require('gulp-imagemin'),
    express = require('express');

gulp.task('styles', function () {
    return gulp.src([
        'resources/assets/sass/*.sass',
        'resources/assets/css/Highlighter/*.css',
        'resources/assets/css/*.css'
    ])
        .pipe(sass())
        .pipe(concat('app.min.css'))
        .pipe(uglifycss({
            "uglyComments": true
        }))
        .pipe(gulp.dest('public/css'))
});

gulp.task('scripts', function () {
    return gulp.src([
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
    ])
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('public/js'));
});

gulp.task('img', function () {
    return gulp.src('resources/assets/img/*')
        .pipe(imagemin())
        .pipe(gulp.dest('public/img'));
});

gulp.task('watch', ['styles', 'scripts'], function () {
    gulp.watch('resources/assets/sass/*.sass', ['styles']);
    gulp.watch('resources/assets/js/*.js', ['scripts']);
});
