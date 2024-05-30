<?php
session_start();

include("database.php");
if (!verifyUser($con)) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION["id_user"];

$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
$id_review = isset($_REQUEST['id_review']) ? trim($_REQUEST['id_review']) : '';
$id_post = isset($_REQUEST['id_post']) ? trim($_REQUEST['id_post']) : '';

$rating = isset($_POST['rating']) ? trim($_POST['rating']) : '0';
$review = isset($_POST['review']) ? trim($_POST['review']) : '';
$review = mysqli_real_escape_string($con, $review);

if ($act == "edit") {
    $SQL_update = "
    UPDATE
        `review`
    SET
        `rating` = '$rating',
        `review` = '$review'
    WHERE
        id_review = $id_review
    ";

    $result = mysqli_query($con, $SQL_update);

    if ($result) {
        $success = "Successfully Updated";
        echo "<script>self.location='e-review.php?id_post=$id_post';</script>";
        exit;
    } else {
        echo "Error updating review.";
        exit;
    }
}

if ($act == "del") {
    $SQL_delete = "DELETE FROM `review` WHERE `id_review` = '$id_review'";
    $result = mysqli_query($con, $SQL_delete);

    if ($result) {
        $success = "Successfully Deleted";
        echo "<script>self.location='e-review.php?id_post=$id_post';</script>";
        exit;
    } else {
        echo "Error deleting review.";
        exit;
    }
}

$SQL_review = "SELECT * FROM `review` WHERE `id_review` = '$id_review'";
$rst_review = mysqli_query($con, $SQL_review);
$dat_review = mysqli_fetch_array($rst_review);

if ($dat_review) {
    $id_post = $dat_review["id_post"];
    $rating = $dat_review["rating"];
    $review = $dat_review["review"];
} else {
    $id_post = '';
    $rating = '0';
    $review = '';
}

$SQL_list = "SELECT * FROM `user` WHERE `id_user` = '$id_user'";
$result = mysqli_query($con, $SQL_list);
$data = mysqli_fetch_array($result);
$photo = $data["photo"];
if (!$photo) $photo = "noimage.png";
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
                <b>Edit Review</b>
            </div>
            <div class="w3-col s2">
                <a href="e-profile.php"><img src="upload/<?php echo $photo;?>" class="w3-circle w3-border" style="height:70px"></a>
            </div>
        </div>
    </div>
</div>

<!-- content -->

<div class="w3-containerx w3-padding" id="contact">
    <div class="w3-content w3-containerx w3-padding" style="max-width:600px">	
		
        <?php
        $SQL_list = "SELECT * FROM `post`, `user` WHERE post.id_user = user.id_user AND `id_post` = '$id_post'";
        $result = mysqli_query($con, $SQL_list);
        while ($data = mysqli_fetch_array($result)) {
            $id_post = $data["id_post"];
            $post = $data["post"];
            $date = $data["date"];
            $name = $data["name"];
            $photo2 = $data["photo"];
            if (!$photo2) $photo2 = "noimage.png";
        ?>	
		
        <div class="w3-panel w3-border w3-border-brown w3-round-xxlarge">
            <div class="w3-row w3-small w3-padding-16 ">
                <div class="w3-col s3 w3-padding-16 w3-padding-small">
                    <img src="upload/<?php echo $photo2;?>" class="w3-circle w3-image w3-border"></a>
                </div>
                <div class="w3-col s7" style="line-height: 1.3;">
                    <b><?php echo $name;?></b><br>
                    <textarea rows="6" class="w3-small w3-block w3-border w3-border-white"><?php echo $post;?></textarea>		
                </div>
                <div class="w3-col s2 w3-center">
                    <div class="w3-text-grey"><?php echo get_time_ago(strtotime($date));?></div>
                </div>
            </div>
        </div>
		
        <?php } ?>
		
        <hr>

        <form action="" method="post">
            <div class="w3-section">
                Rating<br>
                <input class="w3-radio w3-border w3-padding" type="radio" name="rating" value="1" <?php if ($rating == "1") echo "checked"; ?> > 1 &nbsp;
                <input class="w3-radio w3-border w3-padding" type="radio" name="rating" value="2" <?php if ($rating == "2") echo "checked"; ?> > 2 &nbsp;
                <input class="w3-radio w3-border w3-padding" type="radio" name="rating" value="3" <?php if ($rating == "3") echo "checked"; ?> > 3 &nbsp;
                <input class="w3-radio w3-border w3-padding" type="radio" name="rating" value="4" <?php if ($rating == "4") echo "checked"; ?> > 4 &nbsp;
                <input class="w3-radio w3-border w3-padding" type="radio" name="rating" value="5" <?php if ($rating == "5") echo "checked"; ?> > 5 &nbsp;
            </div>
            
            <div class="w3-section">                
                Review
                <textarea rows="6" class="w3-input w3-border w3-padding w3-round-xlarge" name="review" placeholder="" required><?php echo $review;?></textarea>
            </div>

            <div class="w3-padding"></div>

            <div class="">
                <input name="id_post" type="hidden" value="<?php echo $id_post;?>">
                <input name="id_review" type="hidden" value="<?php echo $id_review;?>">
                <input name="act" type="hidden" value="edit">
                <a href="?act=del&id_review=<?php echo $id_review;?>&id_post=<?php echo $id_post;?>" class="w3-padding-large w3-button w3-margin-bottom w3-round-xlarge w3-red"><i class="fa fa-trash fa-lg"></i></a>
                <button type="submit" class="w3-right w3-padding-large w3-button w3-margin-bottom w3-round-xlarge w3-lightbrown"><b>Edit review</b> <i class="w3-margin-left fa fa-edit fa-lg"></i></button>
            </div>
        </form>

    </div>
</div>

<!-- content end -->

<div class="w3-bottom w3-padding">
    <div class="w3-content w3-padding" style="max-width:600px">
        <div class="w3-row w3-large w3-padding-16">
            <div class="w3-col s6">
                <a href="e-review.php?id_post=<?php echo $id_post;?>"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
            </div>
        </div>
    </div>
</div>

</body>
</html>