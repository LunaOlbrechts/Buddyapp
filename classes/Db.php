<?php 

    class Db {

        private static $conn;

        public static function getConnection(){
            
            if (self::$conn === null) {
                self::$conn = new PDO('mysql:host=localhost;dbname=buddy_app', 'root', '');
                return self::$conn;
            }
            else {
                return self::$conn;
            }
        }
    }