<?php

// ---- Initialization ---- //

require_once 'api.config.php';
require_once 'api.init.php';
require_once 'api.utils.php';

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
include_once 'api.svcs.get.php';

// Run application.
$app->run();