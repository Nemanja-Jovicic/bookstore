<?php
    $code = $_GET['code'];
    $redirection = unAuthorizedError($code);
?>
<div class="container">
    <div class="row mt-5">
        <div class="d-flex flex-column align-items-center gap-2">
            <h1 class="font-size-1"><?=$code?></h1>
            <p class="fs-3"><?=$redirection['message']?></p>
            <a href="<?=$redirection['location']?>" class="btn btn-outline-dark">Vratite se na pocetnu stranicu</a>
        </div>
    </div>
</div>