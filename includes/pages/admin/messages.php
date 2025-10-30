<?php
if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id !== 1)) {
    header("Location: index.php?page=errors&code=403");
}
$messages = getAllMessages();
$pages = paginationMessages();
?>

<div class="container">
    <div class="row mt-5" id="events">
        <div id="message" class="mb-2"></div>
        <div class="col-lg-10 mx-auto">
            <div class="table-responsive-sm table-repsonsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ime i prezime</th>
                            <th scope="col">Email</th>
                            <th scope="col">Datum kontakta</th>
                            <th scope="col">Procitaj</th>
                        </tr>
                    </thead>
                    <tbody id="editon_table">
                        <?php foreach ($messages as $index => $message): ?>
                            <tr id="message_<?= $index ?>">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $message->first_name . ' ' . $message->last_name ?></td>
                                <td><?= $message->email ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($message->created_at)) ?></td>
                                <td><button type="button" class="btn btn-sm  btn-success btn-edit btn-message" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $message->id ?>">
                                        Procitaj
                                    </button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-2 d-flex justify-content-center" id="book_pagination">
                    <?php for ($i = 0; $i < $pages; $i++): ?>
                        <li class="page-item"><a class="page-link <?= $i == 0 ? 'active' : '' ?> page-book " href="#"
                                data-link="<?= $i ?>"><?= $i + 1 ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="flex gap-1 mb-2">
                    <span>Od:</span>
                    <span class="text-muted" id="userFrom"></span>
                </div>
                <div class="flex gap-1 mb-2">
                    <span>Email:</span>
                    <span class="text-muted" id="emailFrom"></span>
                </div>
                <div class="flex gap-1 mb-2">
                    <span>Datum dolaska:</span>
                    <span class="text-muted" id="arrivedAt"></span>
                </div>
                <span class="mb-2">Poruka:</span>
                <p id="message_content" class="text-muted"></p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>