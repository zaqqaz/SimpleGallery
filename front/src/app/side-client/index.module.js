/* global malarkey:false, toastr:false, moment:false */
import config from './index.config';
import runBlock from './index.run';

import sharedComponents from './../shared-components/shared-components.module';
import api from './../api/api.module';

import album from './endpoints/album/album.module';
import photo from './endpoints/photo/photo.module';

/////////////////////////////

angular.module('front', [
        'parameters.config',
        'ngAnimate',
        'ngCookies',
        'ngTouch',
        'ngSanitize',
        'ngResource',
        'ui.router',
        'ui.bootstrap',
        'angular-cache',
        'angularFileUpload',
        'ngTagsInput',
        sharedComponents,
        api,
        album,
        photo
    ])
    .constant('toastr', toastr)
    .constant('moment', moment)
    .constant('alert', swal)
    .constant('localStorage', localStorage)

    .config(config)
    .run(runBlock)
;