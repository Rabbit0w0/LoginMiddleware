<?php
include 'FlarumAdapter.php';
include 'DreamSHA256.php';

session_start();

$pwd = $_POST['password'];
$adr = $_POST['email'];

if(!isset($pwd) || !isset($adr)){
    $_SESSION['code']=-303;
    header('location: register.php');
    exit();
}
$connect = mysqli_connect('localhost', 'root', 'leisihan', 'blessingskin');
if(!$connect){
    $_SESSION['code']=-100;
    header('location: register.php');
    exit();
}

mysqli_query($connect, 'set names UTF-8');

$sql = 'SELECT * FROM `users` WHERE email=\'' . $adr . '\'';

$ret = mysqli_query($connect, $sql);


$usr = mysqli_fetch_array($ret, MYSQLI_ASSOC);
$alg = new DreamSHA256();

if(!isset($usr)){
    $_SESSION['code']=-302;
    header('location: register.php');
}

$orgpwd = $usr['password'];

if($alg->verify($pwd, $orgpwd)){
    $token=getToken('lei_s_ha', 'lei061230!!!');
    $return=register($usr['nickname'], $adr, $pwd, $token);
    if(isset($return->errors)){
        $_SESSION['code']=-400;
        header('location: register.php');
        exit();
    }
    $_SESSION['code']=200;
    header('location: register.php');
    exit();
}
else{
    $_SESSION['code']=0;
    header('location: register.php');
    exit();
}