<?php
    session_start();
    require_once '../../config/connect.php';
    if(!isset($_SESSION['user'])) 
        header("Location: ../../index.php");
    if(isset($_POST['delete'])){
        $id=$_POST['delete'];
        $query="DELETE FROM game where id='$id'";
        
        $file=$_POST['file'];
        $file_path='ans/'.$file;
        if(mysqli_query($conn,$query)){
            if(file_exists($file_path))
            {
                unlink($file_path);
                $mess = "<h4 style='color: green;'>Delete Game Success!</h4>";
            }
        }
        else{
            $mess = "<h4 style='color: green;'>Delete Game Failed!</h4>";
        }

    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Game</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include "../header.php";?>
    <div class="container">
        <?php if($_SESSION['role']){ ?>
        <div class="row">
            <div class="col-md-2">
                <form action="upgame.php">
                    <button type="submit" class="btn btn-secondary">Add Game</button>
                </form>
            </div>
        </div>
       <?php } ?>
       <h3><center><b>List Game</b></center></h3>
       <?php if(isset($mess)){
            echo $mess;
        } ?> 
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Hint</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php   
                                $query = "SELECT * FROM game";
                                $games = $conn->query($query);
                                foreach($games as $game){
                                    echo "<td>".$game['title']."</td>";
                                    echo "<td>".$game['hint']."</td>";
                                    echo "<td>".$game['date']."</td>";
                                    echo "<td>";
                                    echo "<a href='play.php?id=".$game['id']."' class=\"btn btn-primary\" style=\"float: right;margin-right: 8px\">Play</a>";
                                    echo "<form action=\"\" method='post'><input type='hidden' name='file' value='".$game['file']."'><button type=\"submit\" class=\"btn btn-primary\" style=\"float: right;margin-right: 8px\" onclick='return confirm(\"Delete Game?\")' name='delete' value='".$game['id']."'>Delete</button></form>";
                                    echo "</td>";
                                }
                            ?>
                            </tr>

                        </tbody>    
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>