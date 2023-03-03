window.onload = () => {
  let inputField = document.querySelector("#search_user_bar_input_data");
  const currentUrl = window.location.href;
  const baseUrl = currentUrl.slice(0, currentUrl.length - 12);
  const userwrapper = document.querySelector("#userwrapper");
  const userQty = document.querySelector("#user-qty");

  inputField.addEventListener("keyup", function () {
    userwrapper.innerHTML = "Loading";
    userQty.innerHTML = "";
    console.log(userwrapper);
    let fullUrl;
    if (inputField.value.length > 2) {
      fullUrl = baseUrl + "/search/user/" + this.value;
    } else {
      fullUrl = baseUrl + "/search/user/all";
    }

    let form = this.closest("form");
    let indexData = this.value; // =>return the id
    console.log(this.value); // the user input on the input form. Ex = idf
    let data = this.name + "=" + this.value;
    console.log(data);
    console.log(form.getAttribute("method"));
    fetch(fullUrl, {
      method: form.getAttribute("method"),
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset:utf-8",
      },
    })
      .then((response) => response.text())
      .then((html) => {
        let content = document.createElement("html");
        content.innerHTML = JSON.parse(html);
        let nouveauSelect = content.querySelector("#userwrapper");
        document.querySelector("#userwrapper").replaceWith(nouveauSelect);
      });
  });
};