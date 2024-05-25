<!-- Quen mat khau -->
<?php

if(!defined('_CODE')) {
    die('Access denied ...');
}
?>

<!-- Đăng nhập tài khoản -->
<?php

$data = [
    'pageTitle' => 'Quên mật khẩu'
];

// require_once _WEB_PATH_TEMPLATES .'/layout/header.php';
layouts('header', $data);

// Kiểm tra trạng thái đăng nhập 
if(isLogin()) {
    redirect('/?module=home&action=dashboard');
}

if(isPost()) {
    $filterAll = filter();
    if(!empty($filterAll['email'])) {
        $email = $filterAll['email'];
        $queryUser= oneRaw("SELECT id FROM users WHERE email = '$email'");
        
        if(!empty($queryUser)) {
            $userId = $queryUser['id'];

            $forgotToken = sha1(uniqid().time());

            $dataUpdate = [
                'forgotToken' => $forgotToken
            ];

            $updateStatus = update('users', $dataUpdate, "id = $userId");
            if($updateStatus) {
                // Tạo đường link reset, khôi phục mật khẩu
                $linkReset = _WEB_HOST.'?module=auth&action=reset&token='.$forgotToken;

                // gửi mail cho người dùng
                $subject = 'Yêu cầu khôi phục mật khẩu';
                $content = 'Chào bạn'.'<br>';
                $content .= 'Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn. Vui lòng nhấp vào link sau để dổi lại mật khẩu của bạn: <br>';
                $content .= $linkReset .'<br>';
                $content .= 'Trân trọng cảm ơn!';

                $sendMail = sendMail($email, $subject, $content);

                if($sendMail) {
                    setFlashData('msg', 'Vui lòng kiểm tra email để xem hướng dẫn đặt lại mật khẩu!.');
                    setFlashData('msg_type', 'success');
                } else {
                    setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sau!(email).');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Lỗi hệ thống vui lòng thử lại sau!.');
                setFlashData('msg_type', 'danger');
            }

        } else {
            setFlashData('msg', 'Địa chỉ email không tồn tại trong hệ thống.');
            setFlashData('msg_type', 'danger');
        }
        
    } else {
        setFlashData('msg', 'Vui lòng nhập địa chỉ email');
        setFlashData('msg_type', 'danger');
    }

    // redirect('?module=auth&action=forgot');

}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type')

?>

<div class="row">
    <div class="col-3" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Quên mật khẩu </h2>
        <?php
            if(!empty($msg)) {
                getSmg($msg, $msgType);
            }
        ?>
        <form action="" method="POST">
            <div class="form-group mb-4">
                <label for="" class="mb-2">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Địa chỉ email">
            </div>

            <button type="submit" class="btn btn-primary btn-block w-100">Gửi</button>
            <hr>
            <p class="text-center"> <a href="?module=auth&action=forgot">Đăng nhập</a></p>
            <p class="text-center"> <a href="?module=auth&action=register">Đăng kí tài khoản</a></p>
        
        </form>
    </div>
</div>


<?php
    layouts('footer');
?>