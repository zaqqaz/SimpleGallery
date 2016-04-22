import template from './list.html';

class ListController {
    constructor($log, $stateParams, AlbumManager, Loader) {
        "ngInject";
        this._AlbumManager = AlbumManager;
        this.page = $stateParams.page;
        this._Loader = Loader;
        this.albums = [];
        this.totalCount = 100;
        this.limit = 9;

        this.activate();
    }

    activate() {
        this._Loader.start();
        this.loadAlbums();
    }

    set currentPage(page) {
        this.page = page;
        this.loadAlbums();
    }

    loadAlbums(){
        this._AlbumManager.query({limit: this.limit, offset:this.page * this.limit})
            .then((albums)=> {
                this.albums = albums;
                this._Loader.complete();
            })
    }
}

export default {
    template: template,
    controller: ListController
};