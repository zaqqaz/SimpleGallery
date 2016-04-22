function routeConfig($stateProvider) {
    'ngInject';

    $stateProvider
        .state('albums', {
            url: '/albums',
            template: '<list-albums class="album"></list-albums>'
        });

    $stateProvider
        .state('albumEditor', {
            url: '/album/:id',
            template: '<album-editor class="album"></album-editor>'
        });
}

export default routeConfig;