<?php

session_start();
require_once('config.php');
require_once('./includes/connect.php');

// Thư viện php mailer
require_once('./includes/phpmailer/Exception.php');
require_once('./includes/phpmailer/PHPMailer.php');
require_once('./includes/phpmailer/SMTP.php');

require_once('./includes/functions.php');
require_once('./includes/database.php');
require_once('./includes/session.php');

// $session_test = setSession('hienu', 'Gia tri cua Session Hienu');
// var_dump($session_test);

// setFlashData('msg', 'Cài đặt thành công!');
// echo getFlashData('msg');
$content = 'Hoang Anh den choi';
$subject = 'ABCDEFGHJKLM nè';

// sendMail('hoanganh52521352@gmail.com', $content, $subject);

// echo _WEB_HOST.'<br>'; 
// echo _WEB_HOST_TEMPLATES.'<br>';
// echo _WEB_PATH.'<br>';
// echo _WEB_PATH_TEMPLATES; 


$module = _MODULE;
$action = _ACTION;

if(!empty($_GET['module'])) {
   
    if(is_string( $_GET['module'])) {
        $module = trim($_GET['module']);
    }
} 

if(!empty($_GET['action'])) {
   
    if(is_string( $_GET['action'])) {
        $action = trim($_GET['action']);
    }
} 


$path = 'modules/'. $module. '/'. $action . '.php';

if(file_exists($path)) {
    require_once ($path);
}
else {
    require_once 'modules/error/404.php';
}
?>