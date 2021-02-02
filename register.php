<?php
session_start();
if(!isset($_SESSION['code'])){
    header('location: ./');
    echo 'ILLEGAL ACCESS';
    exit();
}
$code = $_SESSION['code'];
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>验证身份 - 梦幻国度Minecraft神奇宝贝公益服务器交流社区</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" /> 

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/reg.css">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <!-- do sth -->
                <?php if($code==-303): ?>
                <span name="error">未接收到表单数据 请联系服主</span>
                <a href="./">[返回]</a>
                <?php elseif($code==-100): ?>
                <span name="error">无法连接到数据库 请联系服主</span>
                <a href="./">[返回]</a>
                <?php elseif($code==-302): ?>
                <span name="error">未查找到用户</span>
                <a href="./">[返回]</a>
                <?php elseif($code==-400): ?>
                <span name="error">已经注册过了!</span>
                <a href="./">[返回]</a>
                <?php elseif($code==200): ?>
                <span name="notice">已完成注册</span>
                <a href="/">[返回论坛]</a>
                <?php elseif($code==-500): ?>
                <span name="notice">验证码</span>
                <a href="./">[返回]</a>
                <?php elseif($code==0): ?>
                <span name="notice">密码错误</span>
                <a href="./">[返回]</a>
                <?php else: ?>
                <p>未知错误 请联系服主 状况码:<?php echo $code; ?></p>
                <?php endif; ?>
			</div>
		</div>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/jquery/jquery.form.min.js"></script>
</body>

</html>