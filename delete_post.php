<?php
include 'function.php';
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));


$post_id = ($data->id);
$user_id = ($data->user_id);
 $chk = "SELECT * FROM post WHERE id ='$post_id' AND user_id = '$user_id'";
  $res =mysqli_query($db_con, $chk);
  
  if($res->num_rows>0){

    $sql = "DELETE FROM post WHERE id ='$post_id' AND user_id = '$user_id'";
    $result =mysqli_query($db_con, $sql);
    
    if ($result) {
      
        // Convert the array to JSON format
       $response = json_encode(['status'=>'success','message'=>'post successfully deleted.']);
        // Output the JSON data
        echo $response;
        return;
    }
    }else{
         $response = json_encode(['status'=>'error','message'=>'This post can only be deleted by author']);
       
            echo $response;
                return;
    }
  
  
  
// Close the database connection
$db_con->close();

?>