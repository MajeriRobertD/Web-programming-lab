<?php

$connect = mysqli_connect("localhost", "root", "", "labphp");  

$record_per_page = 4;
$page = '';
$output = '';

if(isset($_POST["page"])) {  
     $page = $_POST["page"];  
}
else  {  
      $page = 1;  
 } 

 $start_from = ($page - 1)*$record_per_page;  


 if(isset($_POST["the_id"]))  
 {  
      if($_POST["the_id"] != '')  
      {  
        $sql = "SELECT myurl.value, myurl.description FROM myurl inner join url_category on myurl.id = url_category.url_id inner join category on url_category.category_id = category.id WHERE category.id = '".$_POST["the_id"]."' ORDER BY myurl.id DESC LIMIT $start_from, $record_per_page";  
    }  
      else  
      {  
           $sql = "SELECT * FROM myurl ORDER BY id DESC LIMIT $start_from, $record_per_page";  
      }  
      $result = mysqli_query($connect, $sql) or die( mysqli_error($connect));  

      $output .= "  
      <table class='table table-bordered'>  
           <tr>  
                <th width='50%'>URL</th>  
                <th width='50%'>Description</th>  
           </tr>  
 ";  

 while($row = mysqli_fetch_array($result))  
 {  
      $output .= '  
           <tr>  
                <td>'.$row["value"].'</td>  
                <td>'.$row["description"].'</td>  
           </tr>  
      ';  
 }
 $output .= '</table><br /><div class="" align="center">';  









 if($_POST["the_id"] != '')  
 {  
     
    $page_query = "SELECT myurl.value, myurl.description FROM myurl inner join url_category on myurl.id = url_category.url_id inner join category on url_category.category_id = category.id WHERE category.id = '".$_POST["the_id"]."' ORDER BY myurl.id DESC";  
}  
 else  
 {  
      $page_query = "SELECT  myurl.value, myurl.description FROM myurl ORDER BY id DESC";  
 }  



//  $page_query = "SELECT myurl.value, myurl.description FROM myurl inner join url_category on myurl.id = url_category.url_id inner join category on url_category.category_id = category.id WHERE category.id = '".$_POST["id"]."' ORDER BY myurl.id DESC";  
 $page_result = mysqli_query($connect, $page_query);  

 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  
 for($i=1; $i<=$total_pages; $i++)  
 {  
      $output .= "<span class='pagination_link btn btn-primary custom-btn' style='cursor:pointer; padding:10px; border:1px solid #ccc; border-radius:25px;' id='".$i."'>".$i."</span>";  
 }  
 
 $output .= '</div><br /><br />';  
 echo $output; 
     
 }  

?>