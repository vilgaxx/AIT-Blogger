<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>

<?php  
if(isset($_POST["Submit"])){
  $Name    = $_POST["CommenterName"];
  $Email   = $_POST["CommenterEmail"];
  $Comment = $_POST["CommenterThoughts"];
  date_default_timezone_set("Asia/Karachi");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

  if(empty($Name)||empty($Email)||empty($Comment)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("fullpost.php?id={$SearchQueryParameter}");
  }elseif (strlen($Comment)>500) {
    $_SESSION["ErrorMessage"]= "Comment length should be less than 500 characters";
    Redirect_to("fullpost.php?id={$SearchQueryParameter}");
  }else{
    // Query to insert comment in DB When everything is fine
    global $ConnectingDB;
    $sql  = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
    $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
    $stmt =$ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':name',$Name);
    $stmt->bindValue(':email',$Email);
    $stmt->bindValue(':comment',$Comment);
    $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
    $Execute=$stmt->execute();
    // var_dump($Execute);
    if($Execute){
      $_SESSION["SuccessMessage"]="Comment Submitted Successfully";
      Redirect_to("fullpost.php?id={$SearchQueryParameter}");
    }else {
      $_SESSION["ErrorMessage"]="Something went wrong. Try Again !";
      Redirect_to("fullpost.php?id={$SearchQueryParameter}");
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
						<button class="btn btn-warning" name="SearchButton">Go</button>
					</div>
				</form>
			</ul>
  </div>
</nav>
	<!-- NAVBAR-END --->
	<!-- HEADER --->
	<header >
		<div class="container">
			<div class="row mt-4 shadow-lg" style="background-color: #fff;">
				<!--MAIN-AREA-->
				<div class="col-lg-8">
					<?php
					echo ErrorMessage();
					echo SuccessMessage();
				?>
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
						}
						else {
							$PostIdFromUrl = $_GET["id"];
							if (empty($PostIdFromUrl)) {
								$_SESSION["ErrorMessage"]= "Bad Request !";
								Redirect_to("index.php");
							}
							if (!isset($PostIdFromUrl)) {
								$_SESSION["ErrorMessage"]= "Bad Request !";
								Redirect_to("index.php");
							}
							$sql = "SELECT * FROM posts WHERE id='$PostIdFromUrl' ";
						$stmt = $ConnectingDB->query($sql);
            $Result=$stmt->rowcount();
            if ($Result!=1) {
              $_SESSION["ErrorMessage"]="Bad Request!";
              Redirect_to("index.php?page=1");
            }
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

					<div class="card mt-4 border-0 ">
						<img src="uploads/<?php echo htmlentities($Image);?>" class="img-fluid card-img-top">
						<div class="card-body">
							<h1 class="card-title title-size"><?php echo htmlentities($PostTitle); ?></h1>
							<small class="text-muted" style="display:block;">Category: <span class="text-dark"> <a class="text-warning" href="index.php?category=<?php echo htmlentities($Category); ?>"> <?php echo htmlentities($Category); ?> </a></span> & Written by <span class="text-dark"> <a class="text-warning" href="adminprofile.php?username=<?php echo htmlentities($Admin); ?>"> <?php echo htmlentities($Admin); ?></a></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
							<span style="float: right;" class="badge badge-dark text-light">Comments 
								<?php echo ApproveCommentsAccordingtoPost($Id); ?>
							</span>
							<hr>
							<p class="card-text" style="text-align: justify;"><?php 	echo htmlentities($PostText); ?></p>
						</div>
					</div>
					<?php } ?>
					<!--FETCHING COMMENTS-->
					<span class="lead text-weight">Comments</span>
          			<br><br>
        			<?php
        			global $ConnectingDB;
        			$sql  = "SELECT * FROM comments
         			WHERE post_id='$SearchQueryParameter' AND status='ON'";
        			$stmt =$ConnectingDB->query($sql);
        			while ($DataRows = $stmt->fetch()) {
          			$CommentDate   = $DataRows['datetime'];
          			$CommenterName = $DataRows['name'];
          			$CommentContent= $DataRows['comment'];
        			?>
  					<div>
    				<div class="media CommentBlock">
              <img src="images/avatar.png" alt="reader" class="d-block img-fluid" width="50" height="50">
      				<div class="media-body ml-2">
        			<h6 class="lead text-weight"><?php echo $CommenterName; ?></h6>
        			<p class="small"><?php echo $CommentDate; ?></p>
        			<p><?php echo $CommentContent; ?></p>
      				</div>
    			</div>
  			</div>
  			<hr>
  <?php } ?>
  					<!--FETCHING COMMENTS-->
					<!--COMMENT-AREA-->
					<div>
            <form class="" action="fullpost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
              <div class="card mb-3">
                <div class="card-header">
                  <h5 class="FieldInfo">Share your thoughts about this post</h5>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                    <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                    <input class="form-control" type="text" name="CommenterEmail" placeholder="Email" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                  </div>
                  <div class="">
                    <button type="Submit" name="Submit" class="btn btn-warning text-white">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!--COMMENT-AREA-ENDED-->
				</div>
				<!--MAIN-AREA-END-->

				<!--SIDE-AREA-->
				<div class="col-sm-4">
          
          <!-- <div class="card">
            <div class="card-header bg-dark text-light">
              <h2 class="lead">Sign Up !</h2>
            </div>
            <div class="card-body">
              <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">Join the Forum</button>
              <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="" placeholder="Enter your email"value="">
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                </div>
              </div>
            </div>
          </div> -->
          <br>
          <div class="card">
            <div class="card-header bg-color text-light">
              <h2 class="lead">Categories</h2>
              </div>
              <div class="card-body">
                <?php
                global $ConnectingDB;
                $sql = "SELECT * FROM category ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
                while ($DataRows = $stmt->fetch()) {
                  $CategoryId = $DataRows["id"];
                  $CategoryName=$DataRows["title"];
                 ?>
                <a href="index.php?category=<?php echo $CategoryName; ?>" style="text-decoration: none;"> <span class="badge badge-dark text-light"> <?php echo $CategoryName; ?></span> </a><br>
               <?php } ?>
            </div>
          </div>
          <br>
          <div class="card border-0">
            <div class="card-header bg-color text-white">
              <h2 class="lead"> Recent Posts</h2>
            </div>
            <div class="card-body">
              <?php
              global $ConnectingDB;
              $sql= "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
              $stmt= $ConnectingDB->query($sql);
              while ($DataRows=$stmt->fetch()) {
                $Id     = $DataRows['id'];
                $Title  = $DataRows['title'];
                $DateTime = $DataRows['datetime'];
                $Image = $DataRows['image'];
              ?>
						<img src="uploads/<?php echo htmlentities($Image);?>" class="img-fluid card-img-top">
						
						<a href="fullpost.php?id=<?php echo $Id; ?>" style="text-decoration: none;" >	<h4 class="card-title title-size"><?php echo htmlentities($Title); ?></h4></a>
							<small class="text-muted" style="display: block" ><span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
							
						
              <hr>
              <?php } ?>
            </div>
          </div>

        </div>
				<!--SIDE-AREA-END-->
			</div>
		</div>
	</header>
	

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