'use strict';

var services = angular.module('beerOMeter.services',
    ['ngResource']);

services.factory('Language', ['$resource',
    function($resource) {
		return $resource('/languages/api/:id', {id: '@id'});
}]);

services.factory('LanguageCode', ['$resource',
    function($resource) {
		return $resource('/languagecodes/api');
}]);

services.factory('Country', ['$resource',
    function($resource) {
		return $resource('/countries/api/:id', {id: '@id'});
}]);

services.factory('Question', ['$resource',
    function($resource) {
		return $resource('/questions/api/:id', {id: '@id'});
}]);

services.factory('District', ['$resource',
    function($resource) {
		return $resource('/districts/api/:id', {id: '@id'});
}]);
services.factory('Party', ['$resource',
    function($resource) {
		return $resource('/parties/api/:id', {id: '@id'});
}]);
services.factory('Candidate', ['$resource',
    function($resource) {
		return $resource('/candidates/api/:id', {id: '@id'});
}]);