<?php session_start();
if(isset($_SESSION['user'])){
    session_destroy();
    session_unset();
}
// var_dump($_SESSION['user']);
    
    require_once 'config/connect.php';
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = sprintf("SELECT * FROM users WHERE username = '%s' AND password = '%s';", 
            mysqli_real_escape_string($conn, $username), 
            mysqli_real_escape_string($conn, $password));
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
            $rows = mysqli_fetch_array($result);
            // var_dump($rows);
            $_SESSION['user'] = $rows['username'];
            $_SESSION['role'] = $rows['role'];
            $_SESSION['id'] = $rows['id'];
            header("Location: user/index.php");
        }
        else $mess="<h4 style='color: red'>Wrong username or password</h4>";
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css" type="text/css"/>
  </head>
  <body>
    <div class="container">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                        <button class="btn btn-primary" type="submit" name="">Login</button>
                        <br><br><?php if(isset($mess)) echo $mess;?>
                    </form>
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