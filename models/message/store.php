<?php
header("Content-type:application/json");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    include '../functions.php';
    include '../validations.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $validation = contactValidation($first_name, $last_name, $email, $message);
    if(count($validation) > 0){
        validationError($validation);
    }else{
       try {
        require_once '../../config/connection.php';
        storeNewContactMessage($first_name, $last_name, $email, $message);
        echo json_encode(['message' => "Hvala sto ste nas kontaktirali!"]);
        operationSuccess();
       } catch (PDOException $th) {
        intervalError($th->getMessage());
       }
    }
}
else{
    pageNotFound();
}