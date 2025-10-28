<?php
header("Content-type:appcalition/json");
if ($_SERVER['REQUEST_METHOD'] === "POST") {


    include '../functions.php';
    include '../validations.php';

    $id = $_POST['id'];
    $book_id = $_POST['book_id'];
    $publisher = $_POST['pubilsher'];
    $cover_type = $_POST['cover_type'];
    $letter_type = $_POST['letter_type'];
    $price = $_POST['price'];
    $genres = explode(',', $_POST['genres']);
    $authors = explode(',', $_POST['authors']);
    $validation_description = $_POST['validation_description'];
    $description = $_POST['description'];
    $image = isset($_FILES['image']) ? $_FILES['image'] : '';
    $cover = $_POST['cover'];

    $validation = editionValidation($publisher, $cover, $letter_type, $genres, $authors, $price, $validation_description, $image, $id);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            $checkEditionBook = $checkEditionBook($book_id, $publisher, $cover_type, $letter_type);
            if ($checkEditionBook && $checkEditionBook->id !== (int)$id) {
                conflictError("Takvo izdanje vec postoji");
            } else {
                $image_name = '';
                if($image !== ''){
                    $image_name = moveImage($image);
                    
                }
                updateBookEdition($id, $publisher, $cover_type, $letter_type, $genres, $authors, $price, $description, $image_name);
                echo json_encode([
                    'data' => getOneBooKEditionFullRow($id),
                    'message' => "Izdanje je izmenjeno"
                ]);
            }
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
