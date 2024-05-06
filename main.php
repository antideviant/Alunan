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

<div class="w3-padding-16"></div>


<div class="w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col  s10">
				<b>Welcome<br><?PHP echo $data["name"];?></b>
			</div>
			<div class="w3-col s2">
				<a href="profile.php"><img src="upload/<?PHP echo $photo;?>" class="w3-circle w3-border" style="height:70px"></a>
			</div>
		</div>
	</div>
</div>


<!-- content -->	

<div class="w3-padding" id="contact">
    <div class="w3-content w3-xxlarge w3-padding" style="max-width:600px">	
		
		<a href="feed.php" class="w3-buttonx w3-padding w3-block w3-round-xlarge w3-lightbrown ">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col s10">
				<b class="w3-padding">Feed</b>
			</div>
			<div class="w3-col s2">
				<i class="fa fa-fw fa-rss fa-2x "></i>
			</div>
		</div>
		</a>

		<div class="w3-padding-16"></div>
	
		<a href="post.php" class="w3-buttonx w3-padding w3-block w3-round-xlarge w3-lightbrown ">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col s10">
				<b class="w3-padding">My Post</b>
			</div>
			<div class="w3-col s2">
				<i class="fa fa-fw fa-file-alt fa-2x "></i>
			</div>
		</div>
		</a>
		
		<div class="w3-padding-16"></div>

		<a href="profile.php" class="w3-buttonx w3-padding w3-block w3-round-xlarge w3-lightbrown ">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col s10">
				<b class="w3-padding">User Profile</b>
			</div>
			<div class="w3-col s2">
				<i class="fa fa-fw fa-user fa-2x "></i>
			</div>
		</div>
		</a>

		<hr>
		
		<a href="post-add.php" class="w3-buttonx w3-padding w3-block w3-round-xlarge " style="background-color: #3F331F; color: white;">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col s10">
				<b class="w3-padding">Add Post</b>
			</div>
			<div class="w3-col s2">
				<i class="fa fa-fw fa-plus-circle fa-2x "></i>
			</div>
		</div>
		</a>

	</div>
</div>

<!-- content end -->


<div class="w3-bottom w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-large w3-padding-16 ">
			<div class="w3-col  s6">
				<a href="info.php"><i class="fa fa-fw fa-info-circle w3-text-black fa-2x"></i></a>
			</div>
			<div class="w3-col s6">
				<a href="sign-out.php" class="w3-right w3-padding w3-button w3-round-xlarge w3-black">&nbsp; Logout <i class="fa fa-fw fa-sign-out-alt "></i> &nbsp;</a>
			</div>
		</div>
	</div>
</div>


</body>
</html>
