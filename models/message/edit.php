<?php
header("Content-type:application/json");
if($_SERVER['REQUEST_METHOD'] === "GET"){
    require_once '../functions.php';
    try {
        require_once '../../config/connection.php';
        echo json_encode(['data' => getOneMessageFullRow($_GET['id'])]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
}
else {
    pageNotFound();
}