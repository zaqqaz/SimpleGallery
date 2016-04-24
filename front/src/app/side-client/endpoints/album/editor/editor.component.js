import template from './editor.html';
import Album from './../../../../api/models/Album';

class EditorController {
    constructor($state, $stateParams, AlbumManager) {
        "ngInject";
        this._$state = $state;
        this._AlbumManager = AlbumManager;
        this.id = $stateParams.id;
        this.isCreateMode = (this.id && this.id.toLowerCase() === 'create') ? true : false;
        this.savedResult = null;
        this.album = new Album({});

        this._activate();
    }

    _activate() {
        if (!this.isCreateMode) {
            this._AlbumManager.getById(this.id)
                .then((album) => {
                    this.album = album;
                });
        }
    }

    imageLoaded(response) {
        this.album.image = response;
    }

    save(album) {
        if(!album.name || !album.image.id){
            throw new Error('Please fill the required fields');
        }

        return this._AlbumManager.save(album)
            .then(() => {
                return this.savedResult = 'SUCCESS'
            })
            .catch(() => {
                return this.savedResult = 'FAIL'
            });
    }

    reload() {
        return this._$state.reload();
    }

}

export default {
    template: template,
    controller: EditorController
};