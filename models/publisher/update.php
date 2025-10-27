<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include '../functions.php';
    include '../validations.php';


    $id = $_POST['id'];
    $name = $_POST['name'];

    $validation = publisherValidation($name);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            $checkName = $checkPublisherName($name);
            if($checkName && $checkName->name == $name  && $checkName->id !== $id){
                conflictError("Izdavac sa tim nazivom vec postoji");
            }else{
                updatePublisher($name ,$id);
                echo json_encode(['data' => $getOnePublisherFullRow($id) ,'message' => 'Izdavac je izmenjen']);
            }
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
