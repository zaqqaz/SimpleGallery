function routeConfig($stateProvider) {
    'ngInject';

    $stateProvider
        .state('photos', {
            url: '/photos/:albumId/:page',
            template: '<list-photos class="photo"></list-photos>'
        });

    $stateProvider
        .state('photoEditor', {
            url: '/photo/:albumId/:photoId',
            template: '<photo-editor class="photo"></photo-editor>'
        });
}

export default routeConfig;