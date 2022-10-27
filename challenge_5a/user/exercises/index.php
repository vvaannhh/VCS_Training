<?php
    session_start();
    include '../../config/connect.php';
    if(!isset($_SESSION['user'])){
        header("Location: ../../index.php");
    }
    $query = "SELECT * FROM exercises";
    $exercises = $conn->query($query);
    if(isset($_POST['delete'])){
        $id = $_POST['delete'];;
        $filename = $_POST['filename'];
        $path_file = 'uploads/task/'.$filename;
        $query = "DELETE FROM exercises WHERE id = '$id'";
        if(mysqli_query($conn, $query) && file_exists($path_file)){
            unlink($path_file);
            $alert = "<script>
                alert('Delete Exercise Successfully!');
                window.location.href = 'index.php'
            </script>";
        }
        else{
            $alert = "<script>
                alert('Delete Exercise Failed!');
                window.location.href = 'index.php'
            </script>";
        }   
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Exercises</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include "../header.php"; ?>
    <div class="container">
    <?php
        if($_SESSION['role']) {
            echo '<div class="row">
                <div class="col-md-2">
                    <form action="addex.php">
                        <button class= "btn btn-secondary" type="submit">Add Exercises</button>
                    </form>
                </div>
            </div>';
        }
        ?>
        <h3><center><b>List Exercise</b></center></h3>
        <div class="row" style="margin-top: 20px">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Title</td>
                            <td>Author</td>
                            <td>Date</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($exercises as $ex){
                            echo "<tr>";
                                echo "<td>".$ex['title']."</td>";
                                echo "<td>".$ex['author']."</td>";
                                echo "<td>".$ex['date']."</td>";
                                echo "<td>
                                    <a href='detail.php?id=".$ex['id']."' class='btn btn-primary' style='float: right;margin-left: 8px;'>Detail</a>";
                                    if($_SESSION['role']){
                                        echo "<form action='' method='post'>
                                            <input type='hidden' name='filename' value='".$ex['filename']."'>
                                            <button type='submit' class='btn btn-primary' name='delete' value='".$ex['id']."' style='float: right;margin-right: 8px;' onclick=\'return confirm('Delete".$ex['title'].")\'>Delete</button>
                                            </form>"; 
                                        } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if(isset($alert)){ 
                    echo $alert;
                }
                ?>
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