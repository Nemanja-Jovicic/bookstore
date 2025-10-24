<?php 
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    include '../functions.php';
    include '../validations.php';

    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $validation = authorFormValidation($first_name, $last_name);
    if(count($validation) > 0){
        validationError($validation);
    }else{
        try {
            require_once '../../config/connection.php';
            updateAuthor($id, $first_name, $last_name);
            echo json_encode(['data' => $getOneAuthorFullRow($id)]);
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
}
else{
    pageNotFound();
}