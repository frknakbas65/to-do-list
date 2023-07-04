<?php   
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
    <div class="main-section">
        <div class= "add-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                    <input type="text" name="title" style="border-color: #ff6666"placeholder="doldurunuz" />
                <button type="submit">Ekle &nbsp; <span>&#43;</span></button>
                <?php } else{ ?>    
                <input type="text" name="title" placeholder="Ne yapman lazım?" />
                <button type="submit">Ekle &nbsp; <span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php
            $todos= $conn->query("SELECT * FROM todos ORDER BY id DESC")
        ?>
        <div class="show-todo-section">
            <?php if($todos->rowCount()<=0) {?>
            <div class="todo-item"></div>
               <div class="empty"> <img src="" alt=""></div>
            </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) {?>
            <div class="todo-item"></div>
            <span id="<?php echo $todo['id'];?>" class="remove-to-do">x</span>
                <?php if($todo['checked']){ ?>
                    <input type="checkbox"
                            class="check-box"
                            data-todo-id ="<?php echo $todo['id']; ?>"
                            checked />
                    <h2 class="checked"><?php echo $todo['title']?></h2>
                   
                <?php } else { ?>
                    <input type="checkbox"
                            data-todo-id ="<?php echo $todo['id']; ?>"
                            class="check-box">
                    <h2><?php echo $todo['title']?></h2>
                <?php } ?>  
                <br>
                <small><?php echo $todo['date_time']?> tarihinde eklendi</small>
            </div>
            <?php } ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>                   
    <script> 
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php"),
                {
                    id :id
                },

                (data) => {

                    if(data){
                    $(this).parent().hide(600);
                    }
                }

                $(".check-box").click(function(){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php',
                        {
                            id: id
                        },
                        (data) => {
                            if(data != 'error'){
                                    const h2= $(this).next();
                                    if(data === '1'){
                                        h2.removeClass('checked');
                                    }
                                    else {
                                        h2.addClass('checked');
                                    }
                            }
                        }

                    );
                });
            });

        });
    </script>
</body>
</html>