<?php
define("ADMIN_OFFSET", 5);
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
    echo json_encode(["error" => "Doslo je do greske! Molimo vas pokusajte kasnije."]);
}
function conflictError($error)
{
    http_response_code(409);
    echo json_encode(["error" => $error]);
}
function badCredentials($error)
{
    http_response_code(401);
    echo json_encode(['error' => $error]);
}
function unAuthorizedError($code)
{
    $location = '';
    $message = '';
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']->role_id === 1) {
            if ($code === 403) {
                $location = 'admin.php';
                $message = 'Ne mozete pristupiti ovoj stranici';
            } else {
                $location = 'admin.php';
                $message = 'Stranica nije pronadjena';
            }
        } else {
            if ($code === 403) {
                $location = 'index.php';
                $message = 'Ne mozete pristupiti ovoj stranici';
            } else {
                $location = 'index.php';
                $message = 'Stranica nije pronadjena';
            }
        }
    } else {
        if ($code === 403) {
            $location = 'index.php';
            $message = 'Ne mozete pristupiti ovoj stranici';
        } else {
            $location = 'index.php';
            $message = 'Stranica nije pronadjena';
        }
    }
    return ['location' => $location, 'message' => $message];
}
function operationSuccess()
{
    http_response_code(201);
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
function getAll($query)
{
    global $connection;
    return $connection->query($query)->fetchAll();
}
function softDelete($table, $id, $statusValue)
{
    global $connection;
    $statusValue = (int)$statusValue === 0 ? 1 : 0;
    $query = "update $table set is_deleted = ? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$statusValue, $id]);
}
function afterSoftDelete($table, $id)
{
    return getAll("select id, is_deleted from $table where id = '$id'");
}
function pagination($query)
{
    $res = getOneRow($query);
    return ceil($res->numberOfElements / (int)ADMIN_OFFSET);
}

function deleteFromPivot($table, $columnWhere, $columnValue)
{
    global $connection;
    $query = "DELETE  FROM $table WHERE $columnWhere = ?";
    $delete = $connection->prepare($query);
    $delete->execute([$columnValue]);
}


// auth
$checkEmail = fn($email) => getOneRow("select email from users where email = '$email'");
function createNewUser($first_name, $last_name, $email, $password)
{
    global $connection;
    define("USER_ROLE", 2);
    $query = "insert into users (first_name, last_name, email, password,role_id) values(?,?,?,?,?)";
    $insertUser = $connection->prepare($query);
    $insertUser->execute([$first_name, $last_name, $email, md5($password), (int)USER_ROLE]);
}
function loginUser($email, $password)
{
    global $connection;
    $query = "select id,role_id from users where email = ? and password = ?";
    $select = $connection->prepare($query);
    $select->execute([$email, md5($password)]);
    return $select->fetch();
}

// authors

function getAllAuthors($limit = 0)
{
    $query = "select * from authors";
    $limit = (int) $limit * ADMIN_OFFSET;
    $offset = (int)ADMIN_OFFSET;
    $query .= " limit $limit, $offset";
    return getAll($query);
}
function paginationAuthor()
{
    $query = "select count(*) as numberOfElements from authors";
    return pagination($query);
}
$getOneAuthor = fn($id) => getOneRow("select id, first_name, last_name from authors where id = '$id'");
$getOneAuthorFullRow = fn($id) => getOneRow("select * from authors where id = '$id'");
function storeNewAuthor($first_name, $last_name)
{
    global $connection;
    $query = "insert into authors (first_name, last_name) values (?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$first_name, $last_name]);
}
function updateAuthor($id, $first_name, $last_name)
{
    global $connection;
    $date = date("Y/m/d H:i:s");
    $query = "update authors set first_name = ?, last_name = ? , updated_at = ? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$first_name, $last_name, $date, $id]);
}

// publishers 

function getAllPublishers($limit = 0)
{
    $query = "select * from publishers";
    $offset = (int)ADMIN_OFFSET;
    $limit = (int)$limit * $offset;
    $query .= " limit $limit, $offset";
    return getAll($query);
}
function paginationPublisher()
{
    $query = "select count(*) as numberOfElements from publishers";
    return pagination($query);
}
$checkPublisherName = fn($name) => getOneRow("select id, name from publishers where name = '$name'");
$getOnePublisherFullRow = fn($publisherId) => getOneRow("select * from publishers where id = '$publisherId'");
$getOnePublisher = fn($publisherId) => getOneRow("select id, name from publishers where id ='$publisherId'");
function storeNewPublisher($name)
{
    global $connection;
    $query = "insert into publishers (name) values(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name]);
}
function updatePublisher($name, $id)
{
    global $connection;
    $date = date("Y-m-d H:i:s");
    $query = "update publishers set name =?, updated_at =? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$name, $date, $id]);
}


// books
$checkBookName = fn($name) => getOneRow("select id, name from books where name='$name'");
$getOneBook = fn($bookId) => getOneRow("select id, name from books where id ='$bookId'");
$getOneBookFullRow = fn($bookId) => getOneRow("select * from books where id ='$bookId'");
function getAllBooks($limit = 0, $keyword = '')
{
    $query = "select * from books";
    if ($keyword !== '') {
        $keyword = trim($keyword);
        $compareString = "%$keyword%";
        $query .= " where name like '$compareString'";
    }
    $limit = (int)$limit * (int)ADMIN_OFFSET;
    $offset = (int)ADMIN_OFFSET;
    $query .= " limit $limit, $offset";
    return getAll($query);
}
function paginationBook($keyword = '')
{
    $query = "select count(*) as numberOfElements from books";
    if ($keyword !== '') {
        $keyword = trim($keyword);
        $compareString = "%$keyword%";
        $query .= " where name like '$compareString'";
    }
    return pagination($query);
}
function storeNewBook($name)
{
    global  $connection;
    $query = "insert into books (name) values(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name]);
}
function updateBook($id, $name)
{
    global $connection;
    $date = date("Y-m-d H:i:s");
    $query = "update books set name = ?, updated_at =? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$name, $date, $id]);
}

// editions

function moveImage($image)
{
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_type = $image['type'];
    $new_image_name = time() . "_" . $image_name;
    $normal_path = "../../assets/images/big/$new_image_name";
    move_uploaded_file($image_tmp, $normal_path);
   resizeImage($normal_path, $new_image_name,   $image['type']);
    return $new_image_name;
}

function resizeImage($image_path,$image_name, $image_type)
{
   list($width, $height) = getimagesize($image_path);

    $normalHeight = 300;
    $smallHeight = 150;

    $normalWidth = $width * ($normalHeight / $height);
    $smallWidth = $width * ($smallHeight / $height);

    $normal_canvas = imagecreatetruecolor($normalWidth, $normalHeight);
    $small_canvas = imagecreatetruecolor($smallWidth, $smallHeight);

    $source_image = '';
    if ($image_type === 'image/jpeg') {
        $source_image = imagecreatefromjpeg($image_path);
    } else if ($image_type === 'image/png') {
        $source_image = imagecreatefrompng($image_path);
    }

    imagecopyresampled($normal_canvas, $source_image, 0, 0, 0, 0, $normalWidth, $normalHeight, $width, $height);
    imagecopyresampled($small_canvas, $source_image, 0, 0, 0, 0, $smallWidth, $smallHeight, $width, $height);


    $normalPath = "../../assets/images/normal/$image_name";
    $smallPath = "../../assets/images/small/$image_name";

    if ($image_type === 'image/jpeg') {
        imagejpeg($normal_canvas, $normalPath);
        imagejpeg($small_canvas, $smallPath);
    } else if ($image_type === 'image/png') {
        imagepng($normal_canvas, $normalPath);
        imagepng($small_canvas, $smallPath);
    }
}

$getAvailableAuthors = fn() => getAll("select id, first_name, last_name from authors where is_deleted = 0");
$getAvailablePublishers = fn() => getAll("select id, name from publishers where is_deleted = 0");
$getAvailableGenres = fn() => getAll("select id, name from genres");
$getCoverTypes = fn() => getAll("select id, name from cover_types");
$getLetterTypes = fn() => getAll('select id, name from typography');

$checkEditionBook = fn($bookId, $publisherId, $coverTypeId, $letterTypeId) => getOneRow("select id, book_id, publisher_id, cover_type_id, type_id from editions where book_id ='$bookId' and type_id = '$letterTypeId' and cover_type_id ='$coverTypeId' and publisher_id ='$publisherId'");
function getOneBooKEditionFullRow($id)
{
    $query = "select e.id, e.created_at, e.updated_at, e.is_deleted,
    p.name as publisherName, ct.name as coverType, lt.name as letterType
    from editions e join publishers p 
    on e.publisher_id = p.id
    join cover_types ct on e.cover_type_id = ct.id
    join typography lt on e.type_id = lt.id
    where e.id = '$id'";
    return getOneRow($query);
}
function getAllBookEditions($book_id, $link = 0)
{
    $query = "select e.id, e.created_at, e.updated_at, e.is_deleted,
    p.name as publisherName, ct.name as coverType, lt.name as letterType
    from editions e join publishers p 
    on e.publisher_id = p.id
    join cover_types ct on e.cover_type_id = ct.id
    join typography lt on e.type_id = lt.id
    where e.book_id = '$book_id'";
    return getAll($query);
}
function editionPagination($book_id)
{
    $query = "select count(*) as numberOfElements from editions where book_id = '$book_id'";
    return pagination($query);
}
function getOneBookEdition($editionId)
{
    $query = "select e.id, e.cover_type_id, 
    e.publisher_id, e.type_id,e.image_path,e.price,
    e.description
    from editions e 
    where e.id = '$editionId'";
    $res = getOneRow($query);
    $res->authors = getEditionAuthors($editionId);
    $res->genres = getEditionGenre($editionId);
    return $res;
}
function getEditionAuthors($edition_id)
{
    $query = "select author_id from author_edition where edition_id = '$edition_id'";
    $authors = getAll($query);
    $array = [];
    foreach ($authors as $author) {
        array_push($array, $author->author_id);
    }
    return $array;
}
function getEditionGenre($edition_id)
{
    $query = "select genre_id from edition_genre where edition_id = '$edition_id'";
    $genres = getAll($query);
    $array = [];
    foreach ($genres as $genre) {
        array_push($array, $genre->genre_id);
    }
    return $array;
}
function storeNewEdition($book_id, $cover_type_id, $publisher_id, $type_id, $image_path, $price, $description, $authors, $genres)
{
    global $connection;
    $connection->beginTransaction();
    $query = "insert into editions (book_id, cover_type_id, publisher_id, type_id, image_path, price, description) values(?,?,?,?,?,?,?)";
    $insert = $connection->prepare($query);
    if ($insert->execute([$book_id, $cover_type_id, $publisher_id, $type_id, $image_path, $price, $description])) {
        $last_id = $connection->lastInsertId();
        insertIntoAuthorEdition($authors, $last_id);
        insertIntoGenreEditon($genres, $last_id);
        $connection->commit();
    } else {
        $connection->rollBack();
    }
}
function insertIntoAuthorEdition($authors, $id)
{
    global $connection;
    $queryParams = [];
    $queryValues = [];
    foreach ($authors as $author) {

        $queryParams[] = "(?,?)";
        $queryValues[] = (int)$author;
        $queryValues[] = (int)$id;
    }

    $query = "insert into author_edition (author_id, edition_id) values" . implode(',', $queryParams);

    $insert = $connection->prepare($query);
    $insert->execute($queryValues);
}
function insertIntoGenreEditon($genres, $id)
{
    global $connection;
    $queryParams = [];
    $queryValues = [];
    foreach ($genres as $genre) {
        $queryParams[] = "(?,?)";
        $queryValues[] = (int)$genre;
        $queryValues[] = (int)$id;
    }

    $query = "insert into edition_genre (genre_id, edition_id) values" . implode(',', $queryParams);
    $insert = $connection->prepare($query);
    $insert->execute($queryValues);
}
function updateBookEdition($id, $publisher_id, $cover_id, $letter_id, $genres, $authors, $price, $description, $image_name = '')
{
    global $connection;
    $connection->beginTransaction();
    $date = date("Y-m-d H:i:s");
    $queryArray = [];
    $query = "UPDATE editions SET cover_type_id = ?, publisher_id = ?, type_id = ?, ";
    array_push($queryArray, $cover_id);
    array_push($queryArray, $publisher_id);
    array_push($queryArray, $letter_id);
    if ($image_name !== "") {
        $query .= " image_path = ?,";
        array_push($queryArray, $image_name);
    }
    $query .= "price =?, description = ?, updated_at = ? where id = ?";
    array_push($queryArray, $price);
    array_push($queryArray, $description);
    array_push($queryArray, $date);
    array_push($queryArray, $id);
    $update = $connection->prepare($query);
    if ($update->execute($queryArray)) {
        deleteFromPivot('author_edition', 'edition_id', $id);
        deleteFromPivot('edition_genre', 'edition_id', $id);

        insertIntoAuthorEdition($authors, $id);
        insertIntoGenreEditon($genres, $id);

        $connection->commit();
    } else {
        $connection->rollBack();
    }
}
