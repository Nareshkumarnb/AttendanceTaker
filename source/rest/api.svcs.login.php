<?php

// Ping service.
$app->get('/', function () {
    $user = isset($_SESSION["user"])? $_SESSION["user"] : null;
    echo json_encode(array("error" => null, "user" => $user));    
});

// Login service.
$app->post('/login', function () use ($app) {
    try {
        // Get parameters.
        $request = $app->request();
        $input = json_decode($request->getBody()); 
        if (is_object($input)) { $input = get_object_vars($input); }
        
        // Verify if an user with that name and password exists.
        $users = User::all(array('conditions' => array('username = ? AND password = ?', $input['username'], sha1($input['password']))));
        if(count($users) > 0) {
            // The user exists, save his data in the session and return a success message.           
            $_SESSION["user"] = $users[0]->attributes();           
            echo json_encode(array("error" => null, "user" => $users[0]->attributes() ));
        } else {
            // The user do not exists, return error message.
            echo json_encode(array("error" => "InvalidLogin", "message" => "Invalid username or password"));
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        $GLOBALS['log']->LogError($e->getMessage());
    }
});

// Logout service.
$app->get('/logout', function () {
    // Clear session and return success message.
    $_SESSION["user"] = null;
    echo json_encode(array("error" => null));
});
