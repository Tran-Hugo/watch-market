
function addCart(idArticle, idUser){
    let cart = JSON.parse(localStorage.getItem('cart'));
    if(cart){
       let cartJson = cart;
       if(idUser){
        cartJson['idUser']=idUser;
       };
       let articleExist = cartJson['cart'].find(obj=>obj.id === idArticle);
       if(articleExist){
        articleExist['quantity']++
        cartJson=JSON.stringify(cartJson);
        localStorage.setItem('cart',cartJson);
       } else {
        let article = {
            id:idArticle,
            quantity:1
        };
        cartJson['cart'].push(article);
        cartJson=JSON.stringify(cartJson);
        localStorage.setItem('cart',cartJson);
       }
    } else {
        let cartJson={
            idUser:null,
            cart:[]
        };
        if(idUser){
            cartJson['idUser']=idUser;
        };
        let article = {
            id:idArticle,
            quantity:1
        }
        cartJson["cart"].push(article);
        cartJson=JSON.stringify(cartJson);
        localStorage.setItem('cart',cartJson);
    }
}
