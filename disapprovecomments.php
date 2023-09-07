<?php require_once("includes/DB.php");  ?>
<?php require_once("includes/Functions.php");  ?>
<?php require_once("includes/Sessions.php");  ?>
<?php Confirm_Login(); ?>

<?php  
	if(isset($_GET["id"])){
	  $SearchQueryParameter = $_GET["id"];
	  global $ConnectingDB;
	  $Admin = $_SESSION["UserName"];
	  $sql = "UPDATE comments SET status='OFF', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
	  $Execute = $ConnectingDB->query($sql);
	  if ($Execute) {
	    $_SESSION["SuccessMessage"]="Comment Dis-Approved Successfully ! ";
	    Redirect_to("comments.php");
	    // code...
	  }else {
	    $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again !";
	    Redirect_to("comments.php");
	  }
	}
?>