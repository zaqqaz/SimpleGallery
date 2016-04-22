import Album from './models/Album';
import Photo from './models/Photo';

function config(apiProvider, API_URL) {
    'ngInject';

    apiProvider.setBaseRoute(API_URL);

    apiProvider.endpoint('album')
        .route('albums/:id')
        .model(Album)
        .addHttpAction('GET', 'query', {isArray: true, params: {course: '@course', unit: '@unit', lesson: '@lesson', lesson_part: '@lesson_part'}})
        .addHttpAction('PATCH', 'patch', {params: {id: '@id'}});

    apiProvider.endpoint('photo')
        .route('exercise-templates/:name')
        .model(Photo)
        .addHttpAction('GET', 'query', {isArray: true})
        .addHttpAction('PATCH', 'patch', {params: {name: '@name'}});
}

export default config;