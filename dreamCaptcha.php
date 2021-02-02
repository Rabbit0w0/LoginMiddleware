<?php
session_start();
function check($awa){
    $captcha_ins =$_SESSION['prot_task'];
    if($captcha_ins->check($awa)){
        return true;
    }
    return false;
}
