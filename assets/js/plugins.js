document.contains(document.querySelector("#description"))
  ? (window.quill = new Quill(document.querySelector("#description"), {
      theme: "snow",
    }))
  : "";
