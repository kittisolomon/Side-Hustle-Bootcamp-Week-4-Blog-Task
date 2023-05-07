<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));

// $user_id = "1";
// $post_id="2";
//     $blog_title= "Agile ";
//     $body =" down to Agile vs. Waterfall. This blog post will cover the differences between Agile and Waterfall, including:\r\n1)Project structure
// \r\n2)Approach to planning and development
// \r\n3)Flexibility and adaptability
// \r\n4)Communication and collaboration
// \r\n5)Timeframes and milestones";
// $tags="project_management";


$user_id = filter_var($data->user_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$post_id = filter_var($data->post_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$blog_title = filter_var($data->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$body= filter_var($data->value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tags= filter_var($data->tag, FILTER_SANITIZE_FULL_SPECIAL_CHARS);



if(!empty($user_id) && !empty($blog_title) && !empty($body) && !empty($tags) && !empty($post_id)){
    $ch_k="SELECT * FROM post WHERE id ='$post_id' AND user_id = '$user_id'";
    $resul = mysqli_query($db_con, $ch_k);
    if($resul->num_rows>0){
        $row = $resul->fetch_array();
        $id = $row['id'];
        $user_id =$row['user_id'];
        if($user_id === $user_id && $post_id ===$id ){
            $sql = "UPDATE post  SET body = '$body', blog_title = '$blog_title',  tags = '$tags'
            WHERE id ='$post_id' AND user_id = '$user_id'";
            $result = $db_con->query($sql);

            if($result){
            
                $response = ["status"=>"success","message"=>"Update Sucessful"];
            
                echo json_encode($response);
            
                return;
            }else{
                $response = ["status"=>"error","message"=>"Update Failed"];
            
                echo json_encode($response);
            }
        }else{
            $response = json_encode(['status'=>'error','message'=> 'this post can only be edited by the author only']);
            echo $response;
            return;
         }
    }else{
        $response = json_encode(['status'=>'error','message'=> 'Invalid login details']);
        echo $response;
        return;
    }

}else{
     $response = json_encode(['status'=>'error','message'=> 'please input all fields']);
    echo $response;
    return;
}

// Close the database connection
$db_con->close();


?>