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
$name		= $data["name"];
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
.w3-text-lightbrown,.w3-hover-text-lightbrown:hover{color:#c89a4b!important}

img[alt="www.000webhost.com"]{display:none}
</style>

<body class="w3-white">

<div class="w3-padding-16"></div>


<div class="w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col  s10">
				<b>My Post</b>
			</div>
			<div class="w3-col s2">
				<a href="profile.php"><img src="upload/<?PHP echo $photo;?>" class="w3-circle w3-border" style="height:70px"></a>
			</div>
		</div>
	</div>
</div>


<!-- content -->	

<div class="w3-padding" id="contact">
    <div class="w3-content w3-padding" style="max-width:600px">	
			
		<?PHP
		$bil = 0;
		$SQL_list = "SELECT * FROM `post` WHERE `id_user` = $id_user ORDER BY id_post DESC";
		$result = mysqli_query($con, $SQL_list) ;
		while ( $data	= mysqli_fetch_array($result) )
		{
			$bil++;
			$id_post= $data["id_post"];
			$post	= $data["post"];
			$date	= $data["date"];
		?>	
		
		<div class="w3-panel w3-border w3-border-brown w3-round-xxlarge">
			<div class="w3-row w3-small w3-padding-16 ">
				<div class="w3-col s3 w3-padding-16 w3-padding-small">
					<img src="upload/<?PHP echo $photo;?>" class="w3-circle w3-image w3-border" ></a>
				</div>
				<div class="w3-col s7" style="line-height: 1.3;">
					<b><?PHP echo $name;?></b><br>
					<textarea rows="6" class="w3-small w3-block w3-border w3-border-white"><?PHP echo $post;?></textarea>		
				</div>
				<div class="w3-col s2 w3-center">
					<div class="w3-text-grey"><?PHP echo get_time_ago( strtotime($date) );?></div>
					<a href="post-edit.php?id_post=<?PHP echo $id_post;?>"><i class="fa fa-edit fa-2x w3-padding-small w3-text-lightbrown"></i></a><br>
					<a href="review.php?id_post=<?PHP echo $id_post;?>"><i class="far fa-comment-alt fa-2x w3-padding-small w3-text-brown"></i></a>
				</div>
			</div>
		</div>
		
		<?PHP } ?>
		
		<div class="w3-padding-48"></div>
		
	</div>
</div>

<!-- content end -->


<div class="w3-bottom w3-padding">
	<div class="w3-content w3-white w3-padding" style="max-width:600px">
		<div class="w3-row w3-large w3-padding-16">
			<div class="w3-col  s6">
				<a href="main.php"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
			</div>
			<div class="w3-col  s6">
				<a href="post-add.php" class="w3-right w3-padding w3-button w3-round-xlarge w3-lightbrown">Add Post <i class="fa fa-fw fa-plus-circle"></i></a>
			</div>
		</div>
	</div>
</div>


</body>
</html>
