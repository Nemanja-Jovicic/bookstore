<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    include '../functions.php';
    $link = $_GET['link'];
    try {
        require_once '../../config/connection.php';
        echo json_encode([
            'data' => [
                'data' => getAllAuthors($link),
                'pages' => paginationAuthor(),
                'link' => $link
            ]
        ]);
    } catch (PDOException $th) {
        intervalError($th->getMessage());
    }
} else {
    pageNotFound();
}
