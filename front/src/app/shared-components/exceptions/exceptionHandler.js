export function exceptionConfig($provide) {
    "ngInject";
    $provide.decorator('$exceptionHandler', extendExceptionHandler);
}

export function extendExceptionHandler($delegate, alert) {
    "ngInject";

    return (exception, cause) => {
        $delegate(exception, cause);
        alert( exception.message, '', 'error');
    };
}
