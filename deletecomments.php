<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php Confirm_Login(); ?>

<?php  
	if(isset($_GET["id"])){
	  $SearchQueryParameter = $_GET["id"];
	  global $ConnectingDB;
	  $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
	  $Execute = $ConnectingDB->query($sql);
	  if ($Execute) {
	    $_SESSION["SuccessMessage"]="Comment deleted Successfully ! ";
	    Redirect_to("comments.php");
	    // code...
	  }else {
	    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	    Redirect_to("comments.php");
	  }
	}
?>