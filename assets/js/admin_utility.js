// edit or delete functions

const transformEditDeleteIntoObj = (element, obj) => {
  const { objData, objFormData } = obj;
  objData["id"] = element.dataset.id;
  objData["index"] = element.dataset.index;
  element.hasAttribute("data-status")
    ? (objData["status"] = element.dataset.status)
    : "";

  removeFromObj(objFormData);

  objFormData.append("id", element.dataset.id);
  objFormData.append("index", element.dataset.index);
  element.hasAttribute("data-status")
    ? objFormData.append("status", element.dataset.status)
    : "";
};
const printAfterSoftDelete = (entity, arrayOfData) => {
  arrayOfData.forEach((data) => {
    let index = parseInt(data.id) - 1;
    let element = document.querySelector(`#${entity}_${index}`);
    let button = element.querySelector("td:last-of-type button");
    button.dataset.status = data.is_deleted;
    parseInt(data.is_deleted) === 0
      ? (button.textContent = "Izbrisi")
      : (button.textContent = "Aktiviraj");
  });
};

// fill form functions

const fillForm = (data, entity) => {
  switch (entity) {
    case "author":
      authorFillForm(data);
      break;
    case "publisher":
      publisherFillForm(data);
      break;
    case "book":
      bookFillForm(data);
      break;
    case "edition":
      editionFillForm(data);
      break;
  }
};
const authorFillForm = (data) => {
  const { id, first_name, last_name } = data;
  document.querySelector("#author_index").value = parseInt(id) - 1;
  document.querySelector("#author_id").value = id;
  document.querySelector("#first_name").value = first_name;
  document.querySelector("#last_name").value = last_name;
};
const publisherFillForm = (data) => {
  const { id, name } = data;
  document.querySelector("#publisher_id").value = id;
  document.querySelector("#name").value = name;
  document.querySelector("#publisher_index").value = parseInt(id) - 1;
};
const bookFillForm = (data) => {
  const { id, name } = data;
  document.querySelector("#book_id").value = id;
  document.querySelector("#book_index").value = parseInt(id) - 1;
  document.querySelector("#name").value = name;
};
const editionFillForm = (data) => {
  const {
    id,
    book_id,
    cover_type_id,
    publisher_id,
    type_id,
    image_path,
    price,
    description,
    authors,
    genres,
  } = data;

  document.querySelector("#edition_id").value = id;
  document.querySelector("#edition_index").value = parseInt(id) - 1;
  document.querySelector("#cover_type").value = cover_type_id;
  document.querySelector("#letter_type").value = type_id;
  document.querySelector("#publishers").value = publisher_id;
  document.querySelector("#price").value = price;

  window.quill.setContents(JSON.parse(description));
  let authorFront = document.querySelectorAll('input[name="authors"]');
  let genreFront = document.querySelectorAll('input[name="genres"]');

  authorFront.forEach((author) => {
    author.checked = false;
    const id = parseInt(author.value);
    authors.includes(id) ? (author.checked = true) : "";
  });

  genreFront.forEach((genre) => {
    genre.checked = false;
    const id = parseInt(genre.value);
    genres.includes(id) ? (genre.checked = true) : "";
  });

  let image = document.querySelector("#cover_img");
  image.classList.remove("d-none");
  image.src = `assets/images/normal/${image_path}`;
};
// clear functions

const clearForm = (entity) => {
  switch (entity) {
    case "author":
      authorClearForm();
      break;
    case "publisher":
      publisherClearForm();
      break;
    case "book":
      bookClearForm();
      break;
    case "edition":
      editionClearForm();
      break;
  }
};
const authorClearForm = () => {
  document.querySelector("#author_id").value = "";
  document.querySelector("#author_index").value = "";
  document.querySelector("#first_name").value = "";
  document.querySelector("#last_name").value = "";
};
const publisherClearForm = () => {
  document.querySelector("#publisher_id").value = "";
  document.querySelector("#publisher_index").value = "";
  document.querySelector("#name").value = "";
};
const bookClearForm = () => {
  document.querySelector("#book_id").value = "";
  document.querySelector("#book_index").value = "";
  document.querySelector("#name").value = "";
};
const editionClearForm = () => {
  document.querySelector("#edition_id").value = "";
  document.querySelector("#edition_index").value = "";
  document.querySelector("#cover_type").value = 0;
  document.querySelector("#letter_type").value = 0;
  document.querySelector("#publishers").value = 0;
  document.querySelector("#price").value = "";
  window.quill.setContents([]);
  document.querySelector("#cover").value = "";

  let authors = document.querySelectorAll('input[name="authors"]');
  let genres = document.querySelectorAll('input[name="genres"]');

  authors.forEach((author) => (author.checked = false));
  genres.forEach((genre) => (genre.checked = false));

  let cover = document.querySelector("#cover_img");
  cover.src = "#";
  cover.classList.add("d-none");
};

