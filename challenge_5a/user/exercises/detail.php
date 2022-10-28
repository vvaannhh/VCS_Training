<?php 
  session_start();
  include '../../config/connect.php';
  if(!isset($_SESSION['user'])){
      header("Location: ../../index.php");
  }
?>
<?php
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM exercises WHERE id='$id'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
  }
?>
<?php
  if(isset($_POST['delete'])){
    $id=$_POST['delete'];
    $sql = "delete from submit where id='$id'";
    if(mysqli_query($conn, $sql)){
      $mess = "<h4 style='color: green;'>Delete Successfully!</h4>";
    }
    else{
      $mess = "<h4 style='color: red;'>Delete Failed!</h4>";
    }
  }

  elseif(isset($_POST['add']) && isset($_FILES['file']['name'])){
    
    $wb=['txt', 'docs', 'pdf'];
    $filename=time().'_'.basename($_FILES['file']['name']);
    $path_file="uploads/stu/".$filename;
    $ext=strtolower(pathinfo($path_file,PATHINFO_EXTENSION));
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    if($file_size > 10485760){
      $mess = "<h4 style='color: red;'>File is too big</h4>";
    }
    elseif($file_size <= 10485760 && in_array($ext,$wb)){
      if(move_uploaded_file($file_tmp, $path_file)){
        $author = $_SESSION['user'];
        $title = $_POST['title'];
        $ex = $row['title'];
        $com = "INSERT INTO submit (title,author,exercise,file) VALUE ('$title','$author','$ex','$filename')";
        if(mysqli_query($conn, $com)){
          $mess = "<h4 style='color: green;'>File Saved Successfully!</h4>";
        }
        else{
          $mess = "<h4 style='color: red;'>File Save Failed!</h4>";
        }
      }
      else $mess = "<h4 style='color: red;'>File Save Failed!</h4>";
    }
    else $mess="<h4 style='color: red;'>Just upload txt, pdf, docx</h4>";
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Detail</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include '../header.php'; ?>
    <div class="container"> 
      <h3><center>Detail</center></h3>
      <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" value="<?php echo $row['title'] ?>" readonly>
      </div>

      <div class="form-group">
        <label>Content</label>
        <input type="text" class="form-control" value="<?php echo $row['content'] ?>" readonly>
      </div>

      <div class="form-group">
        <label>File</label>
        <a href="download.php?file=<?php echo $row['filename']?>">Download</a>
      </div>
      <br>
      <?php if($_SESSION['role']==0){ ?>
          <h3><center>Submit</center></h3>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
              <label>File</label>
              <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add">Submit</button>
          </form>
      <?php } 
        else{
      ?>
      <h3><center>List Submit</center></h3>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Student</th>
              <th>Title</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $name = $row['title'];
              $sql = "SELECT * FROM submit WHERE exercise = '$name'";
              $results = $conn->query($sql);
              foreach($results as $res){
                echo "<tr>";
                echo "<td>".$res['author']."</td>";
                echo "<td>".$res['title']."</td>";
                echo "<td>".$res['date']."</td>";
                echo "<td>
                        <a href='detailSubmit.php?id=".$res['id']."' class='btn btn-primary' style='float: right;margin-right: 8px'>Detail</a>
                        <form action='' method='post'>
                            <button type='submit' class='btn btn-primary' style='float: right;margin-right: 8px' onclick=\"return confirm('Delete Submit ?')\" name='delete' value='".$res['id']."'>Delete</button>
                        </form>
                      </td>";
                    echo "</tr>";
                }
            ?>
          </tbody>
        </table>
      </div>
      <?php 
        if(isset($mess)){
          echo $mess;
        }
      }?>
    </div>   
    <!--  Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>