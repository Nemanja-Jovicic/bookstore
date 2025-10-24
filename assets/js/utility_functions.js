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
      }
    } else {
      responseMessages(urlRequest.response.data.error, "danger");
    }
  } catch (error) {
    responseMessages(error.response.data.error, "danger");
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
