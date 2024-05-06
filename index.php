<?PHP
session_start();
?>
<?PHP
include("database.php");

$act 		= (isset($_POST['act'])) ? trim($_POST['act']) : '';

$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$role		= (isset($_POST['role'])) ? trim($_POST['role']) : '';

$name		=	mysqli_real_escape_string($con, $name);

$error = "";
$success = false;

if($act == "login")
{	
	$SQL_login 	= " SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `role` = '$role' ";

	$result = mysqli_query($con, $SQL_login);
	$data	= mysqli_fetch_array($result);

	$valid = mysqli_num_rows($result);

	if($valid > 0)
	{
		$_SESSION["email"] 		= $email;
		$_SESSION["password"] 	= $password;
	
		$_SESSION["id_user"] = $data["id_user"];		
		if($role == "Musician")
			header("Location:main.php");
		else
			header("Location:e-main.php");
	}else{
		$error = "Invalid Login";
		header("refresh:1;url=index.php");
	}
}

if($act == "register")
{	
	$found 	= numRows($con, "SELECT * FROM `user` WHERE `email` = '$email' ");
	if($found) $error ="Email already registered";
}

if(($act == "register") && (!$error))
{	
	$SQL_insert = " 	
		INSERT INTO `user`(`name`, `email`, `password`, `photo`, `spotify`, `role`) 
		VALUES ('$name', '$email', '$password', '', '', '$role')";
	$result = mysqli_query($con, $SQL_insert);
	$success = true;
}
?>
<!DOCTYPE html>
<html>
<title>ALUNAN</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
a:link {
  text-decoration: none;
}

body,h1,h2,h3,h4,h5,h6 {font-family: "Poppins", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
	background-position: top;
	background-size: cover;
	background-color:#c89a4b!important;
	min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}

input.cpwd {
  -webkit-text-security: circle;  
  /* circle , square , disk */
}

.w3-darkbrown,.w3-hover-darkbrown:hover{color:#fff!important;background-color:#7b5f2e!important}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="bgimg-1 w3-brown">

<div class="w3-containerx w3-top" id="contact">
    <div class="w3-content w3-container w3-padding-16 " style="max-width:600px">		 
		<a href="index_app.php" class="w3-right"><i class="fa fa-fw fa-times-circle fa-2x"></i></a> 
	</div>
</div>

<div class="w3-padding-16"></div>

<div class="" >

	
<div class="w3-containerx " id="contact">
    <div class="w3-content w3-containerx " style="max-width:600px">
	<div class="w3-margin w3-padding " >		
		
		<div class="w3-padding"></div>
		
		<img src="images/logo.png" style="width:80px">
		<div class="w3-xlarge" style="line-height: 1.3;"><b>Welcome To Alunan</b></div>
		<div class="w3-large" style="line-height: 1.3;">Welcome back</div>
		<div class="w3-padding-16"></div>
		
	<?PHP if($success) { ?>
	<div class="w3-panel w3-center w3-white w3-round w3-display-container w3-animate-zoom">
	  <span onclick="this.parentElement.style.display='none'" class="w3-circle w3-button w3-large w3-display-topright">&times;</span>
	  <h3>Congratulation!</h3>
	  <p>Your registration has been successful!<br>You can now <b>Login</b>.</p>
	</div>
	<?PHP } ?>	
	
	<?PHP if($error) { ?>
		<div class="w3-panel w3-center w3-red w3-round w3-display-container w3-animate-zoom" id="contact">
			<span onclick="this.parentElement.style.display='none'" class="w3-circle w3-button w3-large w3-display-topright">&times;</span>
			<div class="w3-large">Error! </div>
			<?PHP echo $error;?>
		</div>	
	<?PHP } ?>
	
	<div class="w3-row w3-padding">
		<a href="javascript:void(0)" onclick="openCity(event, 'Login');">
		  <div class="w3-col s4 tablink w3-bottombar w3-hover-light-grey w3-padding w3-border-brown"><b>Login</b></div>
		</a>
		<a href="javascript:void(0)" onclick="openCity(event, 'Signup');">
		  <div class="w3-col s6 tablink w3-bottombar w3-hover-light-grey w3-padding"><b>Sign Up</b></div>
		</a>
		<div class="w3-col s2  w3-bottombar  w3-padding">&nbsp;</div>
	</div>	

		
	<div id="Login" class="w3-containerx w3-padding city" style="display:block">
		<form action="" method="post" class="">		

			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-xlarge" type="email" name="email" placeholder="Email Address" required>
			</div>
			
			<div class="w3-section">
				<input class="w3-input w3-border w3-padding w3-round-xlarge cpwdx" type="password" name="password" id="password" placeholder="Password" required>
				<div class="w3-padding w3-small"><input type="checkbox" onclick="myFunction()"> Show Password</div>
			</div>
			
			<div class="w3-section" >
				<select class="w3-input w3-border w3-padding w3-round-xlarge" name="role" required>
					<option value="" class="w3-disabled">Role</option>
					<option value="Musician">Musician</option>
					<option value="Enthusiast">Enthusiast</option>
				</select>
			</div>
				
			<div class="w3-padding-small"></div>
			  
			<div class="w3-center">
			<input name="act" type="hidden" value="login">
			<button type="submit" class="w3-paddingx w3-block w3-button w3-large w3-round-xlarge w3-darkbrown"><b>Login</b></button>
			</div>
		</form>
		
		<span class="w3-right "><a href="forgot.php" class="w3-text-black">Forgot Password?</a></span>
		
		
		<div class="w3-padding-32"></div>
		
		<div class="w3-center w3-text-lightgrey">Don't have an account? <br>
			<a href="javascript:void(0)" onclick="openCity(event, 'Signup');" class="w3-paddingx w3-button w3-large w3-round-xlarge w3-black">&nbsp; <b>Sign Up</b> &nbsp;</a>
		</div>    
	</div>

	<div id="Signup" class="w3-containerx w3-padding city" style="display:none">
		<form action="" method="post" class="">		

			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-xlarge" type="text" name="name" placeholder="Full Name" required>
			</div>
			
			<div class="w3-section" >
				<input class="w3-input w3-border w3-padding w3-round-xlarge" type="email" name="email" placeholder="Email Address" required>
			</div>
			
			<div class="w3-section">
				<input class="w3-input w3-border w3-padding w3-round-xlarge cpwdx" type="password" name="password" id="password2" placeholder="Password" required>
				<div class="w3-padding w3-small"><input type="checkbox" onclick="myFunction2()"> Show Password</div>
			</div>
			
			<div class="w3-section" >
				<select class="w3-input w3-border w3-padding w3-round-xlarge" name="role" required>
					<option value="" class="w3-disabled">Role</option>
					<option value="Musician">Musician</option>
					<option value="Enthusiast">Enthusiast</option>
				</select>
			</div>

				
			<div class="w3-padding-small"></div>
			  
			<div class="w3-center">
			<input name="act" type="hidden" value="register">
			<button type="submit" class="w3-paddingx w3-block w3-button w3-large w3-round-xlarge w3-darkbrown"><b>Sign Up</b></button>
			</div>
		</form>
		
		<div class="w3-padding-16"></div>
		
		<div class="w3-center w3-text-lightgrey">Already have an Account? <br>
			<a href="index.php" class="w3-paddingx w3-button w3-large w3-round-xlarge w3-black">&nbsp; <b>Login</b> &nbsp;</a>
		</div>
	</div>

		
    </div>
	</div>
	
</div>


</div>


<script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
	x.type = "text";
  } else {
	x.type = "password";
  }
}

function myFunction2() {
  var x = document.getElementById("password2");
  if (x.type === "password") {
	x.type = "text";
  } else {
	x.type = "password";
  }
}
</script>
			
			
<script>
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-border-brown", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.firstElementChild.className += " w3-border-brown";
}
</script>

</body>
</html>
