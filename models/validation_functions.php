<?php 
function inputFieldValidation($errorMessage, &$errorArray, $element, $regex = ''){
    if(str_contains($element, '@')){
        if(!filter_var($element, FILTER_VALIDATE_EMAIL)){
            array_push($errorArray, $errorMessage);
        }
    }else{
        if(!preg_match($regex, $element)){
            array_push($errorArray, $errorMessage);
        }
    }
}