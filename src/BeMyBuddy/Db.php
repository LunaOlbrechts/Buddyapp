<?php 

namespace src\BeMyBuddy;

use \PDO;

    class Db {

        private static $conn;

        public static function getConnection(){

            if (self::$conn === null) {
                self::$conn = new PDO('mysql:host=' . Settings::SETTINGS['db']['host'] . ';dbname=' . Settings::SETTINGS['db']['db'] . ';charset=utf8mb4' , Settings::SETTINGS['db']['user'], Settings::SETTINGS['db']['password']);
                return self::$conn;
            }
            else {
                return self::$conn;
            }
        }
    }