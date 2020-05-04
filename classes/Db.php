<?php 



    class Db {

        private static $conn;

        public static function getConnection(){
            
            if (self::$conn === null) {
                self::$conn = new PDO('mysql:host=localhost;dbname=bemybuddy_buddy_app', 'bemybuddy_buddy_app', 'JorisIsEenSlavendrijver');
                return self::$conn;
            }
            else {
                return self::$conn;
            }
        }
    }