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
     * List of errors objects.
     */
    public static $ERRORS = array(
        "UserNotLogged" => array(
            "error" => "AccessDenied",
            "message" => "You must be logged to consume this service"
        ),
        "UserNotAdmin" => array(
            "error" => "AccessDenied",
            "message" => "You must be logged and have administrator privileges to consume this service"
        ),
        "UserDisabled" => array(
            "error" => "AccessDenied", 
            "message" => "The user has been disabled"
        ),
        "InvalidLogin" => array(
            "error" => "InvalidLogin", 
            "message" => "Invalid username or password"
        )
    );
    
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
