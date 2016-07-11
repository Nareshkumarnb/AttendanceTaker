<?php

/**
 * Static class that holds the configuration values.
 */
class ApiConfig {
    /**
     * Connection string for a PostgreSQL database.
     */
    public static $CONN_STRING = "pgsql://username:password@localhost/attendance?charset=utf8";
    
    /**
     * Path for the logging file.
     */
    public static $LOG_FILEPATH = "log.txt";
}

