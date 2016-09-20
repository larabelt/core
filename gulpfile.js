var concat = require('gulp-concat');
var gulp = require('gulp');
var include = require('gulp-include');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');

function copy_files(input, output) {
    return gulp
        .src(input)
        .pipe(gulp.dest(output));
}

function mix_js(input, output, filename) {
    return gulp
        .src(input)
        .pipe(concat(filename))
        .pipe(include())
        .on('error', console.log)
        .pipe(gulp.dest(output));
}

gulp.task('client', function () {
    copy_files('./client/**/*', '../../../public/client/core/');
    mix_js(['./client/base/admin/uncompiled.js'], '../../../public/client/core/base/admin', 'compiled.js');
});

gulp.task('default', ['client']);

gulp.task('watch', function () {
    gulp.watch('./client/**/*', ['client']);
});