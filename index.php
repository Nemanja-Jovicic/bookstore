<?php 
session_start();
include 'includes/parts/head.php';
include 'includes/parts/navigation.php';
if(isset($_GET['page'])){
    $page = $_GET['page'];
    if(file_exists("includes/pages/auth/$page.php")){
        include "includes/pages/auth/$page.php";
    }
}else{
    include 'includes/pages/user/home.php';
}
include 'includes/parts/footer.php';