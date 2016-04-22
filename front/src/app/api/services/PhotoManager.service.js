class PhotoManager {
    constructor($log, api) {
        'ngInject';

        this.$log = $log;
        this.api = api;
    }

    query(queryParams = {}) {
        return this.api.photo.query(queryParams);
    }

    getByName(name) {
        return this.api.photo.get({name: name});
    }

    save(photo) {
        return (photo.name) ? this.api.photo.patch(photo) : this.api.photo.save(photo);
    }
}

export default PhotoManager;