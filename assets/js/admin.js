const adminObj = {
  objData: {},
  objFormData: new FormData(),
};

const element = document.querySelector("#events");

if (document.contains(element)) {
  element.addEventListener("click", (e) => {
    let element = e.target;
    if (element.matches("button.btn")) {
      let classes = element.classList;
      let entityClass = classes[classes.length - 1].split("-")[1];
      let action = classes[classes.length - 2].split("-")[1];

      let url = `models/${entityClass}/${action}.php`;

      if (element.matches("button.btn.btn-success")) {
        transformEditDeleteIntoObj(element, adminObj);
        sendGetRequest(url, adminObj.objFormData);
      } else if (element.matches("button.btn.btn-danger")) {
        transformEditDeleteIntoObj(element, adminObj);
        sendPostRequest(url, adminObj.objFormData);
      } else if (element.matches("button.btn.btn-primary")) {
        let action_index = document.querySelector(`#${entityClass}_id`).value;

        action = action_index === "" ? "store" : "update";
        url = `models/${entityClass}/${action}.php`;

        transformFormDataForStore(adminObj, entityClass);
        formValidation(entityClass, adminObj.objData).length === 0
          ? sendPostRequest(url, adminObj.objFormData)
          : "";
      } else if (element.matches("button.btn.btn-danger")) {
        // dodaj
      }
    } else if (element.matches("a.page-link")) {
      let classes = element.classList;
      let entityClass = classes[classes.length - 1].split("-")[1];
      filterData(element, entityClass, adminObj);
    }
  });
}
document.contains(document.querySelector("#keyword"))
  ? document.querySelector("#keyword").addEventListener("input", () => {
      const elClasses = document.querySelector("#keyword").classList;
      const entityAction = elClasses[elClasses.length - 2].split("-")[1];
      const entity = elClasses[elClasses.length - 1].split("-")[1];
      let pageLink =
        localStorage.getItem("link") !== null
          ? localStorage.getItem("link")
          : 0;
      localStorage.setItem("key", document.querySelector("#keyword").value);
      filterData(pageLink, entity, adminObj);
    })
  : "";

let page = window.location.href.split("?");

let urlPage = page[1];

if (page.length == 1 || urlPage === "home") {
  clearLocalStorage();
} else if (urlPage === "page=books") {
  connectFilter(adminObj);
} else if (urlPage.includes("page=edition")) {
  console.log(urlPage);
} else {
  clearLocalStorage();
}
