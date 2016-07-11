<?php

// ---- Initialize logging ---- //

require_once 'libs/KLogger.php';
ApiUtils::$logger = new KLogger (ApiConfig::$LOG_FILEPATH , KLogger::DEBUG);

// ---- Initialize Slim Framework ---- //

require 'libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// ---- Initialize ActiveRecord ---- //

require_once 'libs/ActiveRecord/ActiveRecord.php';
 
ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_model_directory('libs/models');
    $cfg->set_connections(array('development' => ApiConfig::$CONN_STRING));
});

// ---- Other initializations ---- //

// Initialize session.
session_start();
