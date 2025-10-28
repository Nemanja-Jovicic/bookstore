<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../functions.php';
    include '../validations.php';

    $id = $_POST['id'];
    $name = $_POST['name'];

    $validation = bookFormValidation($name);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            $checkBookName = $checkBookName($name);
            if ($checkBookName && $checkBookName->name === $name && $checkBookName->id !== $id) {
                conflictError("Knjiga sa tim nazivom vec postoji!");
            } else {
                updateBook($id, $name);
                echo json_encode(['data' => $getOneBookFullRow($id), 'message' => 'Knjiga je izmenjen']);
            }
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
