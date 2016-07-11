<?php

// ---- Initialization ---- //

require_once 'api.config.php';
require_once 'api.utils.php';
require_once 'api.init.php';

// ---- Services ---- //

// All responses are JSON files.
header('Content-type: text/javascript');

// Services for login and logout.
//    get  /
//    post /login
//    get  /logout
include_once 'api.svcs.login.php';

// Services for getting lists and find rows by id.
//    get /list/:types
//    get /findById/:type/:id
//    get /findByGroup/:id
//    get /searchByDate/:date1/:date2
//    get /getAssistance/:groupId/:eventId/:date
include_once 'api.svcs.get.php';

// Services for update or delete rows.
//     put    /:type/:id
//     delete /:type/:id
//     put /assistanceList
include_once 'api.svcs.edit.php';

// Service for get the rows of a table.
//$app->get('/test', function () {
//    try {
//        $conn = ActiveRecord\Connection::instance();
//        $pdoStatement = $conn->query("SELECT * FROM person");
//        $res = $pdoStatement->fetchAll();
//        echo json_encode($res);
//    }catch(Exception $e) {
//        // An exception ocurred. Return an error message.
//        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
//        ApiUtils::$logger->LogError($e->getMessage());
//    }    
//});

// Run application.
$app->run();