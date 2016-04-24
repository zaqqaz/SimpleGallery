import {debugEnabled} from './../../parameters.config';
import {pagesConstants} from './../constants';

function config($logProvider, $translateProvider, ru, $locationProvider,
                toastr, $httpProvider, CacheFactoryProvider, $urlRouterProvider) {
    'ngInject';
    $logProvider.debugEnabled(true);

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: true
    });

    // Страница "по умолчанию"
    $urlRouterProvider.otherwise(pagesConstants.MAIN);

    // Настройки кэшера
    angular.extend(CacheFactoryProvider.defaults, {
        storageMode: 'localStorage',
        storeOnResolve: true
    });

    // Регистрируем интерсепторы для запросов
    $httpProvider.interceptors.push('AuthInterceptor');

    // Настраиваем поддержку мультиязычности (пока только русский)
    $translateProvider.translations('ru', ru);

    // Отключил sanitize так как используем константы
    $translateProvider.useSanitizeValueStrategy(false);
    $translateProvider.preferredLanguage('ru');

    // Конфигурация всплывающих сообщений
    toastr.options.closeButton = true;
    toastr.options.positionClass = 'toast-bottom-right';
}

export default config;
