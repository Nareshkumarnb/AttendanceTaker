<?php

// All responses are JSON files.
header('Content-type: text/javascript');

// Initialize Slim.
require 'libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// Run application.
$app->run();