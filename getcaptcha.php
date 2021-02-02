<?php
session_start();
$pending = $_POST['pending'];
if(!isset($pending)){
    if(!isset($_SESSION['captcha'])){
        die('Invalid arguments!');
        exit();
    }
    header('Content-Type: image/png');
    ImagePNG($_SESSION['captcha']);
}