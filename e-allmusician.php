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
$id_user = $_SESSION["id_user"];

$SQL_list = "SELECT * FROM `user` WHERE `id_user` = '$id_user'  ";
$result = mysqli_query($con, $SQL_list);
$data = mysqli_fetch_array($result);
$photo = $data["photo"];
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

.grid-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 10px;
}

.grid-item {
    border: 1px solid #c89a4b;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
}

.grid-item img {
    border-radius: 50%;
    border: 1px solid #ccc;
    width: 100px;
    height: 100px;
}

.grid-item b {
    display: block;
    margin-top: 10px;
}

select {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  appearance: none; /* Remove default arrow icon in Chrome/Safari */
  -webkit-appearance: none; /* Remove default arrow icon in Firefox */
  background-color: #f8f8f8;
  color: #555;
  cursor: pointer;
}

/* Style the dropdown arrow icon */
select::after {
  content: '\25BC'; /* Unicode character for down arrow */
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  pointer-events: none;
}

/* Style the selected option */
select option:checked {
  background-color: #c89a4b;
  color: #fff;
}

/* Style the dropdown options on hover */
select option:hover {
  background-color: #e0e0e0;
  color: #333;
}

#searchInput {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
    width: 550px;
}

</style>

<body class="w3-white">

<div class="w3-padding-small"></div>

<div class="w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-xlarge w3-padding-16 ">
			<div class="w3-col s10">
				<b>Musicians</b>
			</div>
			<div class="w3-col s2">
				<a href="e-profile.php"><img src="upload/<?PHP echo $photo;?>" class="w3-circle w3-border" style="height:70px"></a>
			</div>
		</div>
	</div>
</div>

<div class="w3-padding" id="contact">
    <div class="w3-content w3-padding" style="max-width:600px">
        <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="searchMusicians()">
        <form method="get" action="">
            <select name="sort" onchange="this.form.submit()">
                <option value="asc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'asc') echo 'selected'; ?>>Ascending</option>
                <option value="desc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'desc') echo 'selected'; ?>>Descending</option>
                <option value="recent" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'recent') echo 'selected'; ?>>Recently Added</option>
            </select>
        </form>

        <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';
        $order_by = "ORDER BY name ASC";
        
        if ($sort == 'asc') {
            $order_by = "ORDER BY name ASC";
        } elseif ($sort == 'desc') {
            $order_by = "ORDER BY name DESC";
        } elseif ($sort == 'recent') {
            $order_by = "ORDER BY date DESC";
        }

        $SQL_list = "SELECT * FROM `post`, `user` WHERE post.id_user = user.id_user GROUP BY user.id_user $order_by";
        $result = mysqli_query($con, $SQL_list);
        ?>

        <div class="grid-container" id="musiciansContainer">
            <?php while ($data = mysqli_fetch_array($result)) {
                $id_post = $data["id_post"];
                $date = $data["date"];
                $name = $data["name"];
                $mid_user = $data["id_user"];
                $photo2 = $data["photo"];
                if (!$photo2) $photo2 = "noimage.png";
            ?>
                <div class="grid-item">
                    <a href="e-mprofile2.php?id_post=<?php echo $id_post; ?>&mid_user=<?php echo $mid_user; ?>">
                        <img src="upload/<?php echo $photo2; ?>" alt="<?php echo $name; ?>">
                    </a>
                    <b><?php echo $name; ?></b>
                </div>
            <?php } ?>
        </div>

		<div class="w3-padding-48"></div>
		
	</div>
</div>

<div class="w3-bottom w3-padding">
	<div class="w3-content w3-padding" style="max-width:600px">
		<div class="w3-row w3-large w3-white w3-padding-16 ">
			<div class="w3-col s6">
				<a href="e-main.php"><i class="fa fa-fw fa-arrow-circle-left fa-3x"></i></a>
			</div>
		</div>
	</div>
</div>
<script>
    function searchMusicians() {
        // Declare variables
        var input, filter, gridContainer, gridItems, i, gridItem, b, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        gridContainer = document.getElementById('musiciansContainer');
        gridItems = gridContainer.getElementsByClassName('grid-item');

        // Loop through all grid items, and hide those who don't match the search query
        for (i = 0; i < gridItems.length; i++) {
            gridItem = gridItems[i];
            b = gridItem.getElementsByTagName('b')[0];
            txtValue = b.textContent || b.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                gridItem.style.display = '';
            } else {
                gridItem.style.display = 'none';
            }
        }
    }
</script>
</body>
</html>