<?php
    session_start();
    require_once '../../config/connect.php';
    if(!$_SESSION['role']){
        header("Location: index.php");
        exit();
    }
    // echo $_POST['task'];
    // var_dump($_POST['task']);
    if(isset($_POST['task']) && isset($_FILES['file']['name'])){
      $filename = time()."_".basename($_FILES['file']['name']);
      $path_file = "uploads/task/".$filename;
      $file_tmp = $_FILES['file']['tmp_name'];
      $wb = ['txt', 'pdf', 'docx'];
      $ext = strtolower(pathinfo($path_file, PATHINFO_EXTENSION));
      $file_size = $_FILES['file']['size'];
      if($file_size > 10485760){
        $mess = "<h4 style='color: red;'>File is too big</h4>";
      }
      elseif($file_size <= 10485760 && in_array($ext,$wb)){
        if(move_uploaded_file($file_tmp, $path_file)){
          $teacherName = $_SESSION['user'];
          $title = $_POST['title'];
          $content = $_POST['content'];
          $query = "INSERT INTO exercises (author, title, content, filename) VALUE ('$teacherName', '$title', '$content', '$filename')";
          if(mysqli_query($conn, $query)){
            $mess = "<script>
                  alert('Upload Successfully');
                  window.location.href = 'index.php'
              </script>";
          }
          else  $mess = "<h4 style='color: red;'>Upload Failed</h4>";
        }
        else   $mess = "<h4 style='color: red;'>Upload Failed</h4>";
      } 
      else $mess="<h4 style='color: red;'>Just upload txt, pdf, docx</h4>";
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
    <?php include '../header.php';?>
    <div class="container">
      <h3><center>Add Task</center></h3>
      <?php if(isset($mess)) echo $mess; ?>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea name="content" id="content" class="form-control" cols="30" rows="10" ></textarea>
        </div>

        <div class="form-group">
          <label for="file">File</label>
          <input type="file" name="file" id="file" class="form-control" >
        </div>
        <button type="submit" name="task" class="btn btn-primary">Save</button>
      </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>