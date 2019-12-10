<?php include("header1.inc");?>
<link type="text/css" href="../common/styles.css" rel="stylesheet" />
		<script type="text/javascript" src="./common/cart.js" async></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

<?php include("body1.inc");?>
	<div class="right" >
			<p> Burlington Bikes has been a staple in the Vermont cycling community for over 60 years.
				Our dedication to exceptional customer service and quality bike repairs has landed us a place as one of the 
				Top 100 Bike Dealers in America.The Burlington Bikes family is as diverse as our customers, but we all love having 
				fun on our bikes. Our goal is to make cycling a great experience for you. We do that by helping you get equipped 
				with the right bike and accessories for your needs, and by repairing your bike right the first time so you can 
				spend more time riding.</p>
				
			<h2 class="section-header">CART</h2>
            <div class="cart-row">
                <span class="cart-item cart-header cart-column">ITEM</span>
                <span class="cart-price cart-header cart-column">PRICE</span>
                <span class="cart-quantity cart-header cart-column">QUANTITY</span>
            </div>
            <div class="cart-items">
			</div>
            <div class="cart-total">
                <strong class="cart-total-title">Total</strong>
                <span class="cart-total-price" id="cart-total-price">$0</span>
            </div>
            <button class="btn btn-primary btn-purchase" type="button">CHECKOUT</button>
	</div>
<?php include("footer1.inc");?>