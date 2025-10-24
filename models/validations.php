<?php
include 'validatioN_functions.php';
function registerValidation($first_name, $last_name, $email, $password)
{
    $errorArray = [];
    $regFirstLastName = "/\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/";
    $regPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

    inputFieldValidation("Ime nije u redu!", $errorArray, $first_name, $regFirstLastName);
    inputFieldValidation("Prezime nije u redu!", $errorArray, $last_name, $regFirstLastName);
    inputFieldValidation("Email nije u redu", $errorArray, $email);
    inputFieldValidation("Password nije u redu", $errorArray, $password, $regPassword);

    return $errorArray;
}



function loginValidation($email, $password)
{
    $errorArray = [];
    $regPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
    inputFieldValidation("Email nije u redu", $errorArray, $email);
    inputFieldValidation("Password nije u redu", $errorArray, $password, $regPassword);

    return $errorArray;
}
