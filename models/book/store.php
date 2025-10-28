<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../validations.php';
    include '../functions.php';

    $name = $_POST['name'];
    $link = isset($_POST['link']) ? $_POST['link'] : 0;
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

    $validation = bookFormValidation($name);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            if ($checkBookName($name)) {
                conflictError("Knjiga sa tim nazivom vec postoji");
            } else {
                storeNewBook($name);
                echo json_encode([
                    'data' => [
                        'data' => getAllBooks($link, $keyword),
                        'link' => $link,
                        'pages' => paginationBook($keyword)
                    ],
                    'message' => 'Novi author je dodat'
                ]);
                operationSuccess();
            }
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
