<?php

// flarum配置

function getToken($usr, $pwd){
  $token_api_url = "http://admin.5imczy.cn:1323/api/token"; // 获取令牌的api
  $ch = curl_init($token_api_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'identification' => $usr,
    'password'       => $pwd
  ]));

  $result = curl_exec($ch);
  $session = json_decode($result);
  $token = $session->token;
  return $token;
}

function register($usr, $mail, $pwd, $tk){
  $api_url = "http://admin.5imczy.cn:1323/api/users"; // 用户操作api
    $ch = curl_init($api_url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Token ' . $tk
    ]);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
      'data' => [
        'attributes' => [
          "username"         => $usr,
          "password"         => $pwd,
          "email"            => $mail,
          "isEmailConfirmed" => true
        ]
      ]    
    ]));
    
    $result = curl_exec($ch);
    
    $new_user = json_decode($result);
    return $new_user;
}
