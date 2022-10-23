<?php
    session_start();
    require_once '../config/connect.php';
    if(!isset($_SESSION['user'])){
        header("Location: list.php");
    }
    if(isset($_POST['update'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $fullname=$_POST['fullname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        if(empty($username) || empty($password) || empty($fullname) || empty($email) || empty($phone)){
            echo "<script>
                    alert('Update Failed');
                    window.location.href = 'list.php'
                </script>";
        }
        else{
            if(!empty($_FILES['avatar']['name'])){   
                $file_name = time()."_".$_FILES['avatar']['name'];
                $file_tmp = $_FILES['avatar']['tmp_name'];
                $wb = ['jpg', 'png', 'jpeg'];
                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));
                if(!in_array($file_ext,$wb)){
                    echo "<script>
                        alert('Failed to upload this image!');
                        window.location.href = 'list.php'
                    </script>";
                }
                else{
                    $path = "avatars/".basename($file_name);
                    move_uploaded_file($file_tmp, $path);
                    $file_name = basename($file_name);
                    $query = "UPDATE users SET password = '$password', fullname = '$fullname', email = '$email', phone = '$phone', avatar = '$file_name' WHERE username = '$username'";
                    if(mysqli_query($conn,$query)){
                        echo "<script>
                            alert('Update Successfully!');
                            window.location.href = 'list.php'
                        </script>";
                    }  
                    else{
                        echo "<script>
                            alert('Update Failed!');
                            window.location.href='list.php';
                        </script>";
                    }
                }
            }
            else{
                $query = "UPDATE users SET password = '$password', fullname = '$fullname', email = '$email', phone = '$phone' WHERE username = '$username'";
                if(mysqli_query($conn,$query)){
                    echo "<script>
                        alert('Update Successfully!');
                        window.location.href = 'list.php'
                    </script>";
                }  
                else{
                    echo "<script>
                        alert('Update Failed!');
                        window.location.href='list.php';
                    </script>";
                }
            }
        }
    }
?>