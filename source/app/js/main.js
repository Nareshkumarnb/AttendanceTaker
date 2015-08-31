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
        
        .when('/take', {
            controller: 'SelectGroupAndEventCtrl',
            templateUrl: 'app/views/select-group-and-event.html'
        })
        .when('/assistance/:groupId/:eventId/:date', {
            controller: 'AssistanceCtrl',
            templateUrl: 'app/views/edit-assistance.html'
        })
        .when('/lists/:date1/:date2', {
            controller: 'RecordsCtrl',
            templateUrl: 'app/views/list-assistances.html'
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
        
        .when('/group/:id', {
            controller: 'SimpleFormCtrl',
            templateUrl: 'app/views/edit-simple.html',
            resolve: { 
                dataType: function() {return 'group';},
                returnUrl: function() {return '/groups';},
                defaultEntry: function() {return {id: null, name: '', disabled: 0};} 
            }
        })
        .when('/event/:id', {
            controller: 'SimpleFormCtrl',
            templateUrl: 'app/views/edit-simple.html',
            resolve: { 
                dataType: function() {return 'event';},
                returnUrl: function() {return '/events';},
                defaultEntry: function() {return {id: null, name: '', disabled: 0};} 
            }
        })
        .when('/user/:id', {
            controller: 'UserCtrl',
            templateUrl: 'app/views/edit-user.html'
        })
        .when('/person/:id', {
            controller: 'PersonCtrl',
            templateUrl: 'app/views/edit-person.html'
        })
    ;
});


