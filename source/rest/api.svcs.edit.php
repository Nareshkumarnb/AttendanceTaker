<?php

// Service for create or update a row in the database.
$app->put('/:type/:id', function ($type, $id) use ($app) {
    try {
        // Verify that the user is logged as administrator.
        if(ApiUtils::isAdmin()) {
            // Init.
            $error = null;
            $message = null;

            // Get input.
            $request = $app->request();
            $input = json_decode($request->getBody()); 
            $attributes = is_object($input)? get_object_vars($input) : $input;
            
            // Verify if entry must be created or updated.
            $entry = null;
            if(empty($id) || !is_numeric($id)) {
                // Create entry.
                if($type == "assistance") { $entry = new Assistance($attributes); }
                if($type == "event") { $entry = new Event($attributes); }
                if($type == "group") { $entry = new Group($attributes); }
                if($type == "person") { $entry = new Person($attributes); }
                if($type == "user") { 
                    if(!empty($attributes['password'])) {
                        $entry = new User($attributes); 
                    } else {
                        $error = "InvalidParameters";
                        $message = "You must select a password";
                    }
                }

                // Save it.
                if($entry != null) { $entry->save(); }
            } else {
                // Find entry.
                if($type == "assistance") { $entry = Assistance::find($id); }
                if($type == "event") { $entry = Event::find($id); }
                if($type == "group") { $entry = Group::find($id); }
                if($type == "person") { $entry = Person::find($id); }
                if($type == "user") { 
                    $entry = User::find($id); 
                    if(empty($attributes['password'])) { 
                        unset($attributes['password']); 
                    } else {
                        $attributes['password'] = sha1($attributes['password']);
                    }
                }
                
                // Update it.
                if($entry != null) { $entry->update_attributes($attributes); }
            }
            
            // Verify if the entry was saved.
            if($entry == null && $error == null) {
                $error = "EntryNotSaved";
                $message = "The entry could not be saved/updated";
            }
            
            // Return result.
            echo json_encode(array("error" => $error, "message" => $message));            
        } else {
            // Return error message.
            echo json_encode(array(
                "error" => "AccessDenied",
                "message" => "You must be logged and have administrator privileges to consume this service"
            ));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }    
});

// Service for delete a row from the database.
$app->delete('/:type/:id', function ($type, $id) {
    try {
        // Verify that the user is logged as administrator.
        if(ApiUtils::isAdmin()) {
            $error = null;
            $message = null;
            
            // Groups.
            if($type == "group") {
                // Verify if the groups is used by persons.
                $count = Person::count(array('conditions' => 'group_id = ' . $id));
                if($count <= 0) {
                    // Delete group.
                    $row = Group::find($id);
                    $row->delete();
                } else {
                    // Set error.
                    $error = "CantDeleteGroup";
                    $message = "The group could not be deleted since they are persons that belong to them";
                }                
            }
            
            // Event.
            if($type == "event") {
                // Verify if the event is used by assistances.
                $count = Assistance::count(array('conditions' => 'event_id = ' . $id));
                if($count <= 0) {
                    // Delete event.
                    $row = Event::find($id);
                    $row->delete();
                } else {
                    // Set error.
                    $error = "CantDeleteEvent";
                    $message = "The event could not be deleted since some assistance lists are linked to him";
                }                
            }
            
            // Person.
            if($type == "person") {
                // Verify if the person is used by assistances.
                $count = Assistance::count(array('conditions' => 'person_id = ' . $id));
                if($count <= 0) {
                    // Delete person.
                    $row = Person::find($id);
                    $row->delete();
                } else {
                    // Set error.
                    $error = "CantDeletePerson";
                    $message = "The person could not be deleted since some assistance lists are linked to him";
                }                
            }
            
            // User.
            if($type == "user") {
                // Verify if the user is used by assistances.
                $count = Assistance::count(array('conditions' => 'user_id = ' . $id));
                if($count <= 0) {
                    // Delete officer.
                    $row = User::find($id);
                    $row->delete();
                } else {
                    // Set error.
                    $error = "CantDeleteUser";
                    $message = "The user could not be deleted since some assistance lists are linked to him";
                }                
            }            
            
            // Return result.
            echo json_encode(array(
                "error" => $error,
                "message" => $message
            ));
        } else {
            // Return error message.
            echo json_encode(array(
                "error" => "AccessDenied",
                "message" => "You must be logged and have administrator privileges to consume this service"
            ));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }    
});


// Service for update the values of an assistance list.
$app->put('/assistanceList', function () use ($app) {
    try {
        // Verify that the user is logged.
        if(ApiUtils::isLogged()) {
            // Get input.
            $request = $app->request();
            $input = json_decode($request->getBody());             
            $rows = is_object($input)? get_object_vars($input) : $input;
            
            // Update all rows.
            for($i =0; $i<count($rows); $i++) {
                $entry = Assistance::find($rows[$i]->id);
                
                $attributes = is_object($rows[$i])? get_object_vars($rows[$i]) : $rows[$i];
                $creation = is_object($rows[$i]->creation)? get_object_vars($rows[$i]->creation) : $rows[$i]->creation;
                $attributes['creation'] = $creation['date'];
                
                if($entry != null) { $entry->update_attributes($attributes); }
            }
            
            // Return result.
            echo json_encode(array("error" => null));            
        } else {
            // Return error message.
            echo json_encode(array(
                "error" => "AccessDenied",
                "message" => "You must be logged and have administrator privileges to consume this service"
            ));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => $attributes, "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }    
});
