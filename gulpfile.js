var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglifyjs'),
    uglifycss = require('gulp-uglifycss'),
    imagemin = require('gulp-imagemin'),
    express = require('express');

gulp.task('sass', function () {
    return gulp.src([
        'resources/assets/sass/*.sass',
        'resources/assets/css/*.css',
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
        'resources/assets/js/vue.js',
        'resources/assets/js/components/*.js',
        'resources/assets/js/functions.js',
        'resources/assets/js/on-load.js',
        'resources/assets/js/common.js',
        'resources/assets/js/*.js'
    ])
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
});

gulp.task('img', function () {
    return gulp.src('resources/assets/img/*')
        .pipe(imagemin())
        .pipe(gulp.dest('public/img'));
});

gulp.task('watch', ['sass', 'scripts'], function () {
    gulp.watch('resources/assets/sass/*.sass', ['sass']);
    gulp.watch('resources/assets/js/*.js', ['scripts']);
});
