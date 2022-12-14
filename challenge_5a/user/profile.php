<?php
    session_start();
    if(!isset($_SESSION['user'])) 
        header("Location: ../index.php");
    require_once '../config/connect.php';   
    if(isset($_POST['editBtn'])){
        $username = $_POST['editBtn'];
    }
    elseif(!isset($_POST['editBtn']) && isset($_SESSION['user'])){
        $username = $_SESSION['user'];
    }
    $query = "SELECT username,  password, fullname, email, phone, avatar from users where username = '$username'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_array($result);
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Infor</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'header.php';
    ?>
    <div class="container">
        <h3><center><br>Information</center></h3>
            <form action="update.php" method="post" enctype="multipart/form-data">
                <div class="text-center">
                    <img class="img-fluid rounded-circle" src="avatars/<?php echo $rows['avatar'];?>" style="width: 150px;height: 150px;" title="avatar">
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" id="username" class="form-control"  value="<?php echo $username;?>" readonly>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="text" name="password" id="password" class="form-control"  value="<?php echo $rows['password'];?>" >
                </div>
                <div class="form-group">
                  <label for="fillname">Fullname</label>
                  <input type="text" name="fullname" id="fullname" class="form-control"  value="<?php echo $rows['fullname'];?>" readonly>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" name="email" id="email" class="form-control"  value="<?php echo $rows['email'];?>" >
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" name="phone" id="phone" class="form-control"  value="<?php echo $rows['phone'];?>" >
                </div>
                <div class="form-group">
                  <label for="avatar">Avatar</label>
                  <input type="file" name="avatar" id="avatar" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
                <br><br>
            </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>