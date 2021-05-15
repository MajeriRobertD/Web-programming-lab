<?php



// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}




// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql2 = "DELETE FROM url_category WHERE url_id = ?";
    $sql = "DELETE FROM myurl WHERE id = ?";

    if($stmt2 = mysqli_prepare($link, $sql2)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt2, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt2)){
            // Records deleted successfully. Redirect to landing page
            echo "deleted from url_category";
            
        } else{
            echo "Oops! Something went wrong. Please try again later." . mysqli_error($link);
        }
    }
   
    // Close statement
    mysqli_stmt_close($stmt2);







    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: profile.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later." . mysqli_error($link);
        }
    }
   
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
    <script type="text/javascript" src="script.js"></script>
    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topnav" id="myTopnav">
      <a href="welcome.php" >Home</a>
      <a href="profile.php" ><?php echo htmlspecialchars($_SESSION["username"]); ?>'s Profile</a>
      <a href="reset-password.php" >Reset Your Password</a>
        <a href="logout.php" >Sign Out</a>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value='<?php echo trim($_GET["id"]);?>'/>
                            <p>Are you sure you want to delete this Url record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="profile.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>