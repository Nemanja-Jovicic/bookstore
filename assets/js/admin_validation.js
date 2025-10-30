const formValidation = (entity, dataObj) => {
  let errors = [];
  switch (entity) {
    case "author":
      authorFormValidation(dataObj, errors);
      break;
    case "publisher":
      publisherFormValidation(dataObj, errors);
      break;
    case "book":
      bookFormValidation(dataObj, errors);
      break;
    case "edition":
      editionFormValidation(dataObj, errors);
      break;
  }
  return errors;
};
const authorFormValidation = (data, errors) => {
  const { first_name, last_name } = data;

  const regFirstLastName = /\b([A-ZÀ-ÿČĆŽŠĐ][-,a-zčćžšđ. ']+[ ]*)+/;
  inputFieldValidation(
    first_name,
    regFirstLastName,
    "first_name_error",
    "Ime nije u redu!",
    errors
  );
  inputFieldValidation(
    last_name,
    regFirstLastName,
    "last_name_error",
    "Prezime nije u redu",
    errors
  );

  return errors;
};
const publisherFormValidation = (data, errors) => {
  const { name } = data;
  const reName = /^[A-Z][a-z]{1,}(\s[A-Z][a-z]{1,}|\s[a-z]{1,})*$/;
  inputFieldValidation(
    name,
    reName,
    "name_error",
    "Naziv izdavaca nije u redu!",
    errors
  );
  return errors;
};
const bookFormValidation = (data, errors) => {
  const { name } = data;
  const regBookName = /^[A-ZČĆŠĐŽa-zčćšđž0-9 ,.'":;!?()-]+$/;
  inputFieldValidation(
    name,
    regBookName,
    "name_error",
    "Naziv knjige nije u redu!",
    errors
  );
  return errors;
};
const editionFormValidation = (data, errors) => {
  const {id, cover_type, letter_type, pubilsher, price, authors, genres, img_cover, description, validation_description} = data

  const regPrice = /^[1-9]{1}[\d]{2,5}$/
  const regDescription = /^[\p{L}\p{N}\s.,!?()'"-:]{10,2000}$/u

  selectFieldValidation(cover_type, "cover_type_error", "Morate odabrati tip korica!", errors)
  selectFieldValidation(letter_type, "letter_type_error", "Morate odabrati pismo!", errors)
  selectFieldValidation(pubilsher, "publisher_error", "Morate izabrati izdavaca!", errors)

  checkBoxFieldValidation(authors, "author_error", "Morate izabrati autora!", errors)
  checkBoxFieldValidation(genres, "genre_error", "Morate izabrati zanr!", errors)

  inputFieldValidation(price, regPrice, "price_error", "Cena nije u redu!", errors)
  inputFieldValidation(validation_description, regDescription, "description_error", "Opis nije u redu!", errors)

  if(id === undefined){
    inputFileFieldValidation(img_cover, "cover_error", ["Morate odabrati fajl!","Format fajla nije u redu!","Velicina fajla nije u redu"], errors)
  }
  else if(img_cover !== ''){
    inputFileFieldValidation(img_cover, "cover_error", ["Morate odabrati fajl!","Format fajla nije u redu!","Velicina fajla nije u redu"], errors)
  }

  return errors;
};
