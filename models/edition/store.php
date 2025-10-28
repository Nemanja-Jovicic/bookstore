<?php header("content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../functions.php';
    include '../validations.php';

    $book_id = $_POST['book_id'];
    $publisher = $_POST['pubilsher'];
    $cover_type = $_POST['cover_type'];
    $letter_type = $_POST['letter_type'];
    $price = $_POST['price'];
    $genres = explode(',', $_POST['genres']);
    $authors = explode(',', $_POST['authors']);
    $validation_description = $_POST['validation_description'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    $link = isset($_POST['link']) ? $_POST['link'] : 0;

    $validation = editionValidation($publisher, $cover_type, $letter_type, $genres, $authors, $price, $validation_description, $image);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            if ($checkEditionBook($book_id, $publisher, $cover_type, $letter_type)) {
                conflictError("Izdanje sa ovakvim parametrima vec postoji");
            } else {
                $image = moveImage($image);
                storeNewEdition($book_id, $cover_type, $publisher, $letter_type, $image, $price, $description, $authors, $genres);
                echo json_encode([
                    'data' => [
                        'data' => getAllBookEditions($book_id, $link),
                        'link' => $link,
                        'pages' => editionPagination($book_id)
                    ],
                    'message' => 'Novi izdanje je dodato'
                ]);
            }
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
