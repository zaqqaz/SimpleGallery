import template from './list.html';

class ListController {
    constructor($log, $stateParams, PhotoManager, Loader) {
        "ngInject";
        this._PhotoManager = PhotoManager;
        this.page = $stateParams.page;
        this._Loader = Loader;
        this.photos = [];
        this.totalCount = 0;
        this.itemsPerPage = 0;
        this.limit = 9;

        this.activate();
    }

    activate() {
        this.loadPhotos();
    }

    set currentPage(page) {
        this.page = page;
        this.loadPhotos();
    }

    loadPhotos() {
        this._Loader.start();
        this._PhotoManager.query({limit: this.limit, offset: this.page * this.limit})
            .then(([photos, headers])=> {
                this.photos = photos;
                this.totalCount = headers['x-total-count'];
                console.log(this.totalCount);
                this._Loader.complete();
            })
    }
}

export default {
    template: template,
    controller: ListController
};