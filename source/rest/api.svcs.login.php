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
            // TODO: Verify if an user with that name and password exists.
            if($input['username'] == $input['password']) {
                $_SESSION["user"] = $input;
                echo json_encode(array("error" => null, "user" => $input ));
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
