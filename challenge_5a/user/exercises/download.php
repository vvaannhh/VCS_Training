<?php
if(isset($_GET['file'])){
    $filename=$_GET['file'];
    $path_file="uploads/task/".$filename;
    if(file_exists($path_file)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="'.basename($path_file).'"');
        header('Content-Length: ' . filesize($path_file));
        header('Pragma: public');
        readfile($path_file);
    }else{
        echo "File does not exist.";
    }
}
else
    echo "Filename is not defined."
?>