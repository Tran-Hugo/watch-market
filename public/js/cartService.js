var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];
var closeButton = document.getElementById("closeButton");
span.onclick = function () {
  modal.style.display = "none";
};
closeButton.onclick = function () {
  modal.style.display = "none";
};
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

function addCart(idArticle, idUser) {
  let cart = JSON.parse(localStorage.getItem("cart"));
  if (cart) {
    let cartJson = cart;
    if (idUser) {
      cartJson["idUser"] = idUser;
    }
    let articleExist = cartJson["cart"].find((obj) => obj.id === idArticle);
    if (articleExist) {
      articleExist["quantity"]++;
      cartJson = JSON.stringify(cartJson);
      localStorage.setItem("cart", cartJson);
      modal.style.display = "block";
    } else {
      let article = {
        id: idArticle,
        quantity: 1,
      };
      cartJson["cart"].push(article);
      cartJson = JSON.stringify(cartJson);
      localStorage.setItem("cart", cartJson);
      modal.style.display = "block";
    }
  } else {
    let cartJson = {
      idUser: null,
      cart: [],
    };
    if (idUser) {
      cartJson["idUser"] = idUser;
    }
    let article = {
      id: idArticle,
      quantity: 1,
    };
    cartJson["cart"].push(article);
    cartJson = JSON.stringify(cartJson);
    localStorage.setItem("cart", cartJson);
    modal.style.display = "block";
  }
}
