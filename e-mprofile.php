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

$mid_user	= (isset($_GET['mid_user'])) ? trim($_GET['mid_user']) : '';
$id_post	= (isset($_GET['id_post'])) ? trim($_GET['id_post']) : '';

$act 		= (isset($_GET['act'])) ? trim($_GET['act']) : '';

if($act == "add_favourite")
{	
	$SQL_insert = " 
	INSERT INTO `favourite`(`id_user`, `mid_user`) VALUES ('$id_user','$mid_user')";
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully Add";
	
	print "<script>self.location='e-mprofile.php?mid_user=$mid_user';</script>";
}

if($act == "del_favourite")
{	
	$SQL_delete = " 
	DELETE FROM `favourite` WHERE `id_user` = '$id_user' AND `mid_user` = '$mid_user' ";
										
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Successfully Remove";
	
	print "<script>self.location='e-mprofile.php?mid_user=$mid_user';</script>";
}

$follow_found	= numRows($con, "SELECT * FROM `favourite` WHERE `id_user` = '$id_user' AND `mid_user` = '$mid_user'");

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
  line-height: 1.5;
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

.w3-lightbrown,.w3-hover-lightbrown:hover{color:#fff!important;background-color:#c89a4b!important}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="w3-white">

<div class="w3-padding-small"></div>


<div class="w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col  s10">
				<b>Musician Profile</b>
			</div>
			<div class="w3-col s2">				
				<a href="e-profile.php"><img src="upload/<?PHP echo $photo;?>" class="w3-circle w3-border" style="height:70px"></a>
			</div>
		</div>
	</div>
</div>


<!-- content -->	

<div class="w3-padding" id="contact">
    <div class="w3-content w3-padding" style="max-width:600px">	
			<?PHP
			$SQL_music 	= "SELECT * FROM `user` WHERE `id_user` = '$mid_user'  ";
			$rst_music 	= mysqli_query($con, $SQL_music) ;
			$dat_music	= mysqli_fetch_array($rst_music);
			$mphoto		= $dat_music["photo"];
			if(!$mphoto) $mphoto = "noimage.png";
			?>

			<div class="w3-row">
				<div class="w3-col s10">
					<img src="upload/<?PHP echo $mphoto; ?>" class="w3-circle w3-border w3-image" alt="image" style="width:90px;max-width:100px">
				</div>
				<div class="w3-col s2 w3-padding-16">
					<?PHP if($follow_found > 0 ) { ?>
					<a href="?act=del_favourite&mid_user=<?PHP echo $mid_user;?>"><i class="fa fa-bookmark fa-4x w3-text-green"></i></a>
					<?PHP } else { ?>
					<a href="?act=add_favourite&mid_user=<?PHP echo $mid_user;?>"><i class="far fa-bookmark fa-4x"></i></a>
					<?PHP } ?>
				</div>
			</div>
			
			<hr class="w3-lightbrown" style="height: 3px;">
			
			<div class="w3-padding" >
				<b>Full Name</b><br>
				<div class="w3-block w3-padding w3-round-large w3-border"><?PHP echo $dat_music["name"];?></div>
			</div>
			
			<div class="w3-padding" >
				<b>Email</b><br>
				<div class="w3-block w3-padding w3-round-large w3-border"><?PHP echo $dat_music["email"];?></div>
			</div>
			
			<div class="w3-padding" >
				<b>Spotify Profile</b><br>
				<textarea class="w3-block w3-padding w3-round-large w3-border"><?PHP echo $dat_music["spotify"];?></textarea>
			</div>
		
		<div class="w3-padding-48"></div>
		
	</div>
</div>

<!-- content end -->


<div class="w3-bottom w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-large w3-white w3-padding-16 ">
			<div class="w3-col  s6">				
				<a href="e-post.php"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
			</div>
		</div>
	</div>
</div>


</body>
</html>
