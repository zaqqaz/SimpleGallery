import template from './list.html';

class ListController {
    constructor($log, $stateParams, AlbumManager, Loader, $state) {
        "ngInject";
        this._AlbumManager = AlbumManager;
        this._$state = $state;
        this._Loader = Loader;
        this.page = $stateParams.page <= 0 ? 1 : $stateParams.page;
        this.albums = [];
        this.totalCount = 0;
        this.itemsPerPage = 9;

        this.activate();
    }

    activate() {
        this.loadAlbums().then(() => this.initialized = true);
    }

    get currentPage(){
        return this.page;
    }

    set currentPage(page) {
        this._$state.go('albums', {page: page});
    }

    loadAlbums() {
        this._Loader.start();
        return this._AlbumManager.query({limit: this.itemsPerPage, offset: (this.page-1) * this.itemsPerPage})
            .then(([albums, headers])=> {
                this.albums = albums;
                this.totalCount = headers['x-total-count'];
                this._Loader.complete();
            })
    }
}

export default {
    template: template,
    controller: ListController
};