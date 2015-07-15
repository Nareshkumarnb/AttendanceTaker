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
    ;
});


