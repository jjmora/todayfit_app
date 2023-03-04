require('bootstrap')

window.onload = () => {
  let franchise = document.querySelector("#partner_franchise");
  franchise.addEventListener("change", function(){
    let form = this.closest("form");
    let indexData = this.value; 
    let data = this.name + "=" + this.value;

    fetch(form.action, { 
      method: form.getAttribute("method"), // => post
      body: data, // => partner[franchise]=50
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset:utf-8"
      }
    })
    .then(response => response.text())
    .then(html => {
      console.log(html)
      let content = document.createElement("html");
      content.innerHTML = html;
      let nouveauSelect = content.querySelector("#partner_permissions");
      document.querySelector("#partner_permissions").replaceWith(nouveauSelect);
    })
    .catch(error => {
      console.log(error)
    })
  })
}