<?php if (isset($_SESSION['user'])) {
    header("Location: index.php?page=errors&code=403");
} ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-4 mx-auto">
            <div id="message" class="mb-2"></div>
            <h1 class="mb-2 fs-2 text-center">Prijavite se</h1>
            <form action="#" method="post">
                <div class="mb-2">
                    <label for="email" class="mb-1">Email</label>
                    <input type="text" name="email" id="email" class="form-control mb-1">
                    <div id="email_error"></div>
                </div>
                <div class="mb-4">
                    <label for="password" class="mb-1">Lozinka</label>
                    <input type="password" name="password" id="password" class="form-control mb-1">
                    <div id="password_error"></div>
                </div>
                <div class="d-grid gap-3">
                    <button type='button' class="btn btn-primary btn-auth btn-register" id="btnLogin">Prijavi se</button>
                    <div class="d-flex justify-content-center gap-2">
                        <span>Nemate nalog?</span>
                        <a href="index.php?page=register">Registrujte se</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>