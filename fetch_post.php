<?php   
require "function.php";
require "db_con.php";

$data = json_decode(file_get_contents("php://input"));

// $id=8;
$id= $_GET['id'];
// $id = $data->id;

$sql = "SELECT * FROM post WHERE id = '$id'";
$result = $db_con->query($sql);

if($result->num_rows>0){

 while($row = $result->fetch_assoc()){
       $user_id = $row["user_id"];
       
    $view_json["post_id"] = $row["id"];
    $view_json["user_id"] = $row["user_id"];
    $view_json["blog_title"] = $row["blog_title"];

    $view_json["body"] = $row["body"];

        $view_json["tags"] = $row["tags"];

    $view_json["date_publish"] = $row["date_publish"];

    $view_json["blog_picture"] = $row["blog_picture"];

    $view_json["likes"] = $row["likes"];
     $name = mysqli_query($db_con, "SELECT * FROM users WHERE id=$user_id");
        $ro =  $name->fetch_assoc();
         $view_json["author_name"] = $ro["name"];

    $post_details["post"][] = $view_json;

    $response = ["status"=>"success","fetch_post"=>$post_details];
    echo json_encode($response);
    return;
    }

  }else{
    
      $response = ["status"=>"error","message"=>"Could not fetch Post Details"];
      echo json_encode($response);
  }  


// Close the database connection
$db_con->close();

?>