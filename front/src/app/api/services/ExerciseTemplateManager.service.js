class ExerciseTemplateManager {
    constructor($log, api) {
        'ngInject';

        this.$log = $log;
        this.api = api;
    }

    query(queryParams = {}) {
        return this.api.exerciseTemplate.query(queryParams);
    }

    getByName(name) {
        return this.api.exerciseTemplate.get({name: name});
    }

    save(exerciseTemplate) {
        return (exerciseTemplate.name) ? this.api.exerciseTemplate.patch(exerciseTemplate) : this.api.exerciseTemplate.save(exerciseTemplate);
    }
}

export default ExerciseTemplateManager;