<!-- Kich hoat tai khoan -->
<?php

if(!defined('_CODE')) {
    die('Access denied ...');
}

layouts('header');

$token = filter()['token'];
if(!empty($token)) {
    // Truy vấn kiểm tra với database
    $tokenQuery = oneRaw("SELECT id FROM users  WHERE activeToken = '$token'");
    if(!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];

        $updateStatus = update('users', $dataUpdate, "id = $userId");

        if($updateStatus) {
            setFlashData('msg', 'Kích hoạt tài khoản thành công, bạn có thể đăng nhập ngay bây giờ!');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Kích hoạt tài khoản không thành công, vui lòng liên hệ quản trị viên!');
            setFlashData('msg_type', 'danger');
        }

        redirect('?module=auth&action=login');
    } else {
        getSmg('Liên kết không tồn tại!', 'danger');
    }
} else {
    getSmg('Liên kết không tồn tại!', 'danger');
}



?>

<?php
    layouts('footer');
?>
