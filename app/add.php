<?php

if(isset($_POST['title'])){
    require '../db_conn.php';

    $title= $_POST['title'];

    echo $title;
    if(empty($title)){
        header("Location: ../index.php?mess=error?");
    }
    else {
        $stmt = $conn->prepare("INSERT INTO todos(title) VALUE(?)");
        $res = $stmt->execute([$title]);

        if($res){
            header("Location: ../index.php");   
        }
        else {
            header("Location: ../index.php");

        }
        $conn = null;
        exit();
    }
}
else {
    header("Location: ../index.php?mess=error?");
}

