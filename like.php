<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));

// $post_id = 8;

$post_id = filter_var($data->id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


$sql = "UPDATE post  SET likes = likes + 1 WHERE id ='$post_id'";
$result = $db_con->query($sql);

if($result){

    $response = ["status"=>"success","message"=>"post liked sucessful"];

    echo json_encode($response);

    return;
}else{
    $response = ["status"=>"error","message"=>"Unable to like post"];

    echo json_encode($response);
}
        

// Close the database connection
$db_con->close();


?>