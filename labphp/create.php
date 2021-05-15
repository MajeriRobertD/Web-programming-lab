<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id = $value = $description = $cat_id = $cat_name ="";
$id_err = $value_err = $description_err = $cat_id_err = $cat_name_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate id
    $input_id = trim($_POST["id"]);
    if(empty($input_id)){
        $id_err = "Please enter a id.";
    }
    elseif(!ctype_digit($input_id)){
        $id_err = "Please enter a positive integer value.";
    } else{
        $id = $input_id;
    }
   
    
    // Validate url value
    $input_value = trim($_POST["value"]);
    if(empty($input_value)){
        $value_err = "Please enter an url value.";     
    } else{
        $value = $input_value;
    }
    
    // Validate descrioptiopn
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter a description";
    } elseif(!filter_var($input_description, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $description_err = "Please enter a valid descriptiopn.";
    } else{
        $description = $input_description;
    }
    
    //category id validation
    $input_cat_id = trim($_POST["cat_id"]);
    if(empty($input_cat_id)){
        $id_err = "Please enter a category id.";
    }
    elseif(!ctype_digit($input_cat_id)){
        $cat_id_err = "Please enter a positive integer value.";
    } else{
        $cat_id = $input_cat_id;
    }
    // Validate descrioptiopn
    $input_cat_name = trim($_POST["cat_name"]);
    if(empty($input_cat_name)){
        $cat_name_err = "Please enter a category name";
    } elseif(!filter_var($input_cat_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $cat_name_err = "Please enter a calid cateogry name.";
    } else{
        $cat_name = $input_cat_name;
    }
    
    
    // Check input errors before inserting in database
    if(empty($id_err) && empty($value_err) && empty($description_err) && empty($cat_id_err && empty($cat_name_err))){
        // Prepare an insert statement
        $sql = "INSERT INTO myurl (id, value, description) VALUES (?, ?, ?)";
        $sql2 = "INSERT IGNORE INTO category (id, name) VALUES (?, ?)";
        $sql3 = "INSERT INTO url_category (url_id, category_id) VALUES (?, ?)";
        
         
        if($stmt = mysqli_prepare($link, $sql) ){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_id, $param_value, $param_description);
            
            // Set parameters
            $param_id = $id;
            $param_value = $value;
            $param_description = $description;
          
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt) ){
                // Records created successfully. Redirect to landing page
                echo "Url added";
               
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        else {
            
            echo "Something's wrong with the query: " . mysqli_error($link);
        }
         
        // Close statement
        mysqli_stmt_close($stmt);

        if($stmt2 = mysqli_prepare($link, $sql2) ){
            mysqli_stmt_bind_param($stmt2, "ss",  $param_cat_id, $param_cat_name);

            $param_cat_id = $cat_id;
            $param_cat_name = $cat_name;


            if(mysqli_stmt_execute($stmt2)){
                // Records created successfully. Redirect to landing page
                echo "Category added";
            
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

        }else {
            
            echo "Something's wrong with the query: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt2);

        //third statement
        if($stmt3 = mysqli_prepare($link, $sql3) ){
            mysqli_stmt_bind_param($stmt3, "ss", $param_id, $param_cat_id );

            $param_id = $id;
            $param_cat_id = $cat_id;

            if(mysqli_stmt_execute($stmt3)){
                // Records created successfully. Redirect to landing page
                echo "URL-category added";
                header("location: profile.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

        }else {
            
            echo "Something's wrong with the query: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt3);


    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
      <a href="profile.php" >Profile</a>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add new url record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Id</label>
                            <input type="text" name="id" class="form-control <?php echo (!empty($id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id; ?>">
                            <span class="invalid-feedback"><?php echo $id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <textarea name="value" class="form-control <?php echo (!empty($value_err)) ? 'is-invalid' : ''; ?>"><?php echo $value; ?></textarea>
                            <span class="invalid-feedback"><?php echo $value_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $description; ?>">
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Category id</label>
                            <input type="text" name="cat_id" class="form-control <?php echo (!empty($cat_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cat_id; ?>">
                            <span class="invalid-feedback"><?php echo $cat_id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Category name</label>
                            <input type="text" name="cat_name" class="form-control <?php echo (!empty($cat_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cat_name; ?>">
                            <span class="invalid-feedback"><?php echo $cat_name_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>