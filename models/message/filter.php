<?php
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] === "GET"){
    require_once '../functions.php';
    $link = $_GET['link'];
    try {
        require_once '../../config/connection.php';
        echo json_encode([
           'data' => [
                'data' => getAllMessages($link),
                'link' => $link,
                'pages' => paginationMessages()
            ]
        ]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
}else{
    pageNotFound();
}