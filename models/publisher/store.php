<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../functions.php';
    include '../validations.php';

    $name = $_POST['name'];
    $link = isset($_POST['link']) ? $_POST['link'] : 0;
    $validation = publisherValidation($name);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            if ($checkPublisherName($name)) {
                conflictError("Izdavac sa tim nazivom vec postoji");
            } else {
                storeNewPublisher($name);
                echo json_encode([
                    'data' => [
                        'data' => getAllPublishers($link),
                        'link' => $link,
                        'pages' => paginationPublisher()
                    ],
                    'message' => 'Novi izdavac je dodat'
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
