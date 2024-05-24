<?php
    require_once "connect.php";

    $sql = "SELECT * FROM hocsinh";


    // Truy van tat ca co so du lieu
    // try {
    //     $statement = $conn -> prepare($sql);
    //     $statement -> execute();

    //     $data = $statement -> fetchAll(PDO::FETCH_ASSOC);

    //     echo '<pre>';
    //     print_r($data);
    //     echo '</pre>';
    // } catch(Exception $exp) {
    //     echo $exp -> getMessage().'<br>';
    //     echo 'File: '. $exp -> getFile().'<br>';
    //     echo 'Line: '. $exp -> getLine();
    // }

    // Truy van tat ca co so du lieu
    $sql = "SELECT * FROM hocsinh";


    // Truy van tat ca co so du lieu
    $sql = "SELECT * FROM hocsinh WHERE id =?";
    $id = 10;

    try {
        $statement = $conn -> prepare($sql);
        
        $arr = [$id];
        $statement -> execute($arr);

        $data = $statement -> fetch(PDO::FETCH_ASSOC);

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    } catch(Exception $exp) {
        echo $exp -> getMessage().'<br>';
        echo 'File: '. $exp -> getFile().'<br>';
        echo 'Line: '. $exp -> getLine();
    }

    
?>

