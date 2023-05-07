<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));


// $user_id = filter_var($data->user_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$blog_title = filter_var($data->title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$body= filter_var($data->value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tags= filter_var($data->tag, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user_id =1;
// $blog_title= "Agile vs. Waterfall: Choosing the Right Project Management Methodology";
//     $body ="Choosing the right project management methodology can be challenging, and it often comes down to Agile vs. Waterfall. This blog post will cover the differences between Agile and Waterfall, including:\r\n1)Project structure
// \r\n2)Approach to planning and development
// \r\n3)Flexibility and adaptability
// \r\n4)Communication and collaboration
// \r\n5)Timeframes and milestones";
// $tags="project_management";
if(!empty($user_id) && !empty($blog_title) && !empty($body) && !empty($tags)){

    $dateTime = new DateTime('now', new DateTimeZone('Africa/Lagos')); 
    $time=$dateTime->format("d-M-y  h:i A");
    $likes = 0;

    $allowed_ext = ['png', 'jpeg', 'gif', 'jpg'];
    $allowed_size = 2000000;

    // extract file information from request data
    $filename = $data->picture->name;
    $file_size = $data->picture->size;
    $file_tmp = $data->picture->tmp_name;
    $target_dir = "/images/" . $filename;

    // get file extension
    $file_ext = explode('.', $filename);
    $file_ext = strtolower(end($file_ext));

    // validate uploaded file
    // if (in_array($file_ext, $allowed_ext)) {
        // validate file upload size
        if ($file_size <= $allowed_size) {
            // check if file exists already
            // if (file_exists($target_dir)) {
            //     $response = json_encode(['status'=>'error','message'=> 'File already uploaded.']);
            //     echo $response;
            //     exit();
            // } else {
                // move uploaded file to target directory
                if (move_uploaded_file($file_tmp, $target_dir)) {

                            $sql = 'INSERT INTO post (id, user_id, blog_title, body, tags, date_publish, picture, likes) 
                            VALUES("", "'.$user_id.'", "'.$blog_title.'", "'.$body.'", "'.$tags.'", "'.$time.'", "'.$filename.'", '.$likes.')';

                            if($db_con->query($sql)){
                                // success case
                                $response = json_encode(['status'=>'success','message'=> 'Blog Post Created']);
                                echo $response;
                                return;
                            }else{
                                // handle SQL query error
                                $response = json_encode(['status'=>'error','message'=> 'Could not create blog']);
                                echo $response;
                                return;
                            }

                } else {
                    // handle file upload error
                    $response = json_encode(['status'=>'error','message'=> 'File upload failed.']);
                    echo $response;
                }
            // }

        } else {
            // handle file size error
            $response = json_encode(['status'=>'error','message'=> 'The file is too large. Maximum allowed size is 2MB.']);
            echo $response;
        }
    // } else {
    //     // handle invalid file type error
    //     $allowed_types = implode(', ', $allowed_ext);
    //     $response = json_encode(['status'=>'error','message'=> "Invalid file type. Allowed types: {$allowed_types}."]);
    //     echo $response;
    // }

}else{
     // handle empty field error
    $response = json_encode(['status'=>'error','message'=> 'Please input all fields']);
    echo $response;
}
?>


