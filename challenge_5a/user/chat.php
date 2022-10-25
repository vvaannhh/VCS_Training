<?php
    require_once '../config/connect.php';
    session_start();
    if(isset($_GET['id']) && is_numeric($_GET['id']) && isset($_SESSION['user'])){
        $usersendId = $_SESSION['id'];
        $id = $_GET['id'];
        $query = "SELECT * FROM users WHERE id ='$id'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_array($result);
        if(isset($_POST['sendMess'])){
            $userrecvId = $id;
            $content = $_POST['message'];
            $author = $_SESSION['user'];
            $query = "INSERT INTO message (usersendId, userrecvId, content, author) VALUES('$usersendId', '$userrecvId', '$content', '$author')";
            if(mysqli_query($conn, $query)){
                $alert = "<h4 style='color: green'>Send Success!</h4>";
            }
            else{
                $alert = "<h4 style='color: green'>Send Failed!</h4>";
            }
        }
        elseif(isset($_POST['deleteBtn'])){
            $idDel = $_POST['deleteBtn'];
            $query = "DELETE FROM message WHERE id = $idDel";
            if(mysqli_query($conn, $query)){
                $messUpdate="<h4 style='color: green'>Delete Message Success!</h4>";
            }
            else{
                $messUpdate="<h4 style='color: red'>Delete Message Failed!</h4>";
            }
        }
        elseif(isset($_POST['updateBtn'])){
            $newMess = $_POST['newMess'];
            $idUpdate = $_POST['updateBtn'];
            $query = "UPDATE message SET content = '$newMess' WHERE id = '$idUpdate'";
            if(mysqli_query($conn, $query)){
                $messUpdate="<h4 style='color: green'>Update Message Success!</h4>";
            }
            else{
                $messUpdate="<h4 style='color: red'>Update Message Failed!</h4>";
            }
        }
    }   
    else{
        header('Location: list.php');
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Message</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include "header.php"; ?>
    <?php $sql = "SELECT * FROM message WHERE (userrecvId = '$id' AND usersendId = '$usersendId') OR (userrecvId = '$usersendId' AND usersendId = '$id') ORDER BY date";
    $messages = $conn->query($sql);
    ?>
    <div class="container">
        <h3><center>Send message to <?php echo $rows['username']; ?></center></h3>
        <div class="col-sm-12">
            <?php if (isset($messUpdate)) {
                    echo $messUpdate;
                }
            ?>
            <?php foreach($messages as $message){ ?>
                <br>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Author: <?php echo $message['author']; ?></label>
                        <textarea name='newMess' cols='30' rows='3' class='form-control'><?php echo $message['content'];?></textarea>
                    </div>
                    <?php if($message['author']==$_SESSION['user']){ ?>
                        <button type='submit' class='btn btn-primary' name='deleteBtn' value='<?php echo $message['id']; ?>' onclick=\"return confirm('Delete Message ?')\">Delete</button>
                        <button type='submit' class='btn btn-primary' name='updateBtn' value='<?php echo $message['id']; ?>'>Update</button>
                    <?php } ?>
                </form>
                <?php } ?>
                <br>
                <form action="" method='post'>
                        <div class='form-group'>
                            <label>Send Message</label>
                            <textarea name='message' cols="30" rows="3" class="form-control" required></textarea>
                            <?php
                            if(isset($alert)) echo $alert; ?>
                        </div>
                        <button type="submit" class="btn btn-success" name="sendMess" style="margin-bottom: 20px">Send</button>
                </form>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>