import template from './image-viewer.html';

class ImageViewerController {
    constructor($uibModal, $scope) {
        "ngInject";
        this._$uibModal = $uibModal;
        this.test = 'test';
        this.modalConfig = {
            template: template,
            scope: $scope
        };
    }

    openModal() {
        return this._$uibModal.open(this.modalConfig);
    }
}

export default (() => {
    return {
        template: '<ng-transclude ng-click="$ctrl.openModal();"></ng-transclude>',
        transclude: true,
        controller: ImageViewerController,
        bindToController: true,
        controllerAs: '$ctrl',
        scope: {
            image: '=',
            title: '=',
            description: '='
        }
    }
});