<?php
if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id !== 1)) {
    header("Location: index.php?page=errors&code=403");
}
$authors = getAllAuthors();
$pages = paginationAuthor();
?>
<div class="container">
    <div class="row mt-5" id="events">
        <div class="mb-2" id="message"></div>
        <div class="col-lg-8 mb-2 mb-lg-0">
            <div class="table-responsive-sm table-responsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ime i prezime</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Izmeni</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="author_table">
                        <?php foreach ($authors as $index => $author): ?>
                            <tr id="author_<?= $index ?>">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $author->first_name . ' ' . $author->last_name ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($author->created_at)) ?></td>
                                <td><?= $author->updated_at !== null ? date("d/m/Y H:i:s", strtotime($author->updated_at)) : "-" ?></td>
                                <td><button class="btn btn-sm btn-success btn-edit btn-author" type="button" data-id="<?= $author->id ?> " data-index="<?= $index ?>">Edit</button></td>
                                <td><button type="button" class="btn btn-sm btn-danger btn-delete btn-author"
                                        data-id="<?= $author->id ?>" data-index="<?= $index ?>" data-status="<?= $author->is_deleted ?>"><?= $author->is_deleted === 0 ? "Izbrisi" : "Aktiviraj" ?></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-2 d-flex justify-content-center" id="author_pagination">
                    <?php for ($i = 0; $i < $pages; $i++): ?>
                        <li class="page-item"><a class="page-link page-author <?= $i == 0 ? 'active' : '' ?>" href="#"
                                data-link="<?= $i ?>"><?= $i + 1 ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <div class="col-lg-4">
            <form action="#" method="post">
                <input type="hidden" name="author_id" id="author_id">
                <input type="hidden" name="author_index" id="author_index">
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
                <div class="d-grid gap-2">
                    <button class="btn btn-sm btn-primary btn-save btn-author"
                        type="button">Save</button>
                    <button class="btn btn-sm btn-danger btn-reset btn-author"
                        type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>