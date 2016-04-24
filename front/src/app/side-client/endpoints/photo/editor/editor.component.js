import template from './editor.html';
import Photo from './../../../../api/models/Photo';

class EditorController {
    constructor($state, $stateParams, PhotoManager) {
        "ngInject";
        this._$state = $state;
        this._PhotoManager = PhotoManager;
        this.id = $stateParams.photoId;
        this.isCreateMode = (this.id && this.id.toLowerCase() === 'create') ? true : false;
        this.savedResult = null;
        this.photo = new Photo({});
        this.photo.album.id = $stateParams.albumId;

        this._activate();
    }

    _activate() {
        if (!this.isCreateMode) {
            this._PhotoManager.getById(this.id)
                .then((photo) => {
                    this.photo = photo;
                });
        }
    }

    imageLoaded(response) {
        this.photo.image = response;
    }

    save(photo) {
        if(!photo.name || !photo.image.id){
            throw new Error('Please fill the required fields');
        }

        return this._PhotoManager.save(photo)
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