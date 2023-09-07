<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php 
	$_SESSION["TrackingURL"]= $_SERVER["PHP_SELF"];
	Confirm_Login(); 
?>

<?php
// Fetching the existing Admin Data Start
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql  = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt =$ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $ExistingName     = $DataRows['aname'];
  $ExistingUsername = $DataRows['username'];
  $ExistingHeadline = $DataRows['aheadline'];
  $ExistingBio      = $DataRows['abio'];
  $ExistingImage    = $DataRows['aimage'];
}
// Fetching the existing Admin Data End
if(isset($_POST["Submit"])){
  $AName     = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio      = $_POST["Bio"];
  $Image     = $_FILES["Image"]["name"];
  $Target    = "Images/".basename($_FILES["Image"]["name"]);
if (strlen($AHeadline)>30) {
    $_SESSION["ErrorMessage"] = "Headline Should be less than 30 characters";
    Redirect_to("profile.php");
  }elseif (strlen($ABio)>500) {
    $_SESSION["ErrorMessage"] = "Bio should be less than than 500 characters";
    Redirect_to("profile.php");
  }else{
    // Query to Update Admin Data in DB When everything is fine
    global $ConnectingDB;
    if (!empty($_FILES["Image"]["name"])) {
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
              WHERE id='$AdminId'";
    }else {
      $sql = "UPDATE admins
              SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
              WHERE id='$AdminId'";
    }
    $Execute= $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if($Execute){
      $_SESSION["SuccessMessage"]="Details Updated Successfully";
      Redirect_to("profile.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("profile.php");
    }
  }
} //Ending of Submit Button If-Condition
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="bootcss/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootcss/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="bootcss/bootstrap-reboot.css">
	<link rel="stylesheet" type="text/css" href="css/edit.css">
	<script src="https://kit.fontawesome.com/34e635af74.js" crossorigin="anonymous"></script>
	<title>Admin Profile</title>
</head>
<body style="background-image: linear-gradient(to right, #2998ff, #5643fa);">
	<!-- NAVBAR --->
	<nav class="navbar navbar-dash-back navbar-expand-lg navbar-light ">
  <a class="navbar-brand logo ml-2" href="#">Ait bolg</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="profile.php" class="nav-link text-success"><i class="fas fa-user"></i> My Profile</a></li>
				<li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
				<li class="nav-item"><a href="posts.php" class="nav-link">Posts</a></li>
				<li class="nav-item"><a href="categories.php" class="nav-link">Categories</a></li>
				<li class="nav-item"><a href="admins.php" class="nav-link">Manage Admins</a></li>
				<li class="nav-item"><a href="comments.php" class="nav-link">Comments</a></li>
				<li class="nav-item"><a href="index.php?page=1" class="nav-link">Live Blogs</a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a></li>
			</ul>
  </div>
</nav>
	<!-- NAVBAR-END --->
	<!-- HEADER --->
	<header class=" py-3">
		<div class="container mt-4 shadow-lg" style="background-color: #fff;">
			<div class="row">
				<div class="col-md-12">
					<h1><i class="fas fa-user mr-2"></i>@<?php echo $ExistingUsername; ?></h1>
					<small><?php echo $ExistingHeadline; ?></small>
				</div>
			</div>
		
	<!-- HEADER-END --->
	<!-- MAIN-AREA --->
	<section class="container py-2 mb-4">
  <div class="row">
    <!-- Left Area -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h3> <?php echo $ExistingName; ?></h3>
        </div>
        <div class="card-body">
          <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
          <div class="">
            <?php echo $ExistingBio; ?>  </div>

        </div>

      </div>

    </div>
    <!-- Righ Area -->
    <div class="col-md-9" style="min-height:400px;">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <form class="" action="profile.php" method="post" enctype="multipart/form-data">
        <div class="card">
          <div class="card-header bg-dark text-white">
            <h4>Edit Profile</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
               <input class="form-control" type="text" name="Name" id="title" placeholder="Your name" value="">
            </div>
            <div class="form-group">
               <input class="form-control" type="text" id="title" placeholder="Headline" name="Headline" value="">
               <small> Add a professional headline like, 'Engineer' at XYZ or 'Student' </small>
               <span class="text-danger">Not more than 30 characters</span>
            </div>
            <div class="form-group">
              <textarea  placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>
            </div>

            <div class="form-group">
              <div class="custom-file">
              <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
              <label for="imageSelect" class="custom-file-label">Select Image </label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="Submit" class="btn btn-success btn-block">
                  <i class="fas fa-check"></i> Publish
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

</section>
</div>
	</header>


	<!-- FOOTER --->
	<footer class="dash-bg-color text-white">
		<div class="container mrtop">
			<div class="row">
				<div class="col">
					<p class="lead text-center">|MOHD YUSUF PARVEZ| <span id="year"></span> &copy; ----ALL RIGHT RESERVES</p>
				</div>
			</div>
			
		</div>
	</footer>
	<!-- FOOTER-END --->

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
	$('#year').text(new Date().getFullYear());
</script>
</body>
</html>