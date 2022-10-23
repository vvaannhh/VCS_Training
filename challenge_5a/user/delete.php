<?php
require_once '../config/connect.php';
if(isset($_POST['delete'])){
    $id = $_POST['delete'];
    $sql = "DELETE FROM users WHERE id = '$id'";
    // echo $_POST['file'];
    $result = mysqli_query($conn, $sql);
    $file = 'avatars/'.$_POST['file'];
    if($result){
        if(file_exists($file)){
            unlink($file);
        }
        echo "<script>
                alert('Delete User Success!');
                window.location.href='list.php';
            </script>";
    }
    else{
        echo "<script>
                alert('Delete User Failed!');
                window.location.href='list.php';
            </script>";
    }
}
?>