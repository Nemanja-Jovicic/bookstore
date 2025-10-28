// utility validation functions

const utilityClasses = ["text-danger"];

const createValidationErrorMessage = (elementId, errorMessage) => {
  const element = document.querySelector(`#${elementId}`);
  element.classList.add(...utilityClasses);
  element.textContent = errorMessage;
};

const removeValidationErrorMessage = (elementId) => {
  const element = document.querySelector(`#${elementId}`);
  element.classList.remove(...utilityClasses);
  element.textContent = "";
};

// repack data

const repackData = (obj, entity) => {
  const { objData, formObjData } = obj;
  switch (entity) {
    case "register":
      registerFormObj(objData);
      registerTransformObj(objData, formObjData);
      break;
    case "login":
      loginFormObj(objData);
      loginTransformObj(objData, formObjData);
  }
};

// requests
const sendPostRequest = async (url, data) => {
  const urlSplit = url.split("/");
  const directory = urlSplit[urlSplit.length - 2];
  const file = urlSplit[urlSplit.length - 1].split(".")[0];

  try {
    const urlRequest = await axios.post(url, data);
    if (urlRequest.status >= 200 || urlRequest.status <= 300) {
      const responseData = await urlRequest.data?.data;
      if (directory === "auth") {
        if (file === "register") {
          window.location.href = "index.php?page=login";
        } else {
          parseInt(responseData.role_id) === 1
            ? (window.location.href = "admin.php")
            : (window.location.href = "index.php");
        }
      } else {
        if (file === "delete") {
          printAfterSoftDelete(directory, responseData);
        } else if (file === "store") {
          clearForm(directory);
          responseMessages(urlRequest.data.message, "success");
          printAllData(responseData.data, directory, responseData.link);
          if(directory !== 'edition'){
            printPagination(responseData.pages, directory, responseData.link)
          }
        } else if (file === "update") {
          clearForm(directory);
          printData(
            responseData,
            parseInt(responseData.id) - 1,
            directory,
            "update"
          );
        }
      }
    } else {
      responseMessages(urlRequest.response.data.error, "danger");
    }
  } catch (error) {
    responseMessages(error.response?.data.error, "danger");
  }
};
const sendGetRequest = async (url, data = "") => {
  const splitedUrl = url.split("/");
  const entity = splitedUrl[splitedUrl.length - 2];
  const action = splitedUrl[splitedUrl.length - 1].split(".")[0];

  const urlParams = new URLSearchParams(data).toString();
  try {
    const request = await axios.get(`${url}?${urlParams}`);
    const responseData = await request.data;
    if (request.status >= 200 && request.status <= 300) {
      if (action === "edit") {
        fillForm(responseData.data, entity);
      } else if (action === "filter") {
    
        printAllData(responseData.data.data, entity, responseData.data.link);
        printPagination(responseData.data.pages, entity, responseData.data.link)
      }
    } else {
      responseMessages(request.response.data.error, "danger");
    }
  } catch (error) {
    responseMessages(error.response?.data.error, "danger");
  }
};

// utility functions
const responseMessages = (message, color) => {
  const messageEl = `
    <div class="alert alert-${color} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;
  const element = document.querySelector("#message");
  element.innerHTML = messageEl;
};
const removeFromObj = (obj) => {
  for (const key of Array.from(obj.keys())) {
    obj.delete(key);
  }
};
const formatDate = (dateTime) => {
  const splitedTimeDate = dateTime.split(" ");
  const time = splitedTimeDate[1] !== undefined ? splitedTimeDate[1] : "";
  const date = splitedTimeDate[0].split("-");
  return `${date[2]}/${date[1]}/${date[0]} ${time}`;
}
const printPagination = (page, entity, activePage = 0) => {
  let content = "";

  content += `<ul class='pagination'>`;
  for (let i = 0; i < page; i++) {
    content += `<li class="page-item "><a class="page-link  ${parseInt(activePage) === i ? 'active' : ''} page-${entity}"`; 
    content += `"href="#" data-link="${i}">${i + 1}</a></li>`;
  }
  content += "</ul>";
  document.querySelector(`#${entity}_pagination`).innerHTML = content;
};
