import template from './list.html';

class ListController {
    constructor($log, $stateParams, PhotoManager, AlbumManager, Loader) {
        "ngInject";
        this._PhotoManager = PhotoManager;
        this._AlbumManager = AlbumManager;
        this.albumId = $stateParams.albumId;
        this.page = $stateParams.page;
        this._Loader = Loader;
        this.photos = [];
        this.totalCount = 0;
        this.itemsPerPage = 0;
        this.limit = 9;

        this.activate();
    }

    activate() {
        this._AlbumManager.getById(this.albumId)
            .then((album) => {
                this.album = album;
            });
        this.loadPhotos();
    }

    set currentPage(page) {
        this.page = page;
        this.loadPhotos().then(() => this.initialized = true);
    }

    loadPhotos() {
        this._Loader.start();
        return this._PhotoManager.query({album_id: this.albumId, limit: this.limit, offset: (this.page * this.limit || 0) })
            .then(([photos, headers])=> {
                this.photos = photos;
                this.totalCount = headers['x-total-count'];
                this._Loader.complete();
            })
    }
}

export default {
    template: template,
    controller: ListController
};