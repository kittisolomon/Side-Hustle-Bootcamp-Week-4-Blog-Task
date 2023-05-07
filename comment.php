<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));

// $user_id = "1";
// $post_id="2";
//     $comment= "Agile vs. Waterfall: Choosing the Right Project Management Methodology";
//     $name ="adeola";

$user_id= filter_var($data->user_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$post_id = filter_var($data->id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$comment = filter_var($data->comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$dateTime = new DateTime('now', new DateTimeZone('Africa/Lagos')); 
$time=$dateTime->format("d-M-y  h:i A");

if(!empty($user_id)){
    $chk="SELECT name FROM users WHERE id='$user_id'";
    $res = mysqli_query($db_con, $chk);
    if($res->num_rows>0){
        $ro =$res->fetch_array();
         $name =$ro[0];
        if(!empty($post_id) && !empty($comment)){
           
                $sql = 'INSERT INTO comments (post_id, comment, name, date) VALUES("'.$post_id.'","'.$comment.'", "'.$name.'", "'.$time.'")';
                $result = mysqli_query($db_con, $sql); 
                if($result){
                
                    $response = ["status"=>"success","message"=>"comment successfully added"];
                
                    echo json_encode($response);
                
                    return;
                }else{
                    $response = ["status"=>"error","message"=>"unable to add comment"];
                
                    echo json_encode($response);
                }
        }else{
             $response = json_encode(['status'=>'error','message'=> 'comment cannot be empty']);
            echo $response;
            return;
        }

    }else{
        $response = json_encode(['status'=>'error','message'=> 'Invalid login details, contact admin']);
        echo $response;
        return;
    }

}else{
    $response = json_encode(['status'=>'error','message'=> 'please login to comment']);
        echo $response;
        return;
}
// Close the database connection
$db_con->close();


?>