<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));



    
    $ch_k='SELECT * FROM tags';
    $result = mysqli_query($db_con, $ch_k);
    if ($result->num_rows > 0) {
        while($row =  $result->fetch_assoc()) {
            $tag["id"] = $row["id"];
            $tag["tagname"] = $row["tagname"];
            $all_tag["all_tag"][] = $tag;
        } 
        $tags = $all_tag;
        $response = json_encode(['status'=>'success','message'=>$tags]);
        echo $response;
        return;
    } else {
        $response = json_encode(['status'=>'error','message'=>'no tags available']);
        echo $response;
                return;
    }

?>