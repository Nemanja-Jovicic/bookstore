<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    include '../functions.php';
    include '../validations.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $link = isset($_POST['link']) ? $_POST['link'] : 0;

    $validation = authorFormValidation($first_name, $last_name);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            storeNewAuthor($first_name, $last_name);
            echo json_encode([
                'data' => [
                    'data' => getAllAuthors($link),
                    'link' => $link,
                    'pages' => paginationAuthor()
                ],
                'message' => 'Novi author je dodat'
            ]);
            operationSuccess();
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
