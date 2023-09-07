<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php 
	$_SESSION["TrackingURL"]= $_SERVER["PHP_SELF"];
	Confirm_Login(); 
?>

<?php  
	if(isset($_POST["Submit"])){
  $UserName        = $_POST["Username"];
  $Name            = $_POST["Name"];
  $Password        = $_POST["Password"];
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $Admin           = $_SESSION["UserName"];
  date_default_timezone_set("Asia/Karachi");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($UserName)||empty($Name)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("admins.php");
  }elseif (strlen($Password)<4) {
    $_SESSION["ErrorMessage"]= "Password should be greater than 3 characters";
    Redirect_to("admins.php");
  }elseif ($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"]= "Password and Confirm Password should match";
    Redirect_to("admins.php");
  }elseif (CheckUserNameExistsOrNot($UserName)) {
    $_SESSION["ErrorMessage"]= "Username Exists. Try Another One! ";
    Redirect_to("admins.php");
  }else{
    // Query to insert new admin in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
    $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':password',$Password);
    $stmt->bindValue(':aName',$Name);
    $stmt->bindValue(':adminName',$Admin);
    $Execute=$stmt->execute();
    // var_dump($Execute);
    if($Execute){
      $_SESSION["SuccessMessage"]="New Admin with the name of ".$Name." added Successfully";
      Redirect_to("admins.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("admins.php");
    }
  }
}

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
	<title>Add New Admins</title>
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
				<li class="nav-item"><a href="index.php?page=1" class="nav-link">Live blog</a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a></li>
			</ul>
  </div>
</nav>
	<!-- NAVBAR-END --->
	<!-- HEADER --->
	<header class=" py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1><i class="fas fa-user"></i> Manage Admins</h1>
				</div>
			</div>
		</div>
	</header>
	<!-- HEADER-END --->
	<!-- MAIN-AREA --->
	<section class="container py-2 mb-4">
  <div  class="row shadow-lg" style="background-color: #fff;">
    <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       ?>
      <form class="" action="admins.php" method="post">
        <div class="card mb-3">
          <div class="card-header bg-dark text-white">
            <h1>Add New Admin</h1>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="username"> <span class="FieldInfo"> Username: </span></label>
               <input class="form-control" type="text" name="Username" id="username"  value="">
            </div>
            <div class="form-group">
              <label for="Name"> <span class="FieldInfo"> Name: </span></label>
               <input class="form-control" type="text" name="Name" id="Name" value="">
            </div>
            <div class="form-group">
              <label for="Password"> <span class="FieldInfo"> Password: </span></label>
               <input class="form-control" type="password" name="Password" id="Password" value="">
            </div>
            <div class="form-group">
              <label for="ConfirmPassword"> <span class="FieldInfo"> Confirm Password:</span></label>
               <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword"  value="">
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="Submit" class="btn btn-success btn-block">
                  <i class="fas fa-check"></i> Add
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <h2>Existing Admins</h2>
      <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>No. </th>
            <th>Date&Time</th>
            <th>Username</th>
            <th>Admin Name</th>
            <th>Added by</th>
            <th>Action</th>
          </tr>
        </thead>
      <?php
      global $ConnectingDB;
      $sql = "SELECT * FROM admins ORDER BY id desc";
      $Execute =$ConnectingDB->query($sql);
      $SrNo = 0;
      while ($DataRows=$Execute->fetch()) {
        $AdminId = $DataRows["id"];
        $DateTime = $DataRows["datetime"];
        $AdminUsername = $DataRows["username"];
        $AdminName= $DataRows["aname"];
        $AddedBy = $DataRows["addedby"];
        $SrNo++;
      ?>
      <tbody>
        <tr>
          <td><?php echo htmlentities($SrNo); ?></td>
          <td><?php echo htmlentities($DateTime); ?></td>
          <td><?php echo htmlentities($AdminUsername); ?></td>
          <td><?php echo htmlentities($AdminName); ?></td>
          <td><?php echo htmlentities($AddedBy); ?></td>
          <td> <a href="deleteadmin.php?id=<?php echo $AdminId;?>" class="btn btn-danger">Delete</a>  </td>

      </tbody>
      <?php } ?>
      </table>
      </div>
    </div>
  </div>

</section>


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