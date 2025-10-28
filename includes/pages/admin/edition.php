<?php
if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id !== 1)) {
    header("Location: index.php?page=errors&code=403");
}
$id = $_GET['id'];
$editons = getAllBookEditions($id);
$cover_types = $getCoverTypes();
$letter_types = $getLetterTypes();
$publishers = $getAvailablePublishers();
$authors = $getAvailableAuthors();
$genres = $getAvailableGenres();
?>
<div class="container">
    <div class="row mt-5" id="events">
        <div id="message" class="mb-2"></div>
        <div class="col-lg-8 mb-2 mb-lg-0">
            <div class="table-responsive-sm table-responsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv izdavaca</th>
                            <th scope="col">Tip pisma</th>
                            <th scope="col">Tip poveza</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Izmena</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="edition_table">
                        <?php foreach ($editons as $index => $edition): ?>
                            <tr id="edition_<?= $index ?>">
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $edition->publisherName ?></td>
                                <td><?= $edition->coverType ?></td>
                                <td><?= $edition->letterType ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($edition->created_at)) ?></td>
                                <td><?= $edition->updated_at !== null ? date('d/m/Y H:i:s', strtotime($edition->updated_at)) : '-' ?></td>
                                <td><button class="btn btn-sm btn-success btn-edit btn-edition" data-id="<?= $edition->id ?>"
                                        data-index='<?= $index ?>'>Izmeni</button></td>
                                <td><button type='button' class="btn btn-sm btn-danger btn-delete btn-edition" data-id='<?= $edition->id ?>'
                                        data-index='<?= $index ?>' data-status='<?= $edition->is_deleted ?>'><?= $edition->is_deleted === 0 ? "Izbrisi" : "Aktiviraj" ?></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <form action="#" method="post">
                <input type="hidden" name="edition_id" id="edition_id">
                <input type="hidden" name="edition_index" id="edition_index">
                <input type="hidden" name="book_id" id="book_id" value="<?= $id ?>">
                <div class="mb-2">
                    <label for="cover_type" class="mb-1">Tip poveza</label>
                    <select name="cover_type" id="cover_type" class="form-select mb-1">
                        <option value="0">Izbaerite</option>
                        <?php foreach ($cover_types as $cover): ?>
                            <option value="<?= $cover->id ?>"><?= $cover->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="cover_type_error"></div>
                </div>
                <div class="mb-2">
                    <label for="letter_type" class="mb-1">Tip pisma</label>
                    <select name="letter_type" id="letter_type" class="form-select mb-1">
                        <option value="0">Izaberite</option>
                        <?php foreach ($letter_types as $letter): ?>
                            <option value="<?= $letter->id ?>"><?= $letter->name ?></option>
                        <?php endforeach; ?>
                        
                    </select>
                    <div id="letter_type_error"></div>
                </div>
                <div class="mb-2">
                    <label for="publishers" class="mb-1">Izdavac</label>
                    <select name="publishers" id="publishers" class="form-select mb-1">
                        <option value="0">Izaberite</option>
                        <?php foreach ($publishers as $publisher): ?>
                            <option value="<?= $publisher->id ?>"><?= $publisher->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="publisher_error"></div>
                </div>
                <div class="mb-2">
                    <label for="price" class="mb-1">Cena</label>
                    <input type="number" name="price" id="price" class="form-control mb-1">
                    <div id="price_error"></div>
                </div>
                <div class="mb-2">
                    <label for="genres" class="mb-2">Zanrovi</label>
                    <div class="row">
                        <?php foreach ($authors as $author): ?>
                            <div class="col-6 mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $author->id ?>" id="author_<?= $author->id ?>" name="authors">
                                    <label class="form-check-label" for="author_<?= $author->id ?>">
                                        <?= $author->first_name . ' ' . $author->last_name ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="author_error"></div>
                </div>
                <div class="mb-2">
                    <label for="genres" class="mb-1">Zanrovi</label>
                    <div class="row">
                        <?php foreach($genres as $genre):?>
                        <div class="col-6 mb-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<?=$genre->id?>" id="genre_<?=$genre->id?>" name="genres">
                                <label class="form-check-label" for="genre_<?=$genre->id?>">
                                    <?=$genre->name?>
                                </label>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <div id="genre_error"></div>
                </div>
                <div class="mb-2">
                    <label for="description" class="mb-1">Opis</label>
                    <div id="description" class="mb-1"></div>
                    <div id="description_error"></div>
                </div>
                <div class="mb-2">
                    <label for="cover" class="mb-1">Naslovna slika</label>
                    <input type="file" name="cover" id="cover" class="form-control mb-1">
                    <div id="cover_error"></div>
                    <img src="#" alt="#" class="img-fluid d-none" id="cover_img">
                </div>
                <div class="d-grid gap-1">
                 <button class="btn btn-sm btn-primary btn-save btn-edition" type="button">Save</button>
                    <button class="btn btn-sm btn-danger btn-reset btn-edition" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>