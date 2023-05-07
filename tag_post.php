<?php
include "function.php";
require "db_con.php";
 
$data = json_decode(file_get_contents('php://input'));

// $tags = "science";
$tags =$_GET['tag'];
// $tags= filter_var($data->tag, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$sql = "SELECT * FROM `post` WHERE tags LIKE '%$tags%' ORDER BY date_publish DESC";
$result =mysqli_query($db_con, $sql);

if ($result->num_rows > 0) {
    while($row =  $result->fetch_assoc()) {
        $blog["post_id"] = $row["id"];
         $user_id = $row["user_id"];
        $blog["blog_title"] = $row["blog_title"];
        $blog["body"] = $row["body"];
        $blog["tags"] = $row["tags"];
        $blog["date_publish"] = $row["date_publish"];
        $blog["blog_picture"] = $row["blog_picture"];
        $blog["likes"] = $row["likes"];
        $name = mysqli_query($db_con, "SELECT * FROM users WHERE id=$user_id");
        $ro =  $name->fetch_assoc();
         $blog["author_name"] = $ro["name"];
        $all_blog["all_tag"][] = $blog;
        
        
    }
    $tags = $all_blog;
    $response = json_encode(['status'=>'success','message'=>$tags]);
    echo $response;
            return;
} else {
     $error = mysqli_error($db_con);
    $response = json_encode(['status'=>'error','message'=>"no blog post available for this tag: $error"]);
    echo $response;
            return;
}

// Close the database connection
$db_con->close();



?>