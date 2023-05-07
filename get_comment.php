<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));
// $post_id = 8;
$post_id = $_GET['id'];

if(!empty($post_id)){
    
    $ch_k='SELECT * FROM comments WHERE post_id ="'.$post_id.'"';
    $result = mysqli_query($db_con, $ch_k);
    if ($result->num_rows > 0) {
        while($row =  $result->fetch_assoc()) {
            $comment["comment_id"] = $row["id"];
            $comment["post_id"] = $row["post_id"];
            $comment["comment"] = $row["comment"];
            $comment["username"] = $row["name"];
            $comment["date"] = $row["date"];

            $all_comment["all_comment"][] = $comment;
        } $comments = $all_comment;
        $response = json_encode(['status'=>'success','message'=>$comments]);
        echo $response;
        return;
    } else {
        $response = json_encode(['status'=>'error','message'=>'no comment available']);
        echo $response;
                return;
    }
}else{
     $response = json_encode(['status'=>'error','message'=> 'empty post cannot have comment']);
    echo $response;
    return;
}
?>