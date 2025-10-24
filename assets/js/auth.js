const btnRegister = document.querySelector("#btnRegister");
const btnLogin = document.querySelector("#btnLogin");

const authObjForm = {
  objData: {},
  formObjData: new FormData(),
};

document.contains(btnRegister)
  ? btnRegister.addEventListener("click", () => {
      repackData(authObjForm, "register");
      authRegisterFormValidation(authObjForm.objData).length === 0
        ? sendPostRequest("models/auth/register.php", authObjForm.formObjData)
        : "";
    })
  : "";

document.contains(btnLogin)
  ? btnLogin.addEventListener("click", () => {
      repackData(authObjForm, "login");
      authLoginFormValidation(authObjForm.objData).length === 0
        ? sendPostRequest("models/auth/login.php", authObjForm.formObjData)
        : "";
    })
  : "";
