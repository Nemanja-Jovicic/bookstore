<?php
    header("Content-type:application/json");
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        include '../functions.php';
        $id = $_GET['id'];
        try {
            require_once '../../config/connection.php';
            echo json_encode(['data' => $getOneBook($id)] );
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
    else{
        pageNotFound();
    }