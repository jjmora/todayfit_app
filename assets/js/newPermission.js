window.onload = (event) => {
  let input = document.getElementById('permission_image')
  let image = document.getElementById('permission-new-image')
  input.addEventListener("keyup", function(){
    image.src = input.value
    checkIfImgExists(image)
  })
}

const checkIfImgExists = (image) => {
  const imageNotFound = () => {
    let newImage = document.getElementById('permission-new-image')
    // Image by default
    newImage.src = "https://www.svgrepo.com/show/340721/no-image.svg"
  };

  const img = new Image()
  img.onerror = imageNotFound;
  img.src = image.src;
}