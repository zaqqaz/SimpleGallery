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

    get image_url() {
        return this.image.path + this.image.name;
    }

    beforeSave() {
        this.image = this.image.id;
    }
}

export default Photo;