<?php

// utility error functions
function pageNotFound()
{
    http_response_code(404);
    return ["error" => "Doslo je do greske! Molimo vas pokusajte kasnije."];
}
function validationError($errorArray)
{
    foreach ($errorArray as $error) {
        echo json_encode($error);
        http_response_code(422);
    }
}
function intervalError($error)
{
    http_response_code(500);
    writeIntoErrorFile($error);
    return ["error" => "Doslo je do greske! Molimo vas pokusajte kasnije."];
}

function conflictError($error){
    http_response_code(409);
     return ["error" => $error];
}

function badCredentials($error){
    http_response_code(401);
    echo json_encode(['error' => $error]);
}


// file functions

function writeIntoErrorFile($error)
{
    $date = date("d/m/Y H:i:s");
    $data = "$date\t$error\n";
    writeIntoFile("../../data/errorLog.txt", $data);
}
function writeIntoFile($path, $data)
{
    $file_open = fopen($path, "a") or die("Fajl ne postoji");
    fwrite($file_open, $data);
    fclose($file_open);
}

// global sql functions

function getOneRow($query)
{
    global $connection;
    return $connection->query($query)->fetch();
}

// auth
$checkEmail = fn($email) => getOneRow("select email from users where email = '$email'");
function createNewUser($first_name, $last_name, $email, $password){
    global $connection;
    define("USER_ROLE", 2);
    $query = "insert into users (first_name, last_name, email, password,role_id) values(?,?,?,?,?)";
    $insertUser = $connection->prepare($query);
    $insertUser->execute([$first_name, $last_name, $email, md5($password), (int)USER_ROLE]);
}
function loginUser($email, $password){
    global $connection;
    $query = "select id,role_id from users where email = ? and password = ?";
    $select = $connection->prepare($query);
    $select->execute([$email, md5($password)]);
    return $select->fetch();
}