
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
    RestSvcs.list(dataType, function(lists) {
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

// Controller for the persons page.
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

// Controller for the take assistance page.
appCtrl.controller('SelectGroupAndEventCtrl', function ($scope, $location, RestSvcs) {
    // Initialize variables.
    $scope.events = [];
    $scope.groups = [];
    $scope.entry = {group_id:null, event_id:null};
    
    // Get list of events and groups.
    RestSvcs.list("event-group", function(lists) {
        if(lists != null) {
            // Update the lists.
            $scope.events = lists['event'];
            $scope.groups = lists['group'];
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Behaviour for the 'next' button.
    $scope.next = function(form) {
        // Go to edit (or create) the assitance list..
        $location.path("/assistance/" + $scope.entry.group_id + "/" + $scope.entry.event_id +"/today");
    };
});

// Controller for the take assistance page.
appCtrl.controller('AssistanceCtrl', function ($scope, $location, $routeParams, RestSvcs) {
    // Initialize variables.
    $scope.rows = [];
    $scope.persons = [];
    $scope.event = [];
    $scope.group = [];
    $scope.date = [];

    // Get list of persons.
    RestSvcs.findByGroup($routeParams.groupId, function(rows) {
        if(rows != null) {
            // Update the lists.
            $scope.persons = rows;
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Get assistance list.
    RestSvcs.getAssistanceList($routeParams.groupId, $routeParams.eventId, $routeParams.date, function(data) {
        if(data != null) {
            // Update the lists.
            $scope.rows = data['rows'];
            $scope.event = data['event'];
            $scope.group = data['group'];
            $scope.date = moment(data['date']).format("MMMM Do YYYY");
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Get a person data.
    $scope.getPerson = function(personId) {
        return _.find($scope.persons, {id: personId});
    };
    
    // Update the status of a person.
    $scope.update = function(row) {
        row.value = (row.value + 1)%3;
    };
    
    $scope.save = function() {
        // Save changes.
        RestSvcs.saveAssistanceList($scope.rows, function(success) {
            if(success) {
                // Display the lists of assistance.
                $location.path("/lists");
            }
        });        
    };
});

// Controller for the records page.
appCtrl.controller('RecordsCtrl', function ($scope, $location, RestSvcs) {
    // Initialize variables.
    $scope.rows = [];
    
    /*
    // Get list of attendance lists.
    RestSvcs.list("assistance-user-event-person", function(lists) {
        if(lists != null) {
            // Update the lists.
            $scope.rows = lists['assistance'];
            $scope.users = lists['user'];
            $scope.events = lists['event'];
            $scope.persons = lists['person'];
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    */
   
    // Function to edit or create a row.
    $scope.edit = function(row) {
        $location.path("/assistance/" + row.group_id + "/" + row.event_id + "/" + row.creation);
    };
    
    /*
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
    */
});

// Controller for an edit form.
appCtrl.controller('SimpleFormCtrl', function ($scope, $routeParams, $location, RestSvcs, toastr, dataType, returnUrl, defaultEntry) {
    // Initialize variables.
    $scope.type = dataType;
    $scope.entry = defaultEntry;
    
    // Get the entry to edit.
    if(!isNaN($routeParams.id)) {
        RestSvcs.findById(dataType, $routeParams.id, function(row) {
            // Verify if the row was read.
            if(row !== false) {
                $scope.entry = row;
            }

            // Update UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    }
    
    // Behaviour for the 'cancel' button.
    $scope.goBack = function() {
        $location.path(returnUrl);
        return false;
    };
    
    // Behaviour for submitting the form.
    $scope.save = function(form) {
        // Verify if the form is valid.
        if(form.$valid) {
            // Call service to save changes.
            RestSvcs.save(dataType, $scope.entry, function(res) {
                if(res) {
                    toastr.success('The changes were saved', 'Success');
                    if(isNaN($routeParams.id)) $scope.goBack();
                }
            });
        } else {
            // Show error message.
            toastr.error('They are some errors in the form', 'Error');
        }
    };
    
    // Behaviour for the 'delete' button.
    $scope.delete = function() {
        RestSvcs.delete(dataType, $routeParams.id, function(res) {
            // If the register was deleted, go back to the list view.
            if(res) $scope.goBack();
        });
        return false;
    };
});

// Controller for an edit form.
appCtrl.controller('UserCtrl', function ($scope, $routeParams, $location, RestSvcs, toastr) {
    // Initialize variables.
    $scope.entry = {id: null, first_name: '', last_name: '', username: '', password: '', admin: 0, disabled: 0};
    
    // Get the entry to edit.
    if(!isNaN($routeParams.id)) {
        RestSvcs.findById("user", $routeParams.id, function(row) {
            // Verify if the row was read.
            if(row !== false) {
                $scope.entry = row;
                $scope.entry.password = '';
            }

            // Update UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    }
    
    // Behaviour for the 'cancel' button.
    $scope.goBack = function() {
        $location.path("users");
        return false;
    };
    
    // Behaviour for submitting the form.
    $scope.save = function(form) {
        // Verify if the form is valid.
        if(form.$valid) {
            // Call service to save changes.
            RestSvcs.save("user", $scope.entry, function(res) {
                if(res) {
                    toastr.success('The changes were saved', 'Success');
                    if(isNaN($routeParams.id)) $scope.goBack();
                }
            });
        } else {
            // Show error message.
            toastr.error('They are some errors in the form', 'Error');
        }
    };
    
    // Behaviour for the 'delete' button.
    $scope.delete = function() {
        RestSvcs.delete("user", $routeParams.id, function(res) {
            // If the register was deleted, go back to the list view.
            if(res) $scope.goBack();
        });
        return false;
    };
});

// Controller for the persons form.
appCtrl.controller('PersonCtrl', function ($scope, $routeParams, $location, RestSvcs, toastr) {
    // Initialize variables.
    $scope.entry = {id: null, first_name: '', last_name: '', group_id: null, disabled:0};
    $scope.groups = [];
    
    // Get the list of companies.
    RestSvcs.list("group", function(lists) {
        if(lists != null && lists['group'] != null) {
            // Update the list.
            $scope.groups = lists['group'];
            
            // Update the UI.
            if(!$scope.$$phase) $scope.$apply();
        }
    });
    
    // Get the entry to edit.
    if(!isNaN($routeParams.id)) {
        RestSvcs.findById("person", $routeParams.id, function(row) {
            // Verify if the row was read.
            if(row !== false) {
                $scope.entry = row;
            }
            
            // Update UI.
            if(!$scope.$$phase) $scope.$apply();
        });
    }
    
    // Behaviour for the 'cancel' button.
    $scope.goBack = function() {
        $location.path("/persons");
        return false;
    };
    
    // Behaviour for submitting the form.
    $scope.save = function(form) {
        // Verify if the form is valid.
        if(form.$valid) {
            // Call service to save changes.        
            RestSvcs.save("person", $scope.entry, function(res) {
                if(res) {
                    toastr.success('The changes were saved', 'Success');
                    if(isNaN($routeParams.id)) $scope.goBack();
                }
            });
        } else {
            // Show error message.
            toastr.error('They are some errors in the form', 'Error');            
        }
    };
    
    // Behaviour for the 'delete' button.
    $scope.delete = function() {
        RestSvcs.delete("person", $routeParams.id, function(res) {
            // If the register was deleted, go back to the list view.
            if(res) $scope.goBack();
        });
        return false;
    };
});
