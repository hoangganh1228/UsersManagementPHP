<!-- Đăng nhập tài khoản -->
<?php

if(!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle' => 'Đăng nhập tài khoản'
];

// require_once _WEB_PATH_TEMPLATES .'/layout/header.php';
layouts('header', $data);

// Kiểm tra trạng thái đăng nhập 
if(isLogin()) {
    redirect('/?module=home&action=dashboard');
}

if(isPost()) {
    $filterAll = filter();
    if(!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        // kiểm tra đăng nhập
        $email = $filterAll['email'];
        $password = $filterAll['password'];
        
       

        // Truy vấn lấy thông tin users theo email
        $userQuery = oneRaw("SELECT password, id FROM users WHERE email = '$email'");
       
        if(!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if(password_verify($password, $passwordHash)) {

                // Tạo token login
                $tokenLogin = sha1(uniqid().time());

                // insert vào bảng tokenLogin
                $dataInsert = [
                    'user_Id' => $userId,
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s')
                ];

                $insertStatus = insert('tokenlogin  ', $dataInsert);
                if($insertStatus) {
                    // Insert thành công
                    
                    // Luu loginToken vào sêssion
                    setSession('loginToken', $tokenLogin);

                    redirect('?module=home&action=dashboard');
                } else {
                    setFlashData('msg', 'Không thể đăng nhập. Vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                }

                redirect('?module=home&action=dashboard'); 


            } else {
                setFlashData('msg', 'Mật khẩu không chính xác.');
                setFlashData('msg_type', 'danger');
                
            }

        } else {
            setFlashData('msg', 'Email không tồn tại.');
            setFlashData('msg_type', 'danger');
        }

    } else {
        setFlashData('msg', 'Vui lòng nhập email và mật khẩu.');
        setFlashData('msg_type', 'danger');
    }
    redirect('?module=auth&action=login');

}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type')

?>

<div class="row">
    <div class="col-3" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Đăng nhập quản lí </h2>
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
            <div class="form-group mb-3">
                <label for="" class="mb-2">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Mật khâủ">
            </div>

            <button type="submit" class="btn btn-primary btn-block w-100">Đăng nhập</button>
            <hr>
            <p class="text-center"> <a href="?module=auth&action=forgot">Quên mật khẩu</a></p>
            <p class="text-center"> <a href="?module=auth&action=register">Đăng kí tài khoản</a></p>
        
        </form>
    </div>
</div>


<?php
    layouts('footer');
?>