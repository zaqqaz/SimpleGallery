import template from './list.html';

class ListController {
    constructor($log, $stateParams, AlbumManager, Loader) {
        "ngInject";
        this._AlbumManager = AlbumManager;
        this.page = $stateParams.page;
        this._Loader = Loader;
        this.albums = [];
        this.totalCount = 0;
        this.itemsPerPage = 0;
        this.limit = 9;

        this.activate();
    }

    activate() {
        this.loadAlbums();
    }

    set currentPage(page) {
        this.page = page;
        this.loadAlbums();
    }

    loadAlbums(){
        this._Loader.start();
        this._AlbumManager.query({limit: this.limit, offset:this.page * this.limit})
            .then(([albums, headers])=> {
                this.albums = albums;
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