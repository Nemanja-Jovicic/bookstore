<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST['id'];
    $status = $_POST['status'];

    include '../functions.php';

    try {
        require_once '../../config/connection.php';
        softDelete('books', $id, $status);
        echo json_encode(['data' => afterSoftDelete('books', $id)]);
    } catch (PDOException $th) {
       intervalError($th->getMessage());
    }
}else{
    pageNotFound();
}