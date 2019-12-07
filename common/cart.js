if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}

function createCart(){
    try{
        var cart = JSON.parse(document.cookie.replace(/(?:(?:^|.*;\s*)cart\s*\=\s*([^;]*).*$)|^.*$/, "$1"));
        
        var cartLen = cart.length;
        
        document.cookie = "cartLen=" + cartLen;
        
        var cartItems = document.getElementsByClassName('cart-items')[0];

        for (i=0; i<cartLen; i++){
            var output = `
                <div class="cart-row">
                    <div class="cart-item cart-column">
                        <img class="cart-item-image" src="` + cart[i][3] + `" width="100" height="100">
                        <span class="cart-item-title">` + cart[i][0] + `</span>
                    </div>
                    <span class="cart-price cart-column">` + cart[i][1]+`</span>
                    <div class="cart-quantity cart-column">
                        <input class="cart-quantity-input" type="number" value="` + parseInt(cart[i][2]) + `">
                        <button class="btn btn-danger" type="button">REMOVE</button>
                    </div>
                </div>`;

            cartItems.innerHTML += output;

        }
    }
    catch(error){
   
    }
   
}

function ready() {
    createCart();
    var removeCartItemButtons = document.getElementsByClassName('btn-danger')
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i]
        button.addEventListener('click', removeCartItem)
    }

    var quantityInputs = document.getElementsByClassName('cart-quantity-input')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)
    }
 //Get Add to Cart Btns
    var addToCartButtons = document.getElementsByClassName('shop-item-button')
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i]
        button.addEventListener('click', addToCartClicked)
    }

    document.getElementsByClassName('btn-purchase')[0].addEventListener('click', purchaseClicked)
    
    
    updateCartTotal();
}

function purchaseClicked() {
    window.location.href = "htm/payment.htm.php"
    var cartItems = document.getElementsByClassName('cart-items')[0]
    while (cartItems.hasChildNodes()) {
        cartItems.removeChild(cartItems.firstChild)
    }
    updateCartTotal()
}

function removeCartItem(event) {
    var buttonClicked = event.target
    buttonClicked.parentElement.parentElement.remove()
    
    updateCartCookies();    
    updateCartTotal()
}

function quantityChanged(event) {
    var input = event.target
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1
    }
    updateCartTotal()
}

function addToCartClicked(event) {
    var button = event.target
    var shopItem = button.parentElement.parentElement
    var title = shopItem.getElementsByClassName('shop-item-title')[0].innerText
    var price = shopItem.getElementsByClassName('shop-item-price')[0].innerText
    var imageSrc = shopItem.getElementsByClassName('shop-item-image')[0].src
    addItemToCart(title, price, imageSrc)
    updateCartTotal()
    updateCartCookies();
}

function addItemToCart(title, price, imageSrc) {
    var cartRow = document.createElement('div')
    cartRow.classList.add('cart-row')
    var cartItems = document.getElementsByClassName('cart-items')[0]
    var cartItemNames = cartItems.getElementsByClassName('cart-item-title')
    for (var i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].innerText == title) {
            alert('This item is already added to the cart')
            return;
        }
    }
    var cartRowContents = `
        <div class="cart-item cart-column">
            <img class="cart-item-image" src="${imageSrc}" width="100" height="100">
            <span class="cart-item-title">${title}</span>
        </div>
        <span class="cart-price cart-column">${price}</span>
        <div class="cart-quantity cart-column">
            <input class="cart-quantity-input" type="number" value="1">
            <button class="btn btn-danger" type="button">REMOVE</button>
        </div>`
    cartRow.innerHTML = cartRowContents
    cartItems.append(cartRow)
    cartRow.getElementsByClassName('btn-danger')[0].addEventListener('click', removeCartItem)
    cartRow.getElementsByClassName('cart-quantity-input')[0].addEventListener('change', quantityChanged)
    
}

function updateCartTotal() {
    var cartItemContainer = document.getElementsByClassName('cart-items')[0]
    var cartRows = cartItemContainer.getElementsByClassName('cart-row')
    var total = 0
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i]
        var priceElement = cartRow.getElementsByClassName('cart-price')[0]
        var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]
        var price = parseFloat(priceElement.innerText.replace('$', ''))
        var quantity = quantityElement.value
        total = total + (price * quantity)
    }
    total = Math.round(total * 100) / 100
    document.getElementsByClassName('cart-total-price')[0].innerText = '$' + total
    var cartTotal = document.getElementById('cart-total-price');
    document.cookie = "cartTotal=" + cartTotal.innerHTML;
}

function updateCartCookies(){
    var cartItems = document.getElementsByClassName('cart-item-title');
    var cartPrices = document.getElementsByClassName('cart-price');
    var cartQuantities = document.getElementsByClassName('cart-quantity-input');
    var cartImages = document.getElementsByClassName('cart-item-image');
    var cookie = new Array();
    var cookieString = "";
    for (i=0; i<cartItems.length; i++){
        var builder = new Array();
        
        builder.push(cartItems[i].innerHTML);
        builder.push(cartPrices[i+1].innerHTML);
        builder.push(cartQuantities[i].value);
        builder.push(cartImages[i].src.toString());
        cookie.push(builder);
    }
    cookieString = "cart=" + JSON.stringify(cookie);
    document.cookie = cookieString;   
}