<?php
if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id !== 1)) {
    header("Location: index.php?page=errors&code=403");
}
$publishers = getAllPublishers();
$pages = paginationPublisher();
?>
<main class="container">
    <div class="row mt-5" id="events">
        <div id="message" class="mb-2"></div>
        <div class="col-lg-8 mb-lg-0 mb-4">
            <div class="table-responsive-sm table-responsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Izmeni</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="publisher_table">
                        <?php foreach ($publishers as $index => $publisher): ?>
                            <tr id="publisher_<?= $index ?>">
                                <th scope="row"><?= $index +  1 ?></th>
                                <td><?= $publisher->name ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($publisher->created_at)) ?></td>
                                <td><?= $publisher->updated_at !== null ? date('d/m/Y H:i:s', strtotime($publisher->updated_at)) : '-' ?></td>
                                <td><button type="button" class="btn btn-sm btn-success btn-edit btn-publisher" data-id="<?= $publisher->id ?>" data-index="<?= $index ?>">Izmeni</button></td>
                                <td><button type='button' class="btn btn-sm btn-danger btn-delete btn-publisher" data-id='<?= $publisher->id ?>'
                                        data-index="<?=$index?>" data-status="<?=$publisher->is_deleted?>"><?=$publisher->is_deleted 
                                            === 0 ? "Izbrisi" : "Aktiviraj"?></button></td>
                                            
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination mt-2 d-flex justify-content-center" id="publisher_pagination">
                    <?php for ($i = 0; $i < $pages; $i++): ?>
                        <li class="page-item"><a class="page-link  <?= $i == 0 ? 'active' : '' ?> page-publisher" href="#"
                                data-link="<?= $i ?>"><?= $i + 1 ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <div class="col-lg-4">
            <form action="#" method="post">
                <input type="hidden" name="publisher_id" id="publisher_id">
                <input type="hidden" name="publisher_index" id="publisher_index">
                <div class="mb-2">
                    <label for="name" class="mb-1">Naziv izdavaca</label>
                    <input type="text" name="name" id="name" class="form-control mb-1">
                    <div id="name_error"></div>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-sm btn-primary btn-save btn-publisher">Save</button>
                    <button class="btn btn-sm btn-danger btn-reset btn-publisher" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</main>