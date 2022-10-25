<?php
    session_start();
    require_once '../config/connect.php';
    if(!$_SESSION['role']){
        header("Location: list.php");
    }
    if(isset($_POST['add']) && isset($_FILES["avatar"]["name"])){
        $file_name = time()."_".$_FILES['avatar']['name'];
        $file_tmp = $_FILES['avatar']['tmp_name'];
        $wb = ['jpg', 'png', 'jpeg'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        if(!in_array($file_ext,$wb)){
            echo "<script>
                alert('Failed to upload this image!');
                window.location.href = 'add_user.php'
            </script>";
        }
        else{
            $path = "avatars/".basename($file_name);
            if(move_uploaded_file($file_tmp, $path)){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $role = $_POST['role'];
                $file_name = basename($file_name);
                $query = "INSERT INTO users (username, password, fullname, email, phone, role, avatar) VALUE ('$username', '$password', '$fullname', '$email', '$phone', '$role', '$file_name')";
                if(mysqli_query($conn,$query)){
                    echo "<script>
                        alert('Added User Successfully!');
                        window.location.href = 'list.php'
                    </script>";
                }  
                else{
                    echo "<script>
                        alert('Added User Failed!');
                        window.location.href='add_user.php';
                    </script>";
                }
            }

        }

    }
?>