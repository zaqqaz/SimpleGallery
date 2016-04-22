import routeConfig from './album.route';
import listComponent from './list/list.component';
import editorComponent from './editor/editor.component';

let module = angular
    .module('lessons', [])
    .config(routeConfig)
    .component('albumEditor', editorComponent)
    .component('listAlbums', listComponent)
    ;

export default module = module.name;