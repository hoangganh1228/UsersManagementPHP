<?php
    require_once "connect.php";

    $sql = "UPDATE hocsinh SET fullname = :fullname, age = :age WhERE id = :id";

    // Data
    $fullname = 'Hoàng';
    $age = 25;
    $id = 9;


    try {
        //code...
        $statement = $conn -> prepare($sql);

        // $statement -> bindParam(':fullname',$fullname);
        // $statement -> bindParam(':age', $age);
        // $statement -> bindParam(':id', $id);

        $data = [
            'fullname' => $fullname,
            'age' => $age,
            'id' => $id
        ];

        $updateStatus = $statement -> execute($data);
        if($updateStatus) {
            echo 'Update thanh cong';
        }

    } catch (Exception $exp) {
        //throw $th;
        echo $exp -> getMessage().'<br>';
        echo 'File: '. $exp -> getFile().'<br>';
        echo 'Line: '. $exp -> getLine();
    }

?>
