<?php

/**
 * Static class that provides several utilities methods.
 */
class ApiUtils {
    /**
     * Reference to the logger object.
     */
    public static $logger;

    /**
     * List of responses objects.
     */
    private static $ERRORS = array(
        "UserNotLogged" => array(
            "status" => 401,
            "response" => array(
                "error" => "AccessDenied",
                "message" => "You must be logged to consume this service"
            )
        ),
        "UserNotAdmin" => array(
            "status" => 403,
            "response" => array(
                "error" => "AccessDenied",
                "message" => "You must be logged and have administrator privileges to consume this service"
            )
        ),
        "UserDisabled" => array(
            "status" => 403,
            "response" => array(
                "error" => "AccessDenied", 
                "message" => "The user has been disabled"
            )
        ),
        "InvalidLogin" => array(
            "status" => 404,
            "response" => array(
                "error" => "InvalidLogin", 
                "message" => "Invalid username or password"
            )
        )
    );
    
    /**
     * Handles an exception raised when executing a REST service.
     * 
     * @param Object $app The Slim's application object.
     * @param Object $e The exception's object.
     */
    public static function handleException($app, $e) {
        $app->response->setStatus(500);
        echo json_encode(array("error" => "Unexpected", "message" => $e->getMessage()));
        self::$logger->LogError($e->getMessage());    
    }
    
    /**
     * Return an error message for a REST service.
     *
     * @param Object $app The Slim's application object.
     * @param String $errorCode The error's code.
     */
    public static function returnError($app, $errorCode) {
        $app->response->setStatus(self::$ERRORS[$errorCode]['status']);
        echo json_encode(self::$ERRORS[$errorCode]['response']);
    }
    
    /**
     * Return a simple response for a REST service.
     *
     * @param Object $app The Slim's application object.
     * @param String $error The error's code.
     * @param String $message The message's content.
     * @param Number $status The HTTP status code.
     */
    public static function returnSimpleMessage($app, $error, $message, $status) {
        if(isset($status)) { $app->response->setStatus($status); }
        echo json_encode(array("error" => $error, "message" => $message));
    }
    
    /**
     * Gets an associative array from a database row.
     * 
     * @param Object $row A database row.
     */
    public static function rowToMap($row) {        
        $map = $row? $row->attributes() : null;
        return $map;
    }
    
    /**
     * Get an array of maps from an array of database's rows.
     * 
     * @param Array $rows An array of database rows.
     */
    public static function rowsToMaps($rows) {
        $res = array();
        
        // Validate parameters.
        if(!is_array($rows)) { 
            $rows = array($rows); 
        }

        // Iterate over each row.
        foreach($rows as $entry) {
            $map = ApiUtils::rowToMap($entry);
            if($map != null) {
                array_push($res, $map); 
            }
        }

        return $res;
    }
    
    /**
     * Verires if the current user is logged.
     * 
     * @return 'true' if the user is logged, 'false' if contrary.
     */
    public static function isLogged() {
        return isset($_SESSION['user']);
    }
    
    /**
     * Verires if the current user is logged and has administrator privileges.
     * 
     * @return 'true' if the user is logged and has administrator privileges, 'false' if contrary.
     */
    public static function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['admin'] == 1;
    }
}
