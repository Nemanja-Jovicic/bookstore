const registerFormObj = (obj) => {
  obj["first_name"] = document.querySelector("#first_name").value;
  obj["last_name"] = document.querySelector("#last_name").value;
  obj["email"] = document.querySelector("#email").value;
  obj["password"] = document.querySelector("#password").value;
};

const loginFormObj = (obj) => {
  obj['email'] = document.querySelector("#email").value
  obj['password'] = document.querySelector('#password').value
}

const registerTransformObj = (obj, objData) => {
  removeFromObj(objData)
  objData.append("first_name", obj["first_name"]);
  objData.append("last_name", obj["last_name"]);
  objData.append("email", obj["email"]);
  objData.append("password", obj["password"]);
};

const loginTransformObj = (obj, objData) => {
  removeFromObj(objData)
  objData.append("email", obj['email'])
  objData.append('password', obj['password'])
}


