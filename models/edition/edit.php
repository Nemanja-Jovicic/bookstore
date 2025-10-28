<?php 
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = $_GET['id'];
    include '../functions.php';
    try {
        require_once '../../config/connection.php';
        echo json_encode([
            'data' => getOneBookEdition($id) 
        ]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
}else{
    pageNotFound();
}