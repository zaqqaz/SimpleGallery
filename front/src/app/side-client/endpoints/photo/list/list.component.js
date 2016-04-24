import template from './list.html';

class ListController {
    constructor($log, $stateParams, PhotoManager, AlbumManager, Loader, $state) {
        "ngInject";
        this.page = $stateParams.page <= 0 ? 1 : $stateParams.page;
        this._PhotoManager = PhotoManager;
        this._AlbumManager = AlbumManager;
        this._$state = $state;
        this.albumId = $stateParams.albumId;
        this._Loader = Loader;
        this.photos = [];
        this.totalCount = 0;
        this.itemsPerPage = 9;

        this.activate();
    }

    activate() {
        this._AlbumManager.getById(this.albumId)
            .then((album) => {
                this.album = album;
            });
        this.loadPhotos().then(() => this.initialized = true);
    }

    get currentPage(){
        return this.page;
    }

    set currentPage(page) {
        this._$state.go('photos', {page: page, albumId: this.albumId});
    }

    loadPhotos() {
        this._Loader.start();
        return this._PhotoManager.query({album_id: this.albumId, limit: this.itemsPerPage, offset: ((this.page-1) * this.itemsPerPage || 0)})
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