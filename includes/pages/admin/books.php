<?php
if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id !== 1)) {
    header("Location: index.php?page=errors&code=403");
}
$books = getAllBooks();
$pages = paginationBook();
?>
<main class="container">
    <div class="row mt-5" id="events">
        <div id="message" class="mb-2"></div>
        <div class="row">
            <div class="col-lg-3">
                <input type="text" name="book-keyword" id="keyword" class="form-control mb-2 search-filter search-book" placeholder="Pretrazi po naslovu....">
            </div>
        </div>
        <div class="col-lg-8 mb-2 mb-lg-0">
            <div class="table-responsive-sm table-responsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Novo izdanje</th>
                            <th scope="col">Izmena</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="book_table">
                        <?php foreach ($books as $index => $book): ?>
                            <tr id="book_<?= $index ?>">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $book->name ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($book->created_at)) ?></td>
                                <td><?= $book->updated_at !== null ? date('d/m/Y H:i:s', strtotime($book->updated_at)) : '-' ?></td>
                                <td><a href='admin.php?page=edition&id=<?= $book->id ?>' class="btn btn-sm btn-primary">Dodaj</a></td>
                                <td><button type="button" class="btn btn-sm btn-success btn-edit btn-book" data-id="<?= $book->id ?>" data-index="<?= $index ?>">Izmeni</button></td>
                                <td><button class="btn btn-sm btn-danger btn-delete btn-book" type="button" data-id="<?= $book->id ?>" data-status="<?= $book->is_deleted ?>" data-index="<?= $index ?>">
                                        <?= $book->is_deleted === 0 ? 'Izbrisi' : 'Aktiviraj' ?>
                                    </button></td>
                            </tr>
                        <?php endforeach ?>
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
        <div class="col-lg-4">
            <form action="#" method="post">
                <input type="hidden" name="book_id" id="book_id">
                <input type="hidden" name="book_index" id="book_index">
                <div class="mb-2">
                    <label for="name" class="mb-1">Naziv knjige</label>
                    <input type="text" name="name" id="name" class="form-control mb-1">
                    <div id="name_error"></div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-sm btn-primary btn-save btn-book" type="button">Save</button>
                    <button class="btn btn-sm btn-danger btn-reset btn-book" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</main>