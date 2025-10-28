<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include '../functions.php';
    $link = isset($_GET['link']) ? $_GET['link'] : 0;
    $keyword = isset($_GET['key']) ? $_GET['key'] : '';

    try {
        require_once '../../config/connection.php';
        echo json_encode([
            'data' => [
                'data' => getAllBooks($link, $keyword),
                'link' => $link,
                'pages' => paginationBook($keyword)
            ]
        ]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
} else {
    pageNotFound();
}
