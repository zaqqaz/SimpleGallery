var gutil = require('gulp-util');

var isAdminSide = (gutil.env.side == 'admin');

exports.isBuildMode = false;

exports.paths = {
    initModule: '/app/side-client/index.module.js',
    src: 'src',
    app: 'src/app',
    dist: '../web',
    base_href: '/',
    tmp: '.tmp',
    e2e: 'e2e'
};

if (isAdminSide) {
    exports.paths.initModule = '/app/side-admin/index.module.js';
    exports.paths.dist += '/admin';
    exports.paths.base_href += 'admin/';
}

/**
 * Папки/файлы которые перезаписываются при билде и добавляются в гит
 */
exports.cleanDist = [
    exports.paths.dist + '/index.html',
    exports.paths.dist + '/parameters.config.js',
    exports.paths.dist + '/assets',
    exports.paths.dist + '/styles',
    exports.paths.dist + '/scripts',
    exports.paths.dist + '/fonts'
];

/**
 *  Wiredep is the lib which inject bower dependencies in your project
 *  Mainly used to inject script tags in the index.html but also used
 *  to inject css preprocessor deps and js files in karma
 */
exports.wiredep = {
    exclude: [/bootstrap.js$/, /bootstrap-sass-official\/.*\.js/, /bootstrap\.css/],
    directory: 'bower_components'
};

/**
 *  Common implementation for an error handler of a Gulp plugin
 */
exports.errorHandler = function (title) {
    'use strict';

    return function (err) {
        gutil.log(gutil.colors.red('[' + title + ']'), err.toString());
        this.emit('end');
    };
};
