class PhotoManager {
    constructor($log, api) {
        'ngInject';

        this.$log = $log;
        this.api = api;
    }

    query(queryParams = {}) {
        return this.api.photo.query(queryParams);
    }

    save(photo) {
        return (photo.id) ? this.api.photo.patch(photo) :
            this.api.photo.save(angular.merge(photo));
    }
}

export default PhotoManager;