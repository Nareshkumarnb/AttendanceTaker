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
            // The user exists, verify if is enabled.
            $user = $users[0];
            if($user->disabled != 1) {
                // The user is enabled, save his data in the session and return a success message.           
                $_SESSION["user"] = $users[0]->attributes();
                echo json_encode(array("error" => null, "user" => $users[0]->attributes() ));
            } else {
                // The user is disabled, return error message.
                ApiUtils::returnError($app, 'UserDisabled');
            }
        } else {
            // The user do not exists, return error message.
            ApiUtils::returnError($app, 'InvalidLogin');
        }
    }catch(Exception $e) {
        // An exception ocurred. Return an error message.
        ApiUtils::handleException($app, $e);
    }
});

// Logout service.
$app->get('/logout', function () {
    // Clear session and return success message.
    $_SESSION["user"] = null;
    echo json_encode(array("error" => null));
});
