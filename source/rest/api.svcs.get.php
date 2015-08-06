<?php

// Service for get the rows of a table.
$app->get('/list/:types', function ($types) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {
            // Get list.
            $lists = array();  
            if(strpos($types, 'event') !== false) { $lists['event'] = ApiUtils::rowsToMaps( Event::find('all', array('order' => 'name asc')) ); }
            if(strpos($types, 'group') !== false) { $lists['group'] = ApiUtils::rowsToMaps( Group::find('all', array('order' => 'name asc')) ); }
            if(strpos($types, 'user') !== false) { $lists['user'] = ApiUtils::rowsToMaps( User::find('all', array('order' => 'username asc')) ); }
            if(strpos($types, 'person') !== false) { $lists['person'] = ApiUtils::rowsToMaps( Person::find('all', array('order' => 'last_name asc, first_name asc')) ); }
            if(strpos($types, 'assistance') !== false) { $lists['assistance'] = ApiUtils::rowsToMaps( Assistance::find('all', array('order' => 'date desc')) ); }
     
            // Return result.
            echo json_encode(array(
                "lists" => $lists,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(array(
                "error" => "AccessDenied",
                "message" => "You must be logged to consume this service"
            ));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }    
});

// Service for get a row from the database.
$app->get('/findById/:type/:id', function ($type, $id) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {
            // Get list.
            $row = array();
            if($type == "event") { $row = ApiUtils::rowToMap( Event::find($id) ); }
            if($type == "group") { $row = ApiUtils::rowToMap( Group::find($id) ); }
            if($type == "user") { $row = ApiUtils::rowToMap( User::find($id) ); }
            if($type == "person") { $row = ApiUtils::rowToMap( Person::find($id) ); }
            if($type == "assistance") { $row = ApiUtils::rowToMap( Assistance::find($id) ); }
     
            // Return result.
            echo json_encode(array(
                "row" => $row,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(array(
                "error" => "AccessDenied",
                "message" => "You must be logged to consume this service"
            ));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }    
});

// Service for get all persons from a group.
$app->get('/findByGroup/:id', function ($id) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {
            // Get list of persons in the group.
            $row = ApiUtils::rowsToMaps( Person::find('all', array('group_id' => $id)) );
     
            // Return result.
            echo json_encode(array(
                "row" => $row,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(array(
                "error" => "AccessDenied",
                "message" => "You must be logged to consume this service"
            ));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }    
});
