function routeConfig($stateProvider) {
    'ngInject';

    $stateProvider
        .state('photos', {
            url: '/exercise-templates',
            template: '<list-templates class="template"></list-templates>'
        });

    $stateProvider
        .state('base.exerciseTemplateEditor', {
            url: '/exercise-template/:type',
            template: '<template-editor class="template"></template-editor>'
        });
}

export default routeConfig;