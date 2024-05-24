<?php
    if(!defined('_CODE')) {
        die('Access denied ...');
    }
    
    try {
        //code...
        if(class_exists('PDO')) {

            $dsn = 'mysql:dbname='._DB.';host='._HOST;

            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf-8
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Tao thong bao ngoai le khi gap loi
            ];

            $conn = new PDO($dsn, _USER, _PASS, $options);
            if($conn) {
                echo 'Kết nối thành công';
            }
        
        }

    } catch (Exception $exception) {
        //throw $th;
        echo'<div style="color: red; padding: 5px 15px; border: 1px solid red">';
        echo $exception -> getMessage().'<br>';
        echo'</div>';
        die();
    }
?>