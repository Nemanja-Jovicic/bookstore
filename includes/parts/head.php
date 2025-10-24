<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js" defer></script>
    <script src="assets/js/bootstrap.bundle.min.js" defer></script>


    <script src="assets/js/utility_functions.js" defer></script>
    <script src="assets/js/validation_functions.js" defer></script>

    <?php if (!isset($_SESSION['user'])): ?>
        <script src="assets/js/auth.js" defer></script>
        <script src="assets/js/auth_validation.js" defer></script>
        <script src="assets/js/auth_functions.js" defer></script>
    <?php endif; ?>
</head>

<body>