'use strict';

let path = require('path');
let gulp = require('gulp');
let conf = require('./conf');
let browserSync = require('browser-sync');
let $ = require('gulp-load-plugins')();

function webpack(watch, callback) {
    let webpackOptions = {
        watch: watch,
        module: {
            //preLoaders: [{test: /\.js$/, exclude: /node_modules/, loader: 'jshint-loader'}],
            loaders: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    loader: 'babel-loader'
                },
                {
                    test: /\.html$/,
                    loader: 'raw?minimize=false'
                }
            ]
        },
        output: {filename: 'index.module.js'}
    };

    if (watch) {
        webpackOptions.devtool = 'inline-source-map';
    }

    let webpackChangeHandler = function (err, stats) {
        if (err) {
            conf.errorHandler('Webpack')(err);
        }
        $.util.log(stats.toString({
            colors: $.util.colors.supportsColor,
            chunks: false,
            hash: false,
            version: false
        }));
        browserSync.reload();
        if (watch) {
            watch = false;
            callback();
        }
    };

    return gulp.src(path.join(conf.paths.src, conf.paths.initModule))
        .pipe($.webpack(webpackOptions, null, webpackChangeHandler))
        .pipe($.ngAnnotate())
        .pipe(gulp.dest(path.join(conf.paths.tmp, '/serve/app')));
}

gulp.task('scripts', function () {
    return webpack(false);
});

gulp.task('scripts:watch', ['scripts'], function (callback) {
    return webpack(true, callback);
});
