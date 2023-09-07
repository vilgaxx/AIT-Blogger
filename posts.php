<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php 
	$_SESSION["TrackingURL"]= $_SERVER["PHP_SELF"];
	Confirm_Login(); 
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
	<title>Post</title>
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
	<header>
	<div class="container mt-4 shadow-lg" style="background-color: #fff;">
			<div class="row">
				<div class="col-md-12">
					<h1><i class="fas fa-blog"></i>Blog Posts</h1>
				</div>
				<div class="col-lg-3">
					<a href="addnewpost.php" class="btn btn-primary btn-block mb-2"><i class="fas fa-edit"></i> Add New Post</a>
				</div>
				<div class="col-lg-3">
					<a href="categories.php" class="btn btn-info btn-block mb-2"><i class="fas fa-folder-plus"></i> Add New Category</a>
				</div>
				<div class="col-lg-3">
					<a href="admins.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-user-plus"></i> Add New Admin</a>
				</div>
				<div class="col-lg-3">
					<a href="comments.php" class="btn btn-success btn-block mb-2"><i class="fas fa-check"></i> Approve Comments</a>
				</div>
			</div>
	<!-- HEADER-END --->
	<!-- MAIN-AREA --->
	
	<div class="container py-2 mb-4">
		<div class="row">
			<div class="col-lg-12">
				<?php
					echo ErrorMessage();
					echo SuccessMessage();
				?>
				<div class="table-responsive">
				<table class="table table-hover">
					<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Category</th>
							<th>Date&Time</th>
							<th>Author</th>
							<th>Banner</th>
							<th>Comments</th>
							<th>Action</th>
							<th>Live Preview</th>
						</tr>
					</thead>
					<?php 
						global $ConnectingDB;
						$sql = "SELECT * FROM posts ORDER BY id desc";
						$stmt = $ConnectingDB->query($sql);
						$sr=0;
						while ($DataRows = $stmt->fetch()) {
							$Id 		= $DataRows["id"];
							$DateTime	= $DataRows["datetime"];
							$PostTitle	= $DataRows["title"];
							$Category	= $DataRows["category"];
							$Admin  	= $DataRows["author"];
							$Image 		= $DataRows["image"];
							$PostText	= $DataRows["content"];
						
							$sr++;
					?>
					<tbody>
						<tr>
							<td><?php echo $sr; ?></td>
							<td><?php 
							if (strlen($PostTitle)>15) {
								$PostTitle = substr($PostTitle,0,15)."..";
							}
							echo $PostTitle; 
							?></td>
							<td><?php
							if (strlen($Category)>10) {
								$Category = substr($Category,0,10)."..";
							}
							echo $Category; 
							?></td>
							<td><?php 
							if (strlen($DateTime)>11) {
								$DateTime = substr($DateTime,0,11)."..";
							}
							echo $DateTime; 
							?></td>
							<td><?php 
							if (strlen($Admin)>6) {
								$Admin = substr($Admin,0,6)."..";
							}
							echo $Admin; 
							?></td>
							<td><img src="uploads/<?php echo $Image; ?>" width="60px;" height="auto;"></td>
							<td>
			                    <?php $Total = ApproveCommentsAccordingtoPost($Id);
			                    if ($Total>0) {
			                      ?>
			                      <span class="badge badge-success">
			                        <?php
			                      echo $Total; ?>
			                      </span>
			                        <?php  }   ?>
			                  <?php $Total = DisApproveCommentsAccordingtoPost($Id);
			                  if ($Total>0) {  ?>
			                    <span class="badge badge-danger">
			                      <?php
			                      echo $Total; ?>
			                    </span>
			                         <?php  }  ?>
			                </td>
							<td>
								<a href="editpost.php?id=<?php echo $Id ?>"><span class="btn btn-warning">Edit</span></a>
								<a href="deletepost.php?id=<?php echo $Id ?>"><span class="btn btn-danger">Delete</span></a>
							</td>
							<td><a href="fullpost.php?id=<?php echo $Id ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
						</tr>
					</tbody>
				<?php }  ?>
				</table>
				</div>
			</div>
		</div>
	</div>
	</div>
	</header>


	<!-- MAIN-AREA-END --->
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