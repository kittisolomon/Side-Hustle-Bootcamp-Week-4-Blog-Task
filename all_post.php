<?php
include "function.php";
require "db_con.php";
 
$sql = "SELECT * FROM post ORDER BY date_publish DESC";
$result =mysqli_query($db_con, $sql);


if ($result->num_rows > 0) {
    while($row =  $result->fetch_assoc()) {
        
        $blog["post_id"] = $row["id"];
        $user_id = $row["user_id"];
        $blog["user_id"] = $user_id;
        $blog["blog_title"] = $row["blog_title"];
        $blog["body"] = $row["body"];
        $blog["tags"] = $row["tags"];
        $blog["date_publish"] = $row["date_publish"];
        // $blog["blog_picture"] = $row["blog_picture"];
        $blog["likes"] = $row["likes"];
        $name = mysqli_query($db_con, "SELECT * FROM users WHERE id=$user_id");
        $ro =  $name->fetch_assoc();
         $blog["author_name"] = $ro["name"];
        $all_blog["all_post"][] = $blog;
        
        
    }
    $blogs = $all_blog;
    $response = json_encode(['status'=>'success','message'=>$blogs]);
    echo $response;
            return;
} else {
    $response = json_encode(['status'=>'error','message'=>'no blog post available']);
    echo $response;
            return;
}

// Close the database connection
$db_con->close();



?>