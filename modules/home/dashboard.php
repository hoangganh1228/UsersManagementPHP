<?php

if(!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Trang Dashboard'
];

// require_once _WEB_PATH_TEMPLATES .'/layout/header.php';
layouts('header', $data);

// Kiểm tra trạng thái đăng nhập 
if(!isLogin()) {
    redirect('/?module=auth&action=login');
}

?>

<h1>DASHBOARD</h1>

<?php 
layouts('footer', $data);
?>