// store or update functions

const transformFormDataForStore = (obj, entity) => {
  const { objData, objFormData } = obj;
  switch (entity) {
    case "author":
      authorObj(objData);
      authorTransformDataIntoFormData(objData, objFormData);
      break;
    case "publisher":
      publisherObj(objData);
      publisherTransformDataIntoFormData(objData, objFormData);
      break;
    case "book":
      bookObj(objData);
      bookTransformDataIntoFormData(objData, objFormData);
      break;
    case "edition":
      editionObj(objData);
      editionTransformDataIntoFormData(objData, objFormData);
  }
};

// repack functions

const authorObj = (objData) => {
  let author_id = document.querySelector("#author_id").value;
  if (author_id === "") {
    objData["id"] = author_id;
  }
  objData["first_name"] = document.querySelector("#first_name").value;
  objData["last_name"] = document.querySelector("#last_name").value;
};
const authorTransformDataIntoFormData = (objData, objFormData) => {
  removeFromObj(objFormData);
  objData.hasOwnProperty("id") ? objFormData.append("id", objData["id"]) : "";
  objFormData.append("first_name", objData["first_name"]);
  objFormData.append("last_name", objData["last_name"]);

  document.contains(document.querySelector(".page-link.active"))
    ? objFormData.append(
        "link",
        document.querySelector(".page-link.active").dataset.link
      )
    : "";
};

const publisherObj = (objData) => {
  const publisher_id = document.querySelector("#publisher_id").value;
  if (publisher_id !== "") {
    objData["id"] = publisher_id;
  }
  objData["name"] = document.querySelector("#name").value;
};
const publisherTransformDataIntoFormData = (objData, objFormData) => {
  removeFromObj(objFormData);
  objData.hasOwnProperty("id") ? objFormData.append("id", objData["id"]) : "";
  objFormData.append("name", objData["name"]);

  document.contains(document.querySelector(".page-link.active"))
    ? objFormData.append(
        "link",
        document.querySelector(".page-link.active").dataset.link
      )
    : "";
};

const bookObj = (objData) => {
  const book_id = document.querySelector("#book_id").value;
  book_id !== "" ? objData["id"] : "";
  objData["name"] = document.querySelector("#name").value;
};
const bookTransformDataIntoFormData = (objData, objFormData) => {
  removeFromObj(objFormData);
  objData.hasOwnProperty("id") ? objFormData.append("id", objData["id"]) : "";
  objFormData.append("name", objData["name"]);

  document.contains(document.querySelector(".page-link.active"))
    ? objFormData.append(
        "link",
        document.querySelector(".page-link.active").dataset.link
      )
    : "";
};

const editionObj = (objData) => {
  const editionId = document.querySelector("#edition_id").value;
  editionId !== "" ? (objData["id"] = editionId) : "";

  objData["book_id"] = document.querySelector("#book_id").value;
  objData["cover_type"] = document.querySelector("#cover_type").value;
  objData["letter_type"] = document.querySelector("#letter_type").value;
  objData["pubilsher"] = document.querySelector("#publishers").value;
  objData["price"] = document.querySelector("#price").value;

  const genres = document.querySelectorAll('input[name="genres"]:checked');

  const authors = document.querySelectorAll('input[name="authors"]:checked');

  const selectedAuthors = [];
  const selectedGenres = [];

  genres.forEach((genre) => {
    selectedGenres.push(genre.value);
  });
  authors.forEach((author) => {
    selectedAuthors.push(author.value);
  });

  objData["authors"] = selectedAuthors;
  objData["genres"] = selectedGenres;

  if (editionId == "") {
    objData["img_cover"] = document.querySelector("#cover").files;
  } else {
    objData["img_cover"] =
      document.querySelector("#cover").files.length > 0
        ? document.querySelector("#cover").files
        : "";
  }

  const quillContext = window.quill.getContents();
  const filteredText = quillContext.map((word) => word.insert).join("");
  objData["description"] = JSON.stringify(quillContext);
  objData["validation_description"] = filteredText.trim();
  if (editionId !== "") {
    const cover = document.querySelector("#cover_img").src;
    const splitedCover = cover.split("/");
    objData["cover_img"] = splitedCover[splitedCover.length - 1];
  }
};
const editionTransformDataIntoFormData = (objData, objFormData) => {
  removeFromObj(objFormData);
  objData.hasOwnProperty("id") ? objFormData.append("id", objData["id"]) : "";
  objFormData.append("book_id", objData["book_id"]);
  objFormData.append("pubilsher", objData["pubilsher"]);
  objFormData.append("cover_type", objData["cover_type"]);
  objFormData.append("letter_type", objData["letter_type"]);
  objFormData.append("price", objData["price"]);
  objFormData.append("genres", objData["genres"]);
  objFormData.append("authors", objData["authors"]);
  objFormData.append(
    "validation_description",
    objData["validation_description"]
  );
  objFormData.append("description", objData["description"]);
  objData.hasOwnProperty("img_cover")
    ? objFormData.append("image", objData["img_cover"][0])
    : "";
  objData.hasOwnProperty("id")
    ? objFormData.append("cover", objData["cover_img"])
    : "";
};

