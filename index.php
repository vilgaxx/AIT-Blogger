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
	<title>AIT BLOG</title>
</head>
<body>
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
				<li class="nav-item"><a href="login.php" class="nav-link">Log in</a></li>
	</ul>
	<ul class="navbar-nav ml-2 mr-2">
				<form class="form-inline" action="index.php">
					<div class="form-group">
						<input class="form-control mr-2" type="text" name="Search" placeholder="Search here" value="">
						<button class="btn btn-warning" name="SearchButton">Go</button>
					</div>
				</form>
			</ul>
  </div>
</nav>
	<!-- NAVBAR-END --->
	<!--- BANNER --->
  <section id="banner">
  <div class="banner">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1 class="promo-title ">ait Blogger </h1>
          <p class="promo-text">The complete blog using PHP,HTML,CSS and Mysql by MOHD YUSUF PARVEZ</p>
        </div>
        <div class="col-md-6 text-center">
          <!-- <img src="images/banner.png" alt="banner"class="img-fluid"> -->
          <img src="images/banner3.png" alt="banner" class="img-fluid">
        </div>
      </div>
    </div>
	</div>
  </section>
	<!-- HEADER --->
	<header>
		<div class="container">
			<div class="row mt-4">
				<!--MAIN-AREA-->
				<div class="col">
					<?php echo ErrorMessage(); ?>
					<?php 
						global $ConnectingDB;
						if (isset($_GET["SearchButton"])) {
							$Search = $_GET["Search"];
							$sql = "SELECT * FROM posts
							WHERE datetime LIKE :search
							OR title LIKE :search
							OR category LIKE :search
							OR author LIKE :search
							OR content LIKE :search ORDER BY id desc";
							$stmt = $ConnectingDB->prepare($sql);
							$stmt->bindvalue(':search','%'.$Search.'%');
							$stmt->execute();
						}elseif (isset($_GET["page"])) {
							$Page=$_GET["page"];
							if ($Page==0||$Page<1) {
								$ShowPostFrom=0;
							}else{
								$ShowPostFrom=($Page*5)-5;
							}
							$sql ="SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
							$stmt = $ConnectingDB->query($sql);
						}
						// Query When Category is active in URL Tab
				          elseif (isset($_GET["category"])) {
				            $Category = $_GET["category"];
				            $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
				            $stmt=$ConnectingDB->query($sql);
				          }

				          // The default SQL query
						else {
							$sql = "SELECT * FROM posts ORDER BY id desc LIMIT 3";
						$stmt = $ConnectingDB->query($sql);
						}
						while ($DataRows = $stmt->fetch()) {
							$Id 		= $DataRows["id"];
							$DateTime	= $DataRows["datetime"];
							$PostTitle	= $DataRows["title"];
							$Category	= $DataRows["category"];
							$Admin  	= $DataRows["author"];
							$Image 		= $DataRows["image"];
							$PostText	= $DataRows["content"];
					?>

					<div class="card card-margin shadow-lg border-0">
						<img src="uploads/<?php echo htmlentities($Image);?>" class="img-fluid card-img-top">
						<div class="card-body">
							<h1 class="card-title title-size"><?php echo htmlentities($PostTitle); ?></h1>
							<small class="text-muted" style="display:block;">Category: <span class="text-dark"> <a class="text-warning" href="index.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & Written by <span class="text-dark"> <a class="text-warning" href="adminprofile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
							<span style="float: right;" class="badge badge-dark text-light" >Comments 
								<?php echo ApproveCommentsAccordingtoPost($Id); ?>
              </span>
              <hr>
							<p class="card-text lead text-weight"><?php 
							if (strlen($PostText)>150) {
								$PostText = substr($PostText,0,150)."...";
							}
							echo htmlentities($PostText); 
							?></p>
							<a href="fullpost.php?id=<?php echo $Id; ?>" style="float: right;">
								<span  class="btn btn-color"> Read More>></span>
							</a>
						</div>
					</div>
					<?php } ?>
					<!-- Pagination -->
          <navbar>
            <ul class="pagination pagination-lg">
              <!-- Creating Backward Button -->
              <?php if( isset($Page) ) {
                if ( $Page>1 ) {?>
             <li class="page-item">
                 <a href="index.php?page=<?php  echo $Page-1; ?>" class="page-link">&laquo;</a>
               </li>
             <?php } }?>
            <?php
            global $ConnectingDB;
            $sql           = "SELECT COUNT(*) FROM posts";
            $stmt          = $ConnectingDB->query($sql);
            $RowPagination = $stmt->fetch();
            $TotalPosts    = array_shift($RowPagination);
            // echo $TotalPosts."<br>";
            $PostPagination=$TotalPosts/5;
            $PostPagination=ceil($PostPagination);
            // echo $PostPagination;
            for ($i=1; $i <=$PostPagination ; $i++) {
              if( isset($Page) ){
                if ($i == $Page) {  ?>
              <li class="page-item disabled">
                <a href="index.php?page=<?php  echo $i; ?>" class="page-link"><?php  echo $i; ?></a>
              </li>
              <?php
            }else {
              ?>  <li class="page-item">
                  <a href="index.php?page=<?php  echo $i; ?>" class="page-link"><?php  echo $i; ?></a>
                </li>
            <?php  }
          } } ?>
          <!-- Creating Forward Button -->
          <?php if ( isset($Page) && !empty($Page) ) {
            if ($Page+1 <= $PostPagination) {?>
         <li class="page-item">
             <a href="index.php?page=<?php  echo $Page+1; ?>" class="page-link">&raquo;</a>
           </li>
         <?php } }?>
            </ul>
          </nav>
        </div>
				<!--MAIN-AREA-END-->
			</div>
		</div>
	</header>
	

	<!-- FOOTER --->
	<footer class="bg-dark text-white" id="footer">
		<div class="container">
			<div class="row">
				<div class="col">
					<p class="lead text-weight text-center p-4">|MOHD YUSUF PARVEZ| <span id="year"></span> &copy; ----ALL RIGHT RESERVES</p>
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