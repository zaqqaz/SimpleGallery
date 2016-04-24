import Album from './../models/Album';

class AlbumManager {
    constructor($log, api) {
        'ngInject';

        this.$log = $log;
        this.api = api;
    }

    getById(AlbumId) {
        return this.api.album.get({id: AlbumId});
    }

    query(queryParams = {}) {
        return this.api.album.query(queryParams);
    }

    save(album) {
        return (album.id) ? this.api.album.patch(album) : this.api.album.save(album);
    }
}

export default AlbumManager;