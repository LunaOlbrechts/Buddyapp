<?php 

include_once(__DIR__ . "../../settings/Settings.php");

    class Db {

        private static $conn;

        public static function getConnection(){
            
            if (self::$conn === null) {
                self::$conn = new PDO('mysql:host=' . SETTINGS['db']['host'] . ';dbname=' . SETTINGS['db']['db'] . ';charset=utf8mb4' , SETTINGS['db']['user'], SETTINGS['db']['password']);
                return self::$conn;
            }
            else {
                return self::$conn;
            }
        }
    }