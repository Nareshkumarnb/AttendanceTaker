
// Declare module.
var appCtrl = angular.module('myApp.Controllers', ['toastr']);

// Controller for the navigation bar.
appCtrl.controller('NavbarCtrl', function ($scope, $rootScope, $location, RestSvcs, MySession) {
    // Update name displayed at header when user changes.
    $scope.user = null;
    $rootScope.$on('userUpdated', function () {
        $scope.user = MySession.user !== null? MySession.user.username : null;
    });
    
    /**
     * Fuction invoked the first time that the page is loaded.
     */
    $scope.init = function() {
        // Call the ping service to verify if the user is logged and if is an administrator.
        RestSvcs.ping(function(userLogged) {
            // If the user is not logged or if is not an administrator, redirect to the login page.
            if(userLogged !== true || !MySession.user.is_admin) {
                $location.path("/login");
            }
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    };
});


// Controller for the home page.
appCtrl.controller('IntroCtrl', function ($scope, $location) {
    // Go method.
    $scope.go = function(path) {
        $location.path(path);
    };
});

// Controller for the login view.
appCtrl.controller('LoginCtrl', function ($scope, $rootScope, $route, $location, toastr, RestSvcs, MySession) {
    // Define variables.
    $scope.user = {name: MySession.user !== null? MySession.user.username : null, pass: null};
    $scope.logged = MySession.isLogged();
    $rootScope.$on('userUpdated', function () {
        $route.reload();
    });

    // Define login method.
    $scope.login = function() {
        // Verify parameters.
        if($scope.user.name === null || $scope.user.name.length <= 0) { 
            toastr.error("The username can't be empty", null);
            return;
        }
        if($scope.user.pass === null || $scope.user.pass.length <= 0) {
            toastr.error("The password can't be empty", null); 
            return;
        }
        
        // Invoke login service.
        RestSvcs.login($scope.user.name, $scope.user.pass, function(logged) {
            // Clear the password.
            $scope.user.pass = '';

            // If logged, redirect to the main page.
            if(logged) {
                $location.path("/");
            }
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    };
    
    // Define logout method.
    $scope.logout = function() {
        // Invoke logout service.
        RestSvcs.logout(function(success) {
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    };
});

