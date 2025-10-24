<?php
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    include '../functions.php';
    $id = $_POST['id'];
    $status = $_POST['status'];
    try {
        require_once '../../config/connection.php';
        softDelete("authors", $id, $status);
        echo json_encode(['data' => afterSoftDelete('authors', $id)]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
}else{
    pageNotFound();
}