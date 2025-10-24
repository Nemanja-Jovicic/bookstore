<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    include '../validations.php';
    include '../functions.php';

    $validation = registerValidation($first_name, $last_name, $email, $password);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require '../../config/connection.php';
            !$checkEmail ?
                conflictError("Korisnicki nalog sa tim email-om postoji!")
                :
                createNewUser($first_name, $last_name, $email, $password);
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
