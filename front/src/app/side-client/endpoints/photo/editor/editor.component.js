import template from './editor.html';

class EditorController {
    constructor($stateParams) {
        "ngInject";
        this.type = $stateParams.type;
    }

    reload() {
        return this.$state.reload();
    }

}

export default {
    template: template,
    controller: EditorController
};