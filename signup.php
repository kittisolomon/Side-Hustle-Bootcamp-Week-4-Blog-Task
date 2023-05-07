<?php

include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));

$email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
$password = filter_var($data->password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$name = filter_var($data->username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$gender = filter_var($data->gender, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// $email= "real@admin.com";
// $password ="12345";
// $cpassword ="12345";
// $name="admin";
// $gender="male";


// if(!empty($email) && !empty($password) && !empty($cpassword) && !empty($name)
// && !empty($gender)){

    
if(!empty($data->email) && !empty($data->password)  && !empty($data->username)
 && !empty($data->gender)){
        
        $ck_email= "SELECT email FROM users WHERE email = '$email'";
        $chk= $db_con->query($ck_email);
        if (!$chk->num_rows>0){
           
                $md5pass = md5($password);
            
                $sql = 'INSERT INTO users (name,email,gender,password)
                 VALUES("'.$name.'","'.$email.'","'.$gender.'","'.$md5pass.'")';
            
               $result = mysqli_query($db_con, $sql);
        
                if($result){
                
                    $response = json_encode(['status'=>'success','message'=>'Registration Succesful.']);
                    echo $response;
                    return;
                
                }else{
                   
                    $response = json_encode(['status'=>'error','message'=>'Error Occured, Try Again!.']);
                    echo $response;
                    return;
                }
        }else{
            $response = json_encode(['status'=>'error','message'=>'email already exist, Try Again!.']);
                    echo $response;
                    return;
        }


}else{

 $response = json_encode(['status'=>'error','message'=>'Please Complete All Fields.']);

 echo $response;


}


?>