// print functions
const printAllData = (arrayOfData, entity, pageIndex = 0) => {
  let content = "",
    index = pageIndex * 5;
  if (arrayOfData.length > 0) {
    arrayOfData.forEach((data) => {
      content += printData(data, index, entity);
      index++;
    });
  } else {
    content += `<tr><th colspan='7'>Trennutno nemamo ni jednu knjigu koja zadovljava vas krieterijum</th></tr>`;
  }
  document.querySelector(`#${entity}_table`).innerHTML = content;
};
const printData = (data, index, entity, action = "") => {
  let content = `
    <tr id='${entity}_${index}'>
        <th scope='col'>${index + 1}</th>`;
  // autora
  if (entity === "author") {
    content += `<td>${data.first_name} ${data.last_name}</td>`;
  } else if (entity === "edition") {
    content += `
      <td>${data.publisherName}</td>
      <td>${data.coverType}</td>
      <td>${data.letterType}</td>
    `;
  } else {
    content += `<td>${data.name}</td>`;
  }
  content += `<td>${formatDate(data.created_at)}</td>
        <td>${
          data.updated_at !== null ? formatDate(data.updated_at) : "-"
        }</td>`;
  if (entity === "book") {
    content += `<td><a href='admin.php?page=edition&id=${data.id}' class="btn btn-sm btn-primary">Dodaj</a></td>`;
  }
  content += `<td><button type='button' class='btn btn-sm btn-success btn-edit btn-${entity}' data-id='${
    data.id
  }' data-index='${index}'>Izmeni</button></td>
        <td><button type='button' class='btn btn-sm btn-danger btn-edit btn-${entity}'
            data-id='${data.id}' data-status ='${
    data.is_deleted
  }' data-index='${index}'
        >${
          parseInt(data.is_deleted) === 0 ? "Izbrisi" : "Aktiviraj"
        }</button></td>
    </tr>
  `;
  if (action === "") {
    return content;
  } else {
    document.querySelector(`#${entity}_${index}`).innerHTML = content;
  }
};

// filter data

const filterData = (pageLink = 0, entity, obj) => {
  const { objData, objFormData } = obj;
  removeFromObj(objFormData);
  if (entity === "book") {
    let key = document.querySelector("#keyword").value;
    let pageL = document.querySelector(".page-link.active");
    if (document.contains(pageL)) {
      link = pageL.dataset.link;
    } else {
      link = 0;
    }
    localStorage.setItem("link", link);

    objFormData.append("link", link);
    objFormData.append("key", key);
  } else {
    localStorage.setItem("link", pageLink.dataset.link);
    objFormData.append("link", pageLink.dataset.link);
  }
  let url = `models/${entity}/filter.php`;
  sendGetRequest(url, objFormData);
};

const connectFilter = (adminObj) => {
  if (localStorage.getItem("key") !== null) {
    console.log(document.querySelector("#keyword"));
    document.querySelector("#keyword").value = localStorage.getItem("key");
  }
  if (localStorage.getItem("link")) {
    let links = document.querySelectorAll(".page-item");
    links.forEach((link) => link.classList.remove(".active"));
    let link =
      localStorage.getItem("link") !== null ? localStorage.getItem("link") : 0;
    links[link].classList.add("active");
  }
  filterData(localStorage.getItem("link"), "book", adminObj);
};

const clearLocalStorage = () => {
  localStorage.getItem("key") !== null ? localStorage.removeItem("key") : "";
  localStorage.getItem("link") !== null ? localStorage.removeItem("link") : "";
};
