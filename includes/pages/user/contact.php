<?php 
    if(isset($_SESSION['user']) && $_SESSION['user']->role_id === 1){
        header("Location: admin.php?page=errors&code=403");
    }
?>

<main class="container">
    <div class="row mt-5">
        <div class="col-lg-4 mx-auto">
            <div id="message" class="mb-2"></div>
            <h1 class="fs-3 text-center mb-5">Kontaktirajte nas</h1>
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
                    <label for="message_contact" class="mb-1">Poruka</label>
                    <textarea name="message_contact" id="message_contact" class="form-control mb-1" cols="5" rows="3"></textarea>
                    <div id="message_contact_error"></div>
                </div>
                <button class="btn btn-sm btn-primary" id="btnContactUs" type="button">Kontaktirajte nas</button>
            </form>
        </div>
    </div>
</main>