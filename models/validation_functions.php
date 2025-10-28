<?php
function inputFieldValidation($errorMessage, &$errorArray, $element, $regex = '')
{
    if (str_contains($element, '@')) {
        if (!filter_var($element, FILTER_VALIDATE_EMAIL)) {
            array_push($errorArray, $errorMessage);
        }
    } else {
        if (!preg_match($regex, $element)) {
            array_push($errorArray, $errorMessage);
        }
    }
}

function inputSelectValidation($input, $errorMessage, &$errorArray)
{
    if ((int)$input === 0) {
        array_push($errorArray, $errorMessage);
    }
}
function checkBoxValidation($arrayValue, $errorMessage, &$errorArray)
{
    if (count($arrayValue) === 0) {
        array_push($errorArray, $errorMessage);
    }
}
function inputFileValidaiton($fileInput, $errorArrayMessages, &$errorArray)
{
    list($emptyError, $typeError, $sizeError) = $errorArrayMessages;
    if ($fileInput === "") {
        array_push($errorArray, $emptyError);
    } else {
        $validTypes = ["image/png", "image/jpeg", "image/jpg"];
        if (!in_array($fileInput['type'], $validTypes)) {
            array_push($errorArray, $typeError);
        }
        if($fileInput['size'] > 3 * 1024 * 1024){
             array_push($errorArray, $sizeError);
        }
    }
}
