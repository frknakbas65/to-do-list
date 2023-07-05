<?php

if(isset($_POST['id'])){
    require '../db_conn.php';

    $id = $_POST['id'];

    if(empty($id)){
        echo 'error';  
    }
    else {
        $stmt = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
        $stmt->execute([$id]);

        $todo = $stmt->fetch();
        $uId = $todo['id'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $stmt = $conn->prepare("UPDATE todos SET checked=? WHERE id=?");
        $res = $stmt->execute([$uChecked, $uId]);

        if($res){
            echo $uChecked;
        }
        else{
            echo "error";
        }

        $conn = null;
        exit();
    }
}
else {
    header("Location: ../index.php?mess=error");
}

?>
