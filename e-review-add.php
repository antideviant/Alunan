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

$id_post 	= (isset($_REQUEST['id_post'])) ? trim($_REQUEST['id_post']) : '';
$act 		= (isset($_POST['act'])) ? trim($_POST['act']) : '';	

$rating	= (isset($_POST['rating'])) ? trim($_POST['rating']) : '0';
$review	= (isset($_POST['review'])) ? trim($_POST['review']) : '';
$review	=	mysqli_real_escape_string($con, $review);

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `review`(`id_post`, `id_user`, `rating`, `review`) 
				VALUES ('$id_post','$id_user','$rating','$review')";
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully Add";
	
	print "<script>self.location='e-review.php?id_post=$id_post';</script>";
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
				<b>Add Review</b>
			</div>
			<div class="w3-col s2">
				<a href="e-profile.php"><img src="upload/<?PHP echo $photo;?>" class="w3-circle w3-border" style="height:70px"></a>
			</div>
		</div>
	</div>
</div>


<!-- content -->	

<div class="w3-containerx w3-padding" id="contact">
    <div class="w3-content w3-containerx w3-padding" style="max-width:600px">	
			
		<form action="" method="post"  >
			 
			<div class="w3-section" >
				Rating<br>
				<input class="w3-radio w3-border w3-padding " type="radio" name="rating" value="1" checked> 1 &nbsp;
				<input class="w3-radio w3-border w3-padding " type="radio" name="rating" value="2" > 2 &nbsp;
				<input class="w3-radio w3-border w3-padding " type="radio" name="rating" value="3" > 3 &nbsp;
				<input class="w3-radio w3-border w3-padding " type="radio" name="rating" value="4" > 4 &nbsp;
				<input class="w3-radio w3-border w3-padding " type="radio" name="rating" value="5" > 5 &nbsp;
			</div>
			
			<div class="w3-section" >				
				Review
				<textarea rows="6" class="w3-input w3-border w3-padding w3-round-xlarge" name="review" placeholder="" required></textarea>
			</div>

			
			<div class="w3-padding"></div>

			<div class="w3-center">
				<input name="act" type="hidden" value="add">
				<button type="submit" class="w3-right w3-padding-large w3-button w3-margin-bottom w3-round-xlarge w3-lightbrown"><b>Add Review</b> <i class="w3-margin-left fa fa-plus-circle fa-lg"></i></button>
			</div>
		</form>


	</div>
</div>

<!-- content end -->


<div class="w3-bottom w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-large w3-padding-16 ">
			<div class="w3-col  s6">
				<a href="e-review.php?id_post=<?PHP echo $id_post;?>"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
			</div>
		</div>
	</div>
</div>


</body>
</html>
