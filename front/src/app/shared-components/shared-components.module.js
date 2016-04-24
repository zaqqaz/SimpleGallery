import * as angularLocale from './dictionaries/angular-locale_ru';

// Constants
import {ru} from './dictionaries/ru';

// Directives
import clickOnce from './click-once/click-once.directive';
import restrictInput from './restrictInput/restrictInput.directive';
import imageViewer from './image-viewer/image-viewer.directive';

// Services
import AuthInterceptor from  './auth/auth.interceptor';
import Loader from './loader/loader.service';

//components
import loadFile from './load-file/load-file.component';

let sharedComponents = angular.module('shared-components', [
        'ngProgress',
        'pascalprecht.translate'
    ])
    .constant('ru', ru)
    .service('AuthInterceptor', AuthInterceptor)
    .service('Loader', Loader)
    .directive('clickOnce', () => new clickOnce)
    .directive('restrictInput', () => new restrictInput)
    .directive('imageViewer', imageViewer)
    .component('loadFile', loadFile)
    ;

export default sharedComponents = sharedComponents.name;

