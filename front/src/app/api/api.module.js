import config from './api.config';
import AlbumManager from './services/AlbumManager.service'
import PhotoManager from './services/PhotoManager.service'

let api = angular
    .module('api', ['ng-rest-api'])
    .config(config)
    .service('AlbumManager', AlbumManager)
    .service('PhotoManager', PhotoManager)
    ;

export default api = api.name;
