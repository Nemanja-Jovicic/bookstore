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
function authorFormValidation($first_name, $last_name)
{
    $errorArray = [];
    $regFirstLastName = "/\b([A-ZÀ-ÿČĆŽŠĐ][-,a-zčćžšđ. ']+[ ]*)+/";
    inputFieldValidation("Ime nije u redu!", $errorArray, $first_name, $regFirstLastName);
    inputFieldValidation("Prezime nije u redu!", $errorArray, $last_name, $regFirstLastName);

    return $errorArray;
}
function publisherValidation($name)
{
    $errorArray = [];
    $regName = "/^[A-ZČĆŠĐŽ][a-zčćšđž]{1,}(\[A-ZČĆŠĐŽ][a-zčćšđž]{1,}|\s[a-zčćšđž]{1,})*$/";
    inputFieldValidation("Naziv izdavaca nije u redu!", $errorArray, $name, $regName);
    return $errorArray;
}
function bookFormValidation($name)
{
    $errors = [];
    $regBookName = "/^[A-ZČĆŠĐŽa-zčćšđž0-9 ,.'\":;!?()-]+$/";
    inputFieldValidation("Naziv knjige nije  u redu!", $errors, $name, $regBookName);
    return $errors;
}
function editionValidation($publisher, $cover_type, $letter_type, $genres, $authors, $price, $description, $image = '', $id = '')
{
    $errors = [];


    $regPrice = "/^[1-9]{1}[\d]{2,5}$/";
    $regDescription = "/^[\p{L}\p{N}\s.,!?()'\"-:]{10,2000}$/um";


    inputSelectValidation($publisher, "Morate izabrati izdavaca!", $errors);
    inputSelectValidation($cover_type, "Morate odabrati tip korice!", $errors);
    inputSelectValidation($letter_type, "Morate odabrati tip pisma!", $errors);
    checkBoxValidation($authors, "Morate odabrati barem jednog autora!", $errors);
    checkBoxValidation($genres, "Morate odabrati barem jedan zanr!", $errors);


    inputFieldValidation("Cena nije u redu!", $errors, $price, $regPrice);
    inputFieldValidation("Opis knjige nije u redu!", $errors, $description, $regDescription);

    if ($id === '') {
        inputFileValidaiton($image, ["Morate odabrati sliku!", "Slika nije u dobrom formatu!", "Velicina slike nije u redu!"], $errors);
    } else if ($image !== '') {
        inputFileValidaiton($image, ["Morate odabrati sliku!", "Slika nije u dobrom formatu!", "Velicina slike nije u redu!"], $errors);
    }
    return $errors;
}
function contactValidation($first_name, $last_name, $email, $message)
{
    $errors = [];
    $regFirstLastName = "/\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/";
    $regMessage  = " /^[\p{L}\p{N}\s.,!?()'\"-:]{10,2000}$/um";

    inputFieldValidation("Ime nije u redu!", $errors, $first_name, $regFirstLastName);
    inputFieldValidation("Prezime nije u redu!", $errors, $last_name, $regFirstLastName);
    inputFieldValidation("Email nije u redu!", $errors, $email);
    inputFieldValidation("Poruka nije u redu!", $errors, $message, $regMessage);

    return $errors;
}
