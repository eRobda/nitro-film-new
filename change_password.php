<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$password = $_POST['password'];
$username = $_SESSION['username'];
$result = "nic";

// Create connection
$conn = new mysqli('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE credentials SET password='$password' WHERE username='$username'";

if ($conn->query($sql) === TRUE) {
    $result = "heslo úspěšně změněno";
} else {
    $result = "chyba: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nitro Film - Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');
        *{
            font-family: 'Roboto Mono', monospace;
            box-sizing: border-box;
        }
        body{
            height: 100vh;
            margin: 0;
            background-color: rgb(24, 24, 24);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input{
            height: 30px;
            background-color: rgb(30, 30, 30);
            border: none;
            color: rgb(100, 100, 100);
            border-radius: 5px;
            padding-left: 7px;
        }
        input:focus{
            outline: none;
        }
        header{
            background-color: rgb(30, 30, 30);
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 0;
        }
        .nadpis{
            padding: 9px;
            color: rgb(100, 100, 100);
            user-select: none;
        }
        .result{
            color: rgb(100, 100, 100);
        }
        .zpet{
            width: 100px;
            height: 30px;
            margin-top: 200px;
            border: none;
            border-radius: 5px;
            background-color: rgb(30, 30, 30);
            color: rgb(100, 100, 100);
            font-size: 16px;
        }
        .zpet:hover{
            cursor: pointer;
        }
        main{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="nadpis">Film Nitro</div>
    </header>
    <main>
        <div class="result"><?php echo $result;?></div>
        <button id="btn" class="zpet">zpět</button>
    </main>
</body>
<script>
    var button = document.getElementById("btn");

    button.addEventListener("click", function() {
        window.location.href = "main.php";
    });
</script>
</html>