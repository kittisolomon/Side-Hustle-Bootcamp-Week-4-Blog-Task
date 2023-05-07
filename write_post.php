<?php
include "function.php";
require "db_con.php";
// $data = json_decode(file_get_contents('php://input'));

$user_id = $_GET['user_id'];



if (!isset($_POST['title'], $_POST['value'], $_POST['tag'] )) {
    http_response_code(400);
    echo $response = json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
  }
    
    // Sanitize form data
    $blog_title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['value'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tags = filter_var($_POST['tag'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $date_publish = filter_var($_POST['date_publish'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $likes = 0;
  
    // Handle file uploads
    $picture = $_FILES['picture'];
  
    // Validate file types and sizes, and move uploaded files to a permanent location
   
    $allowed_picture_types = array('image/jpeg', 'image/png');
    $max_file_size = 3000000; //  MB
 
    if(in_array($picture['type'], $allowed_picture_types) && $picture['size'] <= $max_file_size) {
        $picture_file_name = $picture['name'];
        $picture_file_path = 'images/' . $picture_file_name;
        move_uploaded_file($picture['tmp_name'], $picture_file_path);
    } else {
            http_response_code(400);
            echo $response = json_encode(['status' => 'error', 'message' => 'Invalid image, or image is > 3MB']);
            exit;
      }

            $dateTime = new DateTime('now', new DateTimeZone('Africa/Lagos')); 
            $time=$dateTime->format("d-M-y  h:i A");
            $likes = 0;
                
   
    
            $sql = 'INSERT INTO post ( user_id, blog_title, body, tags, date_publish, picture, likes) 
            VALUES( "'.$user_id.'", "'.$blog_title.'", "'.$body.'", "'.$tags.'", "'.$time.'", "'.$picture_file_path.'", '.$likes.')';
        
            $result = mysqli_query($db_con, $sql);
            if($result){
                $response = json_encode(['status'=>'success','message'=> 'Blog Post Created']);
                echo $response;
                return;
        
            }else{
        
                $response = json_encode(['status'=>'error','message'=> 'Could not create blog']);
                echo $response;
                return;
        
           }
      


$db_con->close();
?>