<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php 
	$_SESSION["TrackingURL"]= $_SERVER["PHP_SELF"];
	Confirm_Login(); 
?>

<?php  
	if(isset($_POST["submit"])) {
		$PostTitle=$_POST["PostTitle"];
		$Category=$_POST["Category"];
		$Image=$_FILES["image"]["name"];
		$Target= "uploads/".basename($_FILES["image"]["name"]);
		$PostText=$_POST["PostDescription"];
		$Admin = $_SESSION["UserName"];

		date_default_timezone_set("Asia/Kolkata"); 
		$CurrentTime=time();
		$DateTime=strftime("%d-%B-%y %r",$CurrentTime);
		

		if (empty($PostTitle)) {
			$_SESSION["ErrorMessage"]= "Title can't be empty";
			Redirect_to("addnewpost.php");
		}
		elseif (strlen($PostTitle)<5) {
			$_SESSION["ErrorMessage"]= "Post title should be greater than 5 characters";
			Redirect_to("addnewpost.php");
		}
		elseif (strlen($PostText)>9999) {
			$_SESSION["ErrorMessage"]= "Content should be less than 10000 characters";
			Redirect_to("addnewpost.php");
		}
		else {
			// Query to insert category in DB when everything is fine
			$sql = "INSERT INTO posts(datetime,title,category,author,image,content)";
			$sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
			$stmt = $ConnectingDB->prepare($sql);
			$stmt->bindValue(':dateTime',$DateTime);
			$stmt->bindValue(':postTitle',$PostTitle);
			$stmt->bindValue(':categoryName',$Category);
			$stmt->bindValue(':adminName',$Admin);
			$stmt->bindValue(':imageName',$Image);
			$stmt->bindValue(':postDescription',$PostText);
			$Execute=$stmt->execute();
			move_uploaded_file($_FILES["image"]["tmp_name"],$Target);

			if ($Execute) {
				$_SESSION["SuccessMessage"]="Post added successfully";
				Redirect_to("addnewpost.php");
			}
			else {
				$_SESSION["ErrorMessage"]= "Something went wrong. Try again!";
			Redirect_to("addnewpost.php");
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
	<title>Add New Post</title>
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
				<li class="nav-item"><a href="Profile.php" class="nav-link text-success"><i class="fas fa-user"></i> My Profile</a></li>
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
	<header class="py-3">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1><i class="fas fa-edit"></i>Add New Posts</h1>
				</div>
			</div>
		</div>
	</header>
	<!-- HEADER-END --->
	<!-- MAIN-AREA --->
	<section class="container py-2 mb-4">
		<div class="row">
			<div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
				<?php
					echo ErrorMessage();
					echo SuccessMessage();
				?>
				<form class="" action="addnewpost.php" method="post" enctype="multipart/form-data">
					<div class="card shadow-lg mb-3">
						<div class="card-body">
							<div class="form-group">
								<label for="title"><span class="Fieldinfo">Post Title:</span></label>
								<input type="text" name="PostTitle" id="title" class="form-control">
							</div>
							<div class="form-group">
								<label for="CategoryTitle"><span class="Fieldinfo">Choose Category:</span></label>
								<select class="form-control" id="CategoryTitle" name="Category">
									<?php
										global $ConnectingDB;
										$sql= "SELECT id,title FROM category";
										$stmt= $ConnectingDB->query($sql);
										while ($DataRows = $stmt->fetch()) {
											$Id= $DataRows["id"];
											$categoryName= $DataRows["title"];
										
									?>
										<option><?php echo $categoryName; ?></option>
								<?php 	} ?>
								</select>
							</div>
							<div class="form-group">
								<div class="custom-file">
									<input class="custom-file-input" type="file" name="image" id="imageSelect" value="">
									<label class="custom-file-label" for="imageSelect">Select Image</label>
								</div>
							</div>
							<div class="form-group">
								<label for="Content"><span class="Fieldinfo">Content:</span></label>
								<textarea class="form-control" id="Content" name="PostDescription" rows="8" cols="80"></textarea>
							</div>
							<div class="row">
								<div class="col-lg-6 mb-2">
									<a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
								</div>
								<div class="col-lg-6 mb-2">
									<button type="submit" name="submit" class="btn btn-success btn-block">
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