import {debugEnabled} from './../../parameters.config';
import {pagesConstants} from './../constants';

function config($logProvider, $translateProvider, ru, $locationProvider,
                toastr, $httpProvider, CacheFactoryProvider, $urlRouterProvider) {
    'ngInject';

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: true
    });

    angular.extend(CacheFactoryProvider.defaults, {
        storageMode: 'localStorage',
        storeOnResolve: true
    });

    $urlRouterProvider.otherwise(pagesConstants.MAIN);
    $logProvider.debugEnabled(true);
    $translateProvider.useSanitizeValueStrategy(false);
    $httpProvider.interceptors.push('AuthInterceptor');
    $translateProvider.translations('ru', ru);
    $translateProvider.preferredLanguage('ru');
    toastr.options.closeButton = true;
    toastr.options.positionClass = 'toast-bottom-right';

}

export default config;
