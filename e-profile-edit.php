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

$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';
$spotify	= (isset($_POST['spotify'])) ? trim($_POST['spotify']) : '';

$name		=	mysqli_real_escape_string($con, $name);
$spotify	=	mysqli_real_escape_string($con, $spotify);

$success = "";

if($act == "edit")
{	
	$SQL_update = " 
	UPDATE
		`user`
	SET
		`name` = '$name',
		`email` = '$email',
		`spotify` = '$spotify',
		`password` = '$password'
	WHERE
		id_user = $id_user
	";
										
	$result = mysqli_query($con, $SQL_update);
	
	if(isset($_FILES['photo'])){		 
		  $file_name = $_FILES['photo']['name'];
		  $file_size = $_FILES['photo']['size'];
		  $file_tmp = $_FILES['photo']['tmp_name'];
		  $file_type = $_FILES['photo']['type'];
		  
		  $fileNameCmps = explode(".", $file_name);
		  $file_ext = strtolower(end($fileNameCmps));
		  $new_file	= rand() . "." . $file_ext;
		   
		  if(empty($errors)==true) {
			 move_uploaded_file($file_tmp,"upload/".$new_file);
			 
			$query = "UPDATE `user` SET `photo`='$new_file' WHERE `id_user` = '$id_user'";			
			$result = mysqli_query($con, $query) or die("Error in query: ".$query."<br />".mysqli_error($con));
		  }else{
			 print_r($errors);
		  }  
	}
	
	$success = "Successfully Updated";
	
	//print "<script>self.location='e-profile.php';</script>";
}

if($act == "photo_del")
{
	$dat	= mysqli_fetch_array(mysqli_query($con, "SELECT `photo` FROM `user` WHERE `id_user`= '$id_user'"));
	unlink("upload/" .$dat['photo']);
	$rst_d 	= mysqli_query( $con, "UPDATE `user` SET `photo`='' WHERE `id_user` = '$id_user' " );
	print "<script>self.location='e-profile.php';</script>";
}

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

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "e-profile.php"); }
?>	
<!-- Content -->

<div class="w3-containerx" id="contact">
    <div class="w3-content w3-container w3-padding-16" style="max-width:600px">
		
		<div class="w3-padding w3-xlarge"><b>User Profile</b></div>
		
		<form action="" method="post" class="w3-padding"  enctype = "multipart/form-data" >			
			 			
			<div class="w3-section w3-center" >
				<img src="upload/<?PHP echo $photo; ?>" class="w3-circle w3-border w3-image" alt="image" style="width:150px;max-width:200px">
				<?PHP if($data["photo"] <>"") { ?>
				<br>
				<a class="w3-tag w3-amber w3-round w3-small" href="?act=photo_del"><small>Remove</small></a>
				<?PHP }  ?>
			</div>
			
			<div class="w3-section" >
				<?PHP if($data["photo"] =="") { ?>
				<div class="custom-file">
					<input type="file" class="w3-input w3-border w3-round-large" name="photo" id="photo" accept=".jpeg, .jpg,.png,.gif">
					<small>  only JPEG, JPG, PNG or GIF allowed </small>
				</div>
				<?PHP } ?>
			</div>
			
			<div class="w3-section" >
				Full Name
				<input class="w3-input w3-border w3-padding w3-round-large" type="text" name="name" value="<?PHP echo $data["name"];?>" placeholder="Full Name" maxlength="100" required>
			</div>
			
			<div class="w3-section" >
				Email
				<input class="w3-input w3-border w3-padding w3-round-large" type="email" name="email" value="<?PHP echo $data["email"];?>" placeholder="email" required>
			</div>
			
			<div class="w3-section">
				Password
				<input class="w3-input w3-border w3-padding w3-round-large cpwdx" type="password" name="password" id="password" value="<?PHP echo $data["password"];?>" placeholder="Password" maxlength="40" required>
				<div class="w3-center w3-small">Password must at least be 6 characters</div>
			</div>
			
			<div class="w3-section" >
				Spotify Profile
				<textarea rows="4" class="w3-input w3-border w3-padding w3-round-xlarge" name="spotify" placeholder="spotify" ><?PHP echo $data["spotify"];?></textarea>
			</div>
			
			<div class="w3-padding"></div>

	
			<input name="act" type="hidden" value="edit">
			
			<div class="w3-row w3-large">
				<div class="w3-col  s6">
					<a href="e-profile.php"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
				</div>
				<div class="w3-col  s6">
					<button type="submit" class="w3-right w3-padding w3-button w3-round-xlarge w3-lightbrown">Save Changes <i class="fa fa-fw fa-edit"></i></button>
				</div>
			</div>
		</form>
		
		<div class="w3-padding-16"></div>
				
	</div>
</div>
<!-- Content End -->



</body>
</html>
