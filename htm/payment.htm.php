<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>NEB e-Commerce</title>
	<link type="text/css" href="../common/styles.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../common/payment.js"></script>
	<script type="text/javascript" src="../common/payment_form_val.js"></script>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
</head>
<body>
	<div class="grid-container">
		<div class ="header">
			<h1>Burlington Bikes</h1>
		</div>
	 
		<!--Side Navigation-->
		<div class="left">		
			<div class="sidenav"> 
				<a href="../index.php">Home</a>
				<a href="./cart.htm.php">Cart</a>
				<a href="#">Payment</a>
				<a href="./login.htm.php">Login</a>
			</div>
		</div>
		<?php
        if(isset($_SESSION['username'])){
        echo('
		<div class="middle1" style="background-color:#ffffff;">
			<table id="main_tbl">
				<tr>
					<td id="title" colspan="3" class="row_ht">
						Payment Information
					</td>
				</tr>
				
				<tr>
					<td>
						<form name="payment" action="../php/payment.php" method="post"><!-- I NEED SOMEONE TO CHANGE THIS SO THAT THE FORM CAN COMMUNICATE WITH THE DATA BASE-->
							<table id="nested_form">
								<!--start actual form structure here-->
								<tr>
									<td>First Name on Card:</td>
									<td>
										<input name="fnp" />
									</td>
								</tr>
								
								<tr>
									<td>Last Name on Card:</td>
									<td>
										<input name="lnp"/>
									</td>
								</tr>
								
								<tr>
									<td>Street Address:</td>
									<td>
										<input name="sap"/>
									</td>
								</tr>
								
								<tr>
									<td>City:</td>
									<td>
										<input name="cityp"/>
									</td>
								</tr>
								
								<tr>
									<td>New England-based state:</td>
									<td>
										<select name="statep"><!--selection list-->
											<option value="">Choose One</option>
											<option value="CT">Ct</option>
											<option value="ME">Me</option>
											<option value="MA">Ma</option>
											<option value="NH">Nh</option>
											<option value="RI">Ri</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<td>Area Code:</td>
									<td>
										<input name="Acp" size="9" maxlength="9" />
									</td>
								</tr>
								
								<tr>
									<td>Home Phone:</td>
									<td>
										<input name="hpp" size="10" maxlength="10" />
									</td>
								</tr>
								
								<tr>
									<td>Work Phone:</td>
									<td>
										<input name="wpp" size="10" maxlength="10" />
									</td>
								</tr>
								
								<tr>
									<td>Card Number:</td>
									<td>
										<input name="cn" size="16" maxlength="16" />
									</td>
								</tr>
								
								<tr>
									<td>Experation date:</td>
									<td>Month:
										<select name="espMon"><!--selection list-->
											<option value="">Choose One</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">4</option>
											<option value="4">5</option>
											<option value="5">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
										</select>
										Year:
										<select name="espYear"><!--selection list-->
											<option value="">Choose One</option>
											<option value="19">2019</option>
											<option value="20">2020</option>
											<option value="21">2021</option>
											<option value="22">2022</option>
											<option value="23">2023</option>
											<option value="24">2024</option>
											<option value="25">2025</option>
											<option value="26">2026</option>
											<option value="27">2027</option>
											<option value="28">2028</option>
											<option value="29">2029</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<td>CVV:</td>
									<td>
										<input name="cvv" size="3" maxlength="3" />
									</td>
								</tr>
								
								<tr>
									<td><h2>Mailing Information:</h2></td>
								</tr>
								
								<tr>
									<td>First Name:</td>
									<td>
										<input name="fnm" />
									</td>
								</tr>
								
								<tr>
									<td>Last Name:</td>
									<td>
										<input name="lnm"/>
									</td>
								</tr>
								
								<tr>
									<td>Street Address:</td>
									<td>
										<input name="sam"/>
									</td>
								</tr>
								
								<tr>
									<td>City:</td>
									<td>
										<input name="citym"/>
									</td>
								</tr>
								
								<tr>
									<td>New England-based state:</td>
									<td>
										<select name="statem"><!--selection list-->
											<option value="">Choose One</option>
											<option value="CT">Ct</option>
											<option value="ME">Me</option>
											<option value="MA">Ma</option>
											<option value="NH">Nh</option>
											<option value="RI">Ri</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<td>Area Code:</td>
									<td>
										<input name="Acm" size="9" maxlength="9" />
									</td>
								</tr>
								
								<tr>
									<td>Home Phone:</td>
									<td>
										<input name="hpm" size="10" maxlength="10" />
									</td>
								</tr>
								
								<tr>
									<td>Work Phone:</td>
									<td>
										<input name="wpm" size="10" maxlength="10" />
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<input type="submit" name="s" value="Send Data" onsubmit="val_data()"/>
										<input type="reset" name="r" value="Clear Form"/>
									</td>
								</tr>
									
							</table>
						</form>
					</td><!--end nested form here-->
				</tr>
			</table>
		</div>	
		');
        }
        else{
            echo('
            <div class="middle1" style="background-color:#ffffff;">
                <table id="main_tbl">
                    <tr>
                        <td id="title" colspan="3" class="row_ht">
                            Please log in first.
                            </br>
                            <button type="button" onclick="window.location.href=`login.htm.php`">Login</button>
                            
                        </td>
                    </tr>
                </table>
            </div>');
        }
        ?>
		<div class="right" style="background-color:#ccc;">

		</div>
  
		<div class="footer">
			<p style ="color:#000;">&copy; 2019 Burlington Bikes<p>
		</div>
	</div>
	<!-- End grid-container -->
	
	
	
	
	
</div>

</body>


</html>