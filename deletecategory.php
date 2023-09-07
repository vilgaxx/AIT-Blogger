<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php Confirm_Login(); ?>

<?php  
	if(isset($_GET["id"])){
	  $SearchQueryParameter = $_GET["id"];
	  global $ConnectingDB;
	  $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
	  $Execute = $ConnectingDB->query($sql);
	  if ($Execute) {
	    $_SESSION["SuccessMessage"]="Category deleted Successfully ! ";
	    Redirect_to("categories.php");
	    // code...
	  }else {
	    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	    Redirect_to("categories.php");
	  }
	}
?>