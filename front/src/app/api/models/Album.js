class Album {
    constructor({id, name, description, image}) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.image = image || {};;
    }

    get image_url() {
        return this.image.path + this.image.name;
    }

    beforeSave() {
        this.image = this.image.id;
    }
}

export default Album;