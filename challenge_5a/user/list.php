<?php
    session_start();
    if(!isset($_SESSION['user'])) 
        header("Location: ../index.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <title>List User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'header.php'; ?>
    <div class = "container">
        <?php if($_SESSION['role'])
            echo '<div class="row">
                <div class="col-md-2">
                    <form action="add.php">
                        <button type="submit" class="btn btn-secondary">Add User</button>
                    </form>
                </div>
            </div>';
    ?>
        <h3><center><b>List User</b></center></h3>
        <div class="row" style="margin-top: 20px">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    require_once '../config/connect.php';
                    $sql = "SELECT * FROM users";
                    $users = $conn->query($sql);
                    foreach($users as $user){
                        echo "<tr>";
                        echo"<td>".$user['username']."</td>";
                        echo"<td>".$user['fullname']."</td>";
                        echo"<td>".$user['email']."</td>";
                        echo"<td>".$user['phone']."</td>";
                        echo"<td>".$user['role']."</td>";
                        echo"<td>";
                        echo "<a href='chat.php?id=".$user['id']."'class='btn btn-primary' style='float: right;margin-right: 8px'>Chat</a>";
                        echo "<a href='detail.php?id=".$user['id']."'class='btn btn-primary' style='float: right;margin-right: 8px'>Detail</a>";
                        if($_SESSION['role']){
                            echo "<form action='profile.php' style='float: right;margin-right: 8px;' method='post'>
                                             <button type='submit' class='btn btn-primary' value='".$user['username']."'name='editBtn'>Edit</button>
                                           </form>";
                            echo "<form action='delete.php' style='float: right;margin-right: 8px;' method='post'>
                                    <input type='hidden' name='file' value='".$user['avatar']."'>
                                        <button type='submit' class='btn btn-primary' value='".$user['id']."' name='delete' onclick=\"return confirm('Delete User ".$user['username']."')\">Delete</button></form>"; 
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                        ?>

                    
                        
                    </tbody>
                </table>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>