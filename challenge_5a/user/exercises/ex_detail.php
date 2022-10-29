<?php 
  session_start();
  require_once '../../config/connect.php';
  if(!isset($_SESSION['user'])){
      header("Location: ../../index.php");
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
    <?php include '../header.php'; ?>
    <?php if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT * FROM submit WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_array($result);
        $content = file_get_contents("uploads/stu/".$rows['file']);
    }
    else header("Location: index.php");
    ?> 
       <div class="container">
           <h3><center><b><?php echo $rows['author'];?>'s Exercises</b></center></h3>
            <div class="col-sm-10">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" value="<?php echo $rows['title']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control" cols="50" rows="5" readonly><?php echo $content;?></textarea>
                </div>
                <a href="index.php" class="btn btn-primary">Back To List</a>
            </div>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>