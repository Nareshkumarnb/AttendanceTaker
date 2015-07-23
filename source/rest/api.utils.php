<?php

/**
 * Static class that provides several utilities methods.
 */
class ApiUtils {
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
}
