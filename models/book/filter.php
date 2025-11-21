<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include '../functions.php';
    $link = isset($_GET['link']) ? $_GET['link'] : 0;
    $keyword = isset($_GET['key']) ? $_GET['key'] : '';

    try {
        require_once '../../config/connection.php';
        if($keyword === " "){
            $link = 0;
        }
        echo json_encode([
            'data' => [
                'data' => getAllBooks($link, $keyword),
                'link' => count(getAllBooks($link, $keyword)) > 0 ? $link : 0,
                'pages' => paginationBook($keyword)
            ]
        ]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
} else {
    pageNotFound();
}
