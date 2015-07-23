// Declare app module.
var app = angular.module('myApp', ["ngRoute", "mobile-angular-ui", "myApp.Services", "myApp.Controllers"]);
        
// Define routes.
app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            controller: 'IntroCtrl',
            templateUrl: 'app/views/intro.html'
        })
        .when('/login', {
            controller: 'LoginCtrl',
            templateUrl: 'app/views/login.html'
        })
        .when('/records', {
            controller: 'RecordsCtrl',
            templateUrl: 'app/views/list-assistances.html',
            resolve: { dataType: function() {return 'assistance';} }
        })
        .when('/events', {
            controller: 'ListCtrl',
            templateUrl: 'app/views/list-events.html',
            resolve: { dataType: function() {return 'event';} }
        })
        .when('/groups', {
            controller: 'ListCtrl',
            templateUrl: 'app/views/list-groups.html',
            resolve: { dataType: function() {return 'group';} }
        })
        .when('/users', {
            controller: 'ListCtrl',
            templateUrl: 'app/views/list-users.html',
            resolve: { dataType: function() {return 'user';} }
        })
        .when('/persons', {
            controller: 'PersonsCtrl',
            templateUrl: 'app/views/list-persons.html'
        })
    ;
});


