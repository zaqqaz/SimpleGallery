import {AUTH_EVENTS} from './auth.constant'

class AuthInterceptor {
    constructor($rootScope, $q) {
        'ngInject';

        this.responseError = (response) => {
            $rootScope.$broadcast({
                401: AUTH_EVENTS.notAuthenticated,
                403: AUTH_EVENTS.notAuthorized
            } [response.status], response);

            return $q.reject(response);
        }
    }


}

export default AuthInterceptor;