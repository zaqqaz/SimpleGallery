import Album from './models/Album';
import Photo from './models/Photo';

function config(apiProvider, API_URL) {
    'ngInject';

    apiProvider.setBaseRoute(API_URL);

    apiProvider.endpoint('album')
        .route('albums/:id')
        .model(Album)
        .addHttpAction('GET', 'query', {isArray: true, headersForReading: ['x-total-count']})
        .addHttpAction('PATCH', 'patch', {params: {id: '@id'}});

    apiProvider.endpoint('photo')
        .route('albums/:album_id/photos/:id')
        .model(Photo)
        .addHttpAction('GET', 'query', {isArray: true, headersForReading: ['x-total-count']})
        .addHttpAction('POST', 'save', {params: {album_id: '@album_id'}})
        .addHttpAction('PATCH', 'patch', {params: {album_id: '@album_id'}});
}

export default config;