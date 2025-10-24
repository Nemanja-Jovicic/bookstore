<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];


    include '../validations.php';
    include '../functions.php';

    $validation = loginValidation($email, $password);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            if ($checkEmail($email)) {
                $checkAccount = loginUser($email, $password);
                if ($checkAccount) {
                    $_SESSION['user'] = $checkAccount;
                    echo json_encode(['data' => $checkAccount]);
                } else {
                    badCredentials("Nalog sa unetim kredencijalima nepostoji!");
                }
            } else {
                badCredentials("Nalog sa unetim email nepostoji!");
            }
        } catch (PDOException $th) {
            intervalError($th->getMessage());
        }
    }
} else {
    pageNotFound();
}
