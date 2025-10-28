<?php 
session_start();
require_once 'config/connection.php';
include 'models/functions.php';

include 'includes/parts/head.php';
include 'includes/parts/navigation.php';
if(isset($_GET['page'])){
    $page = $_GET['page'];
    if(file_exists("includes/pages/admin/$page.php")){
        include "includes/pages/admin/$page.php";
    }else{
        include 'includes/pages/global/error.php';
    }
}else{
    include 'includes/pages/admin/home.php';
}
include 'includes/parts/footer.php';