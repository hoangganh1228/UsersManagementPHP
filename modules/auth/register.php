<!-- Đăng kí tài khoản -->
<?php

if(!defined('_CODE')) {
    die('Access denied ...');
}

if(isPost()) {
    $filterAll = filter();
    $errors = []; //Mảng chứa các lỗi

    // Validater fullname: Bắt buộc phải nhập min là 5 kí tự    
    if(empty($filterAll['fullname'])) {
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập!';
    } else {
        if(strlen($filterAll['fullname']) < 5) {
            $errors['fullname']['min'] = 'Họ tên phải có ít nhất 5 kí tự!';
        }
    }

    // Validate email: Bắt buộc phải nhập, đúng định dạng email không, đã tồn tại trong cơ sở dữ liệu chưa
    if(empty($filterAll['email'])) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập!';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        if(getRows($sql) > 0) {
            $errors['email']['unique'] = 'Email đã tồn tại';
        }
    } 

    // // Validate sdt: bắt buộc phải nhâp, sdt có đúng định dạng không

    if(empty($filterAll['phone'])) {
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập!';
    } else {
        if(!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ!';
        }
    } 

    // Validate password: Băt buộc phải nhập >= 8 kí tư
    if(empty($filterAll['password'])) {
        $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập!';
    } else {
        if(strlen($filterAll['password']) < 8) {
            $errors['password']['min'] = 'Mật khẩu lớn hơn hoặc bằng 8.';
        }
    } 


    // Validate Pasword Confirm: bắt buộc phải nhập, giống password
    if(empty($filterAll['password_confirm'])) {
        $errors['password_confirm']['required'] = 'Bạn phải nhập lại mật khẩu!';
    } else {
        if(($filterAll['password']) != ($filterAll['password_confirm'])) {
            $errors['password_confirm']['match'] = 'Mật khẩu bạn nhập lại không đúng.';
        }
    } 

    if(empty($errors)) {
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            "create_at" => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('users', $dataInsert);

        if($insertStatus) {
            // Xử lý insert
            setFlashData('smg', 'Đăng kí thành công!');
            setFlashData('smg_type', 'success');

            // Tạo link kích hoạt
            $linkActive = _WEB_HOST . '?module=auth&action=active&token='. $activeToken;

            // Thiết lập gửi mail
            $subject = $filterAll['fullname']. '! Vui lòng kích hoạt tài khoản!!';
            $content = 'Chào ' .$filterAll['fullname'] . '<br>';
            $content .= 'Vui lòng click vào link dưới đây để kích hoạt tài khoản: </>';
            $content .= $linkActive . '</br>';
            $content .= "Trân trọng cảm ơn!!"; 


            // Tiến hành gửi mail
            $sendMail = sendMail($filterAll['email'], $subject, $content);
            if($sendMail) {
                setFlashData('smg', 'Đăng kí thành công! Vui lòng kiểm tra email để kích hoạt tài khoản!!!');
                setFlashData('smg_type', 'success');
            } else {
                setFlashData('smg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau!!!');
                setFlashData('smg_type', 'danger');
            }
        } else{
            setFlashData('smg', 'Đăng kí không thành công!!!');
            setFlashData('smg_type', 'danger');
        }

        
        redirect('?module=auth&action=register');

        
    } else {
        setFlashData('smg', 'Vui lòng kiểm tra lại dữ liệu!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect('?module=auth&action=register');
    }

    

}

$data = 'Trang đăng kí';

// delete('users', 'id = 2');


// require_once _WEB_PATH_TEMPLATES .'/layout/header.php';
layouts('header');

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

// echo '<pre>';
// print_r($old) ;
// echo '</pre>' ;
?>

<div class="row">
    <div class="col-3" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Đăng kí quản lí </h2>
        <?php
            if(!empty($smg)) {
                getSmg($smg, $smg_type);
            }
        ?>
        <form action="" method="POST">
            <div class="form-group mb-2 mt-3px">
                <label for="" class="mb-2">Họ tên</label>
                <input type="fullname" name="fullname" class="form-control" placeholder="Họ và tên" value="<?php echo old('fullname', $old) ?>">
                <?php
                    echo form_error('fullname', '<span class="error">', '</span>', $errors);

                ?>
            </div>
            <div class="form-group mb-2">
                <label for="" class="mb-2">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Địa chỉ email" value="<?php echo old('email', $old) ?>">
                <?php
                    // echo (!empty($errors['email'])) ? '<span class="error">'. reset($errors['email']) .'</span>' : null;
                    echo form_error('email', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group mb-2">
                <label for="" class="mb-2">Số điện thoại</label>
                <input type="number" name="phone" class="form-control" placeholder="+84" value="<?php echo old('phone', $old) ?>">
                <?php
                    echo form_error('phone', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group mb-3">
                <label for="" class="mb-2">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo old('password', $old) ?>">
                <?php
                    echo form_error('password', '<span class="error">', '</span>', $errors);

                ?>
            </div>
            <div class="form-group mb-3">
                <label for="" class="mb-2">Nhập lại Password</label>
                <input type="password" name="password_confirm" class="form-control" placeholder="Nhập lại Password" value="<?php echo old('password_confirm', $old) ?>">
                <?php
                    echo form_error('password_confirm', '<span class="error">', '</span>', $errors);

                ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block w-100">Đăng ký</button>
            <hr>
            <p class="text-center"> <a href="?module=auth&action=login">Đăng nhập tài khoản</a></p>
        
        </form>
    </div>
</div>


<?php
    layouts('footer');
?>