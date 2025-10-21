<?php
    header("Content-Type: application/json");
    //handle method
    if($_SERVER['REQUEST_METHOD']!=='GET')  {
        http_response_code (405);
        echo json_encode(["message"=>"Method not allowed"]);
        exit();
    }
    //include connection
    include_once("../conn.php");
    $user_id=$_GET['user_id'] ?? null;

    if($user_id) {
        //sql
        $sql="SELECT * FROM tbl_user WHERE user_id = :user_id";
        //prepare
        $stmt=$conn->prepare($sql);
        //bind
        $stmt->bindParam(':user_id', $user_id);
        //execute
        $stmt->execute();
        //fetch
        $items_quiz=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($items_quiz)===0)  {
            echo json_encode ([
                "success"=>false,
                "message"=>"No item found",
                "data"=> []
            ]);
            exit();
        }
        echo json_encode([
            "success"=>true,
            "message"=>"Item fetched successfully!",
            "data"=>$items_quiz
        ]);
    }else{
        //sql
        $sql="SELECT * FROM items ORDER BY id DESC";
        //prepare
        $stmt=$conn->prepare($sql);
        //execute
        $stmt->execute();
        //fetch
        $items_quiz=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($items_quiz)===0)  {
            echo json_encode([
                "success"=>false,
                "message"=>"No items found",
                "data"=>[]
            ]);
            exit();
        }
        echo json_encode([
            "success"=>true,
            "message"=>"Items fetched successfully",
            "data"=> $items_quiz
        ]);
    }
?>