<?PHP
session_start();

include("database.php");
if( !verifyUser($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_user	= $_SESSION["id_user"];

$SQL_list 	= "SELECT * FROM `user` WHERE `id_user` = '$id_user'  ";
$result 	= mysqli_query($con, $SQL_list) ;
$data		= mysqli_fetch_array($result);
$photo		= $data["photo"];
if(!$photo) $photo = "noimage.png";
?>
<!DOCTYPE html>
<html>
<title>Alunan</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
	background: rgb(68,178,227);
	background: linear-gradient(180deg, rgba(68,178,227,1) 0%, rgba(141,141,226,1) 0%, rgba(0,212,255,1) 100%);
	min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}

input.cpwd {
  -webkit-text-security: circle;  
  /* circle , square , disk */
}

.w3-lightbrown,.w3-hover-lightbrown:hover{color:#fff!important;background-color:#c89a4b!important}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="">
	
<div class="w3-padding"></div>

<div class="w3-containerx" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:600px">
			
			<div class="w3-padding w3-xlarge"><b>User Profile</b></div>
			 
			<div class="w3-section w3-center" >
				<img src="upload/<?PHP echo $photo; ?>" class="w3-circle w3-border w3-image" alt="image" style="width:150px;max-width:200px">
			</div>
						
			<div class="w3-padding" >
				<b>Full Name</b><br>
				<div class="w3-input w3-light-grey w3-round-large w3-border"><?PHP echo $data["name"];?></div>
			</div>
			
			<div class="w3-padding" >
				<b>Email</b><br>
				<div class="w3-input w3-light-grey w3-round-large w3-border"><?PHP echo $data["email"];?></div>
			</div>
			
			<div class="w3-padding" >
				<b>Password</b><br>
				<div class="w3-input w3-light-grey w3-round-large w3-border" type="password"><?PHP echo $data["password"];?></div>
			</div>
			
			<div class="w3-padding" >
				<b>Spotify Profile</b><br>
				<textarea class="w3-input w3-light-grey w3-round-large w3-border"><?PHP echo $data["spotify"];?></textarea>
			</div>
			
			<div class="w3-padding"></div>

		
			<div class="w3-padding-16"></div>
				
	</div>
</div>
<!-- Content End -->

<div class="w3-bottom w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-large w3-padding-16 ">
			<div class="w3-col  s6">
				<a href="e-main.php"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
			</div>
			<div class="w3-col  s6">
				<a href="e-profile-edit.php" class="w3-right w3-padding w3-button w3-round-xlarge w3-lightbrown">Update Profile <i class="fa fa-fw fa-edit"></i></a>
			</div>
		</div>
	</div>
</div>

</body>
</html>
