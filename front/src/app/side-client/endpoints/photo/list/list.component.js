import template from './list.html';

class ListController {
    constructor(ExerciseTemplateManager) {
        "ngInject";
        this._ExerciseTemplateManager = ExerciseTemplateManager;
        this.exerciseTemplates = [];

        this._activate();
    }

    _activate() {
        this._ExerciseTemplateManager.query()
            .then((exerciseTemplates) => {
                return this.exerciseTemplates = exerciseTemplates
            });
    }
}

export default {
    template: template,
    controller: ListController
};