import routeConfig from './photo.route';
import listComponent from './list/list.component';
import editorComponent from './editor/editor.component';

let module = angular
    .module('template', [])
    .config(routeConfig)
    .component('photoEditor', editorComponent)
    .component('listPhotos', listComponent)
    ;

export default module = module.name;