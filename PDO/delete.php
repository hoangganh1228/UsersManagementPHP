<?php
require_once "connect.php";

$sql = "DELETE FROM hocsinh WHERE id = ?";

$id = 7;

try {
    //code...
    $statement = $conn -> prepare($sql);

    $data = [$id];

    $deleteStatus = $statement -> execute($data);
    var_dump($deleteStatus);
} catch (Exception $exp) {
    //throw $th;
    echo $exp -> getMessage().'<br>';
    echo 'File: '. $exp -> getFile().'<br>';
    echo 'Line: '. $exp -> getLine();
}

?>