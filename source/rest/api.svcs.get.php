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
            if(strpos($types, 'assistance') !== false) { $lists['assistance'] = ApiUtils::rowsToMaps( Assistance::find('all', array('order' => 'creation desc')) ); }
            if(strpos($types, 'list') !== false) { 
                $conn = ActiveRecord\Connection::instance();
                $pdoStatement = $conn->query("SELECT * FROM list");
                $lists['list'] = $pdoStatement->fetchAll();
            }
            
            // Return result.
            echo json_encode(array(
                "lists" => $lists,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(ApiUtils::$ERRORS['UserNotLogged']);
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        ApiUtils::$logger->LogError($e->getMessage());
    }
});

// Service for get a row from the database.
$app->get('/findById/:type/:id', function ($type, $id) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {
            // Get list.
            $rows = array();
            if($type == "event") { $rows = ApiUtils::rowToMap( Event::find($id) ); }
            if($type == "group") { $rows = ApiUtils::rowToMap( Group::find($id) ); }
            if($type == "user") { $rows = ApiUtils::rowToMap( User::find($id) ); }
            if($type == "person") { $rows = ApiUtils::rowToMap( Person::find($id) ); }
            if($type == "assistance") { $rows = ApiUtils::rowToMap( Assistance::find($id) ); }
     
            // Return result.
            echo json_encode(array(
                "row" => $rows,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(ApiUtils::$ERRORS['UserNotLogged']);
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        ApiUtils::$logger->LogError($e->getMessage());
    }    
});

// Service for get all persons from a group.
$app->get('/findByGroup/:id', function ($id) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {
            // Get list of persons in the group.
            $rows = ApiUtils::rowsToMaps( Person::find('all', array('group_id' => $id)) );
     
            // Return result.
            echo json_encode(array(
                "row" => $rows,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(ApiUtils::$ERRORS['UserNotLogged']);
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        ApiUtils::$logger->LogError($e->getMessage());
    }    
});


// Service for get the rows of a table.
$app->get('/searchByDate/:date1/:date2', function ($date1, $date2) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {        
            // Generate query.
            $query = "SELECT * FROM list WHERE date >= '" . $date1 . "' AND date <= '" . $date2 . "'";

            // Get list.
            $conn = ActiveRecord\Connection::instance();
            $pdoStatement = $conn->query($query);
            $res = $pdoStatement->fetchAll();
            
            // Return result.
            echo json_encode(array(
                "lists" => $res,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(ApiUtils::$ERRORS['UserNotLogged']);
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        ApiUtils::$logger->LogError($e->getMessage());
    }    
});

// Service for get all persons from a group.
$app->get('/assistanceList/:groupId/:eventId/:date', function ($groupId, $eventId, $date) {
    try {
        // Verify that the user is logged.
        if(isset($_SESSION['user'])) {
            // Get list of persons in the group.
            $now = new DateTime();
            $rows = ApiUtils::rowsToMaps( 
                Assistance::find_by_sql("select * from get_assistance(" . 
                    $_SESSION['user']['id'] . "," . 
                    $groupId . "," . 
                    $eventId . "," . 
                    "'" . ($date !== 'today'? $date : $now->format('Y-m-d')) . "')")
            );
     
            // Get name of event and group.
            $event = ApiUtils::rowToMap( Event::find($eventId) );
            $group = ApiUtils::rowToMap( Group::find($groupId) );
            
            // Return result.
            echo json_encode(array(
                "rows" => $rows,
                "date" => ($date !== 'today'? $date : $now->format('Y-m-d')),
                "event" => $event,
                "group" => $group,
                "error" => null
            ));
        } else {
            // Return error message.
            echo json_encode(ApiUtils::$ERRORS['UserNotLogged']);
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        ApiUtils::$logger->LogError($e->getMessage());
    }    
});
