<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}



$connect = mysqli_connect("localhost", "root", "", "labphp");  
 function fill_category($connect)  
 {  
      $output = '';  
      $sql = "SELECT * FROM category";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';  
      }  
      return $output;  
 }  

 function fill_url($connect)  
 {  
      $output = '';  
      $sql = "SELECT * FROM myurl";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '<div class="col-md-3">';  
           $output .= '<div style="border:1px solid #ccc; border-radius:50%; padding:20px; margin-bottom:20px;">'.$row["value"].' <br /><br/>'.$row["description"].'';  
           $output .=     '</div>';  
           $output .=     '</div>';  
      }  
      return $output;  
 }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
    <script src="jquery-3.6.0.min.js"> </script>
    <script type="text/javascript" src="script.js"></script>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <style>
        body{ font: 14px sans-serif; text-align: center; }


    </style>
  
</head>
<body>
<div class="topnav" id="myTopnav">
      <a href="welcome.php" >Home</a>
      <a href="profile.php" ><?php echo htmlspecialchars($_SESSION["username"]); ?>'s Profile</a>
        <a href="logout.php" >Sign Out</a>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
    </div>

    <br /><br/>
<div class="container">


<h1 class="my-5">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Here are your URLs.</h1>
    

  <h3>
    <select name ="category" id="category">   
      <option value=""> Show all categories </option>
      <?php  echo fill_category($connect); ?>
</select>
<br /><br/>

<div  class="table-responsive" id="pagination_data">

</div>

</h3>


</div>

</body>
</html>

<script>




$(document).ready(function () {
  $("#category").change(function () {
    var the_id = $(this).val();
    load_data(1,the_id);
  });
    load_data();  
      function load_data(page, the_id='')  
      {  
           $.ajax({  
                url:"pagination.php",  
                method:"POST",  
                data:{page:page, the_id: the_id},  
                success:function(data){  
                     $('#pagination_data').html(data);  
                }  
           })  
      }  
      $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id"); 
           var the_id = $('#category').val(); 
           load_data(page,the_id); 
      });  

          
 
});

  </script>

