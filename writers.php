<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
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
<body>
	<!-- NAVBAR --->
	<nav class="navbar navbar-back navbar-expand-lg navbar-light">
  <a class="navbar-brand logo ml-2" href="#">ait blog</a>
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
  </div>
</nav>
    <!-- NAVBAR-END --->
    
	<!-- HEADER --->
	<section class="jumbotron text-center"style="background-image: linear-gradient(to right, #ffb900, #ff7730);">
    <div class="container">
      <h1 class="promo-title text-white" >All Bloggers</h1>
      <p class="lead promo-text text-white">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
      
        <div class="card-group">
        <?php
      global $ConnectingDB;
      $sql = "SELECT aname,aheadline,abio,aimage FROM admins";
      $Execute=$ConnectingDB->query($sql);
      while ($DataRows=$Execute->fetch()) {
        $ExistingName = $DataRows["aname"];
        $ExistingBio = $DataRows["abio"];
        $ExistingImage = $DataRows["aimage"];
        $ExistingHeadline = $DataRows["aheadline"];
      ?>
  <div class="card border-0 m-2 shadow-lg">
    <img class="card-img-top img-fluid" src="images/<?php echo $ExistingImage; ?>" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title"><?php echo $ExistingName; ?></h5>
      <h6 class="card-title"><?php echo $ExistingHeadline; ?></h6>
      <p class="card-text"><?php echo $ExistingBio; ?></p>
    </div>
  </div>
  <?php } ?>
</div>
        
      </div>
    </div>
  </div>
 
</main>
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