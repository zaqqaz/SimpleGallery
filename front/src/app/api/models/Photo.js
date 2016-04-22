class Photo {
    constructor({id, name, description, image, album}) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.album = album || {};
        this.image = image || {};
    }

    get album_id() {
        return this.album.id;
    }

    beforeSave() {
        this.image = this.image.id;
    }
}

export default Photo;