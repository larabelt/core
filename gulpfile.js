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

    copy_files('./base/client/**/*', '../../../public/client/core/base');
    copy_files('./role/client/**/*', '../../../public/client/core/role');
    copy_files('./user/client/**/*', '../../../public/client/core/user');
    copy_files('./user-role/client/**/*', '../../../public/client/core/user-role');

    mix_js(['./base/client/admin/uncompiled.js'], '../../../public/client/core/base/admin', 'compiled.js');
});

gulp.task('default', ['client']);

gulp.task('watch', function () {
    gulp.watch('./base/client/**/*', ['client']);
    gulp.watch('./role/client/**/*', ['client']);
    gulp.watch('./user/client/**/*', ['client']);
    gulp.watch('./user-role/client/**/*', ['client']);
});