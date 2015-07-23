
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
            if(userLogged !== true) {
                $location.path("/login");
            }
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    };
});


// Controller for the home page.
appCtrl.controller('IntroCtrl', function ($scope, $rootScope, $location, MySession) {
    // Verify if the user is admin.
    $scope.isAdmin = MySession.isAdmin();
    $rootScope.$on('userUpdated', function () {
        $scope.isAdmin = MySession.isAdmin();
    });
    
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


// Controller for display all the register of a table.
appCtrl.controller('ListCtrl', function ($scope, $location, RestSvcs, dataType) {
    // Initialize variables.
    $scope.rows = [];

    // Get list of register.
    RestSvcs.list(dataType, function(lists) { console.log(lists);
        // Verify if the register were found.
        if(lists != null && lists[dataType] != null) {
            // Update the list.
            $scope.rows = lists[dataType];
      
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Function to edit or create a row.
    $scope.edit = function(id) {
        $location.path("/"+dataType+"/" + id);
    };
});

// Controller for the flights page.
appCtrl.controller('PersonsCtrl', function ($scope, $location, RestSvcs) {
    // Initialize variables.
    $scope.rows = [];
    $scope.groups = [];
    
    // Get list of campanies.
    RestSvcs.list("person-group", function(lists) {
        if(lists != null) {
            // Update the lists.
            $scope.rows = lists['person'];
            $scope.groups = lists['group'];
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Function to edit or create a row.
    $scope.edit = function(id) {
        $location.path("/person/" + id);
    };
    
    // Function to get the group of a person.
    $scope.getGroup = function(person) {
        var res = null;
        try { res = _.findWhere($scope.groups, {id: person.group_id}); }catch(e) {}
        return res != null? res.name : '';
    };
});

// Controller for the flights page.
appCtrl.controller('RecordsCtrl', function ($scope, $location, RestSvcs) {
    // Initialize variables.
    $scope.rows = [];
    $scope.users = [];
    $scope.events = [];
    $scope.persons = [];
    
    // Get list of campanies.
    RestSvcs.list("assistance-user-event-person", function(lists) {
        if(lists != null) {
            // Update the lists.
            $scope.rows = lists['assistance'];
            $scope.users = lists['user'];
            $scope.events = lists['event'];
            $scope.persons = lists['person'];
            console.log(lists);
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Function to edit or create a row.
    $scope.edit = function(id) {
        $location.path("/assistance/" + id);
    };
    
    // Function to get the person|user|event of a record.
    $scope.getUser = function(record) {
        var res = null;
        try { res = _.findWhere($scope.users, {id: record.user_id}); }catch(e) {}
        return res != null? res.username : '';
    };
    $scope.getPerson = function(record) {
        var res = null;
        try { res = _.findWhere($scope.persons, {id: record.person_id}); }catch(e) {}
        return res != null? (res.first_name + " " + res.last_name) : '';
    };
    $scope.getEvent = function(record) {
        var res = null;
        try { res = _.findWhere($scope.events, {id: record.event_id}); }catch(e) {}
        return res != null? res.name : '';
    };
});
