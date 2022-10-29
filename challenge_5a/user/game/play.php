<?php
    session_start();
    require_once '../../config/connect.php';
    if(!isset($_SESSION['user'])){
        header("Location: ../../index.php");
    }$check=0;
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT * FROM game WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        $res = mysqli_fetch_array($result);
        if(isset($_POST['submit'])&&isset($_POST['answer'])){
            $answer=explode(".",$res['file']);
            if($answer[0]===$_POST['answer']){
                $check=1;
                $mess="<h4 style='color: green;'>Correct!</h4>";
            }
            else{
                $mess="<h4 style='color: red;'>Wrong Answer!</h4>";
            }
        }
    }
    else{
        header("Location: index.php");
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include "../header.php";?>
    <div class="container">
        <h3><center><b>Answer</b></center></h3>
        <div class="col-sm-12">
            <form action="" method="post">
                <div class="form-group">
                    <label>Title</label>
                    <?php echo '<input type="text" value="'.$res['title'].'" class="form-control" readonly>'; ?>
                </div>

                <div class="form-group">
                    <label>Hint</label>
                    <?php echo '<textarea cols="30" rows="5" class="form-control" readonly>'.$res['hint'].'</textarea>'; ?>
                </div>

                <?php 
                if($check){
                    $path="ans/".$res['file'];
                    $content=file_get_contents($path);
                    if (isset($mess)) {
                        echo $mess;
                    }
                    echo '<div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="5" class="form-control" readonly>'.$content.'</textarea></div>';
                    echo '<a href="index.php" class="btn btn-primary">Back To List</a>';
                } 
                else{
                    if(isset($mess)){
                        echo $mess;
                    }
                }
                ?>

                <div class="form-group">
                    <label for="">Answer</label>
                    <input type="text" name="answer" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>