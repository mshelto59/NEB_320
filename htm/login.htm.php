<?php include("header1.inc");?>
	<link type="text/css" href="../common/login.css" rel="stylesheet" />
    <script src="../common/login.js"></script>
	
<?php include("body1.inc");?>
	<div class="middle1" >	
		<div class="form">      
			<div class="tab-content">
				<div id="signup">   
					<h1>Sign Up for Free</h1>
					<!--Sign up form-->
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
					</div>
					<button type="submit" class="button button-block">Get Started</button>
          
					</form>

			</div>
        <!--End of signup-->
				<div id="login">   
					<h1>Welcome Back!</h1>   
					<!--Login form-->			
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
					</form>
				</div>
		<!--End of login-->
					 
		</div>
         
		</div>
	</div>
	
	<div class="right" >
	</div>
	
<?php include("footer1.inc");?>