<?php

//check_code.php
spl_autoload_register();
session_start();

$code = $_POST['code'];

if ($code == $_SESSION['captcha_code']) {
 echo 'success';
}

