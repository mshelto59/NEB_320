<!DOCTYPE html>
<html lang="en">
<head>
	<title>NEB e-Commerce</title>
	<link type="text/css" href="../common/login.css" rel="stylesheet" />
    <script src="../common/login.js"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

</head>

<body>
<!-- Start grid-container here -->
<div class="grid-container">
	<!--Header-->
	<div class ="header">
		<h1>Burlington Bikes</h1>
	</div>
 
	<!--Side Navigation-->
	<div class="left">		
		<div class="sidenav"> 
			<a href="../index.php">Home</a>
			<a href="about.htm.php">About</a>
			<a href="payment.htm.php">Payment</a>
			<a href="#">Login</a>
		</div>
	</div>
	
	<div class="middle1" >	
		<div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form action="../php/Cust.php?action=signup" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="fn"/>
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name="ln">
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="cemail"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="cpassword"/>
          </div>
          
          <button type="submit" class="button button-block">Get Started</button>
          
          </form>

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="../php/Cust.php?action=login" method="post">
          
            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="cemail"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="cpassword"/>
          </div>
          
          <p class="forgot"><a href="#">Forgot Password?</a></p>
          
          <button class="button button-block"/>Log In</button>
          </div>
		  
		  </div>
          </form>

	</div>
	
   </div>
</body>


</html>