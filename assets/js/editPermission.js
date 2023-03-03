window.onload = (event) => {
  permission("Juanjo");
};
window.onload = (event) => {
  let input = document.getElementById("permission_image");
  let image = document.getElementById("permission-image");
  image.src = input.value;
  input.addEventListener("keyup", function () {
    image.src = input.value;
    checkIfImgExists(image);
    console.log("input: ", input.value);
    console.log("image src: ", image.src);
  });
};

const checkIfImgExists = (image) => {
  const imageNotFound = () => {
    let newImage = document.getElementById("permission-image");
    newImage.src = "https://www.svgrepo.com/show/340721/no-image.svg";
  };

  const img = new Image();
  img.onerror = imageNotFound;
  img.src = image.src;
};

alert('EditPermission')