<?php
require 'function.php';
require 'db_con.php';

$data = json_decode(file_get_contents('php://input'));

$post_id = filter_var($data->id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$user_id = filter_var($data->user_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$count = filter_var($data->count, FILTER_SANITIZE_FULL_SPECIAL_CHARS);



if($count === 1){

$check = " SELECT * FROM likes WHERE post_id ='$post_id' ";

$res = $db_con->query($check);

if($res->num_rows === 0){

    $likePost = " INSERT INTO likes (post_id, like_count) VALUES ('$post_id','$count') ";

    $result = $db_con->query($likePost);

    if($result){
     echo   $response = json_encode(["status"=>"success","message"=>"Post liked"]);
    }

}else{

    $updatePost = " UPDATE likes SET like_count = like_count + 1 WHERE post_id = '$post_id' ";

    $res1 = $db_con->query($updatePost);

    if($res1){
     echo   $response = json_encode(["status"=>"success","message"=>"Post liked"]);
    }

}

}elseif($count === 0){
   
    $check1 = " SELECT * FROM likes WHERE post_id ='$post_id' ";

   $rest = $db_con->query($check1);

   if($rest->num_rows > 0){

    $update_post = " UPDATE likes SET like_count = like_count - 1 WHERE post_id = '$post_id' ";

    $res2 = $db_con->query($update_post);

    if($res2){
        echo   $response = json_encode(["status"=>"success","message"=>"Post disliked"]);
    }

   }
}



?>
