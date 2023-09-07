<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>

<!-- Fetching Existing Data -->
<?php
    $SearchQueryParameter = $_GET["username"];
    global   $ConnectingDB;
    $sql    =  "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
    $stmt   =  $ConnectingDB->prepare($sql);
    $stmt   -> bindValue(':userName', $SearchQueryParameter);
    $stmt   -> execute();
    $Result = $stmt->rowcount();
if( $Result==1 ){
  while ( $DataRows   = $stmt->fetch() ) {
    $ExistingName     = $DataRows["aname"];
    $ExistingBio      = $DataRows["abio"];
    $ExistingImage    = $DataRows["aimage"];
    $ExistingHeadline = $DataRows["aheadline"];
  }
}else {
  $_SESSION["ErrorMessage"]="Bad Request !!";
  Redirect_to("index.php?page=1");
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
	<title>AIT Blog</title>
</head>
<body style="background-image: linear-gradient(to right, #ffb900, #ff7730);">
	<!-- NAVBAR --->
	<nav class="navbar navbar-back navbar-expand-lg navbar-light">
  <a class="navbar-brand logo ml-2" href="#">Ait bolg</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
    <li class="nav-item"><a href="index.php?page=1" class="nav-link">Home</a></li>
				<li class="nav-item"><a href="index.php?page=1" class="nav-link">Blog</a></li>
				<li class="nav-item"><a href="writers.php" class="nav-link">Bloggers</a></li>
				<li class="nav-item"><a href="#" class="nav-link">features</a></li>
	</ul>
	<ul class="navbar-nav ml-2 mr-2">
				<form class="form-inline" action="index.php">
					<div class="form-group">
						<input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
						<button class="btn btn-primary" name="SearchButton">Go</button>
					</div>
				</form>
			</ul>
  </div>
</nav>
	<!-- NAVBAR-END --->
	<!-- HEADER --->
	<header>
		<div class="container shadow-lg"  style="background-color: #fff;">
			<div class="row mt-4">
				<div class="col-md-12">
					<h1><i class="fas fa-user text-success mr-2" style="color:#27aae1;"></i><?php echo $ExistingName; ?></h1>
          <h3><?php echo $ExistingHeadline; ?></h3>
				</div>
			</div>
		
	
	<!-- HEADER-END --->
	<!-- MAIN-AREA --->

	<section class="container py-2 mb-4" style="background-color: #fff;">
      <div class="row">
        <div class="col-md-3">
          <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 ro-circle" alt="">
        </div>
        <div class="col-md-9 pt-4" style="min-height:400px;">
          <div class="card">
            <div class="card-body">
              <p class="lead"> <?php echo $ExistingBio; ?> </p>
            </div>

          </div>

        </div>

      </div>

    </section>	
    </div>
    </header>

	<!-- MAIN-AREA-END --->

	<!-- FOOTER --->
	<footer class="bg-color text-white">
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