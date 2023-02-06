<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}
$username = $_SESSION['username'];

$target_dir = "uploads/";
$uploadOk = 1;
$f = basename($_FILES["profile_picture"]["name"]);
$imageFileType = strtolower(pathinfo($f,PATHINFO_EXTENSION));
$target_file = $target_dir . $username . '.' . $imageFileType;
// Check if image file is a actual image or fake image

$mysqli = new mysqli('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$query = "SELECT pfp FROM credentials WHERE username='$username'";
$result = $mysqli->query($query);

/* check for errors in the query */
if (!$result) {
    printf("Error: %s\n", $mysqli->error);
    exit();
}

$row = $result->fetch_assoc();
$pfp = $row['pfp'];

if($pfp != "uploads/def.png"){
    unlink($pfp);

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        } else {
        echo "File is not an image.";
        $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Create connection
            $conn = new mysqli('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $sql = "UPDATE credentials SET pfp='$target_file' WHERE username='$username'";
    
            if ($conn->query($sql) === TRUE) {
            } else {
                $result = "chyba: " . $conn->error;
            }
    
            $conn->close();
    
    
    
        echo "The file ". basename( $_FILES["profile_picture"]["name"]). " has been uploaded.";
        } else {
        echo "Sorry, there was an error uploading your file.";
        }
    }
    
    header('Location: main.php');
}
else{
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        } else {
        echo "File is not an image.";
        $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["profile_picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            // Create connection
            $conn = new mysqli('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $sql = "UPDATE credentials SET pfp='$target_file' WHERE username='$username'";
    
            if ($conn->query($sql) === TRUE) {
            } else {
                $result = "chyba: " . $conn->error;
            }
    
            $conn->close();
    
    
    
        echo "The file ". basename( $_FILES["profile_picture"]["name"]). " has been uploaded.";
        } else {
        echo "Sorry, there was an error uploading your file.";
        }
    }
    
    header('Location: main.php');
}
?>