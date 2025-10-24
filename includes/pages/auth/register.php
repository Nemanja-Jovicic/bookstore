<?php
    if(isset($_SESSION['user'])){
        header("Location: index.php?page=errors&code=403");
    }
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-4 mx-auto">
            <div id="message" class="mb-2"></div>
            <h1 class="mb-2 fs-2 text-center">Registrujte se</h1>
            <form action="#" method="post">
                <div class="mb-2">
                    <label for="first_name" class="mb-1">Ime</label>
                    <input type="text" name="first_name" id="first_name" class="form-control mb-1">
                    <div id="first_name_error"></div>
                </div>
                <div class="mb-2">
                    <label for="last_name" class="mb-1">Prezime</label>
                    <input type="text" name="last_name" id="last_name" class="form-control mb-1">
                    <div id="last_name_error"></div>
                </div>
                <div class="mb-2">
                    <label for="email" class="mb-1">Email</label>
                    <input type="email" name="email" id="email" class="form-control mb-1">
                    <div id="email_error"></div>
                </div>
                <div class="mb-2">
                    <label for="password" class="mb-1">Lozinka</label>
                    <input type="password" name="password" id="password" class="form-control mb-1">
                    <div id="password_error"></div>
                </div>
                <div class="d-grid gap-3">
                    <button class="btn btn-primary btn-auth btn-register" type="button" id="btnRegister">Register</button>
                    <div class="d-flex justify-content-center gap-2">
                        <span>Vec imate nalog?</span>
                        <a href="index.php?page=login">Ulogujte se</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>