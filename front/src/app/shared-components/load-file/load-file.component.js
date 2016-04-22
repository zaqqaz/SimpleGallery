import {userConstants} from './../../constants';
import template from './load-file.html';

/** @ngInject */
class LoadFileController {
    constructor(FileUploader, API_URL) {
        "ngInject";

        let initParams = {
            headers: {},
            url: API_URL + this.url
        };
        //initParams.headers[userConstants.AUTH_HEADER_KEY] = $http.defaults.headers.common[userConstants.AUTH_HEADER_KEY];

        this.loading = false;
        this.success = false;
        this.error = false;

        this.uploader = new FileUploader(initParams);
        this.uploader.onAfterAddingFile = this.onAfterAddingFile.bind(this);
        this.uploader.onProgressItem = this.onProgressItem.bind(this);
        this.uploader.onSuccessItem = this.onSuccessItem.bind(this);
        this.uploader.onErrorItem = this.onErrorItem.bind(this);
    }

    repeat() {
        this.loading = false;
        this.success = false;
        this.error = false;
    };

    onAfterAddingFile(fileItem) {
        if (this.loading) {
            return;
        }

        if (this.params) {
            fileItem.url += '?' + $httpParamSerializerJQLike(this.params);
        }

        fileItem.upload();
    }

    onProgressItem(fileItem, progress) {
        this.loading = true;
    }

    onSuccessItem(item, response) {
        this.loading = false;
        this.success = true;

        if (this.callback) {
            this.callback({response: response});
        }

        if (this.successMessageTemplate) {
            this.successMessage = this.successMessageTemplate.replace(/%(.+?)%/gi, function (str, offset, s) {
                str = response[offset];
                return str;
            });
        }
    }

    onErrorItem(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
        this.errorMessage = response.error;
        this.loading = false;
        this.error = true;
    }
}

export default {
    template: template,
    controller: LoadFileController,
    bindings: {
        url: '@',
        params: '=',
        callback: '&',
        successMessageTemplate: '@',
        label: '@'
    }
};

