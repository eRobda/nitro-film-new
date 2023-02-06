<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$username = $_SESSION['username'];

$mysqli = new mysqli('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$query = "SELECT password FROM credentials WHERE username='$username'";
$result = $mysqli->query($query);

/* check for errors in the query */
if (!$result) {
    printf("Error: %s\n", $mysqli->error);
    exit();
}

$row = $result->fetch_assoc();
$password = $row['password'];

/* check if a password was found */
if (!$password) {
    printf("Error: No password found for the given username.\n");
    exit();
}
else{
    $_SESSION['password'] = $password;
}
//echo "Welcome, $username";
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 1,
                'wght' 400,
                'GRAD' 0,
                'opsz' 48
        }
        .material-symbols-outlined{
            color: rgb(100, 100, 100);
        }
        *{
            font-family: 'Roboto Mono', monospace;
            box-sizing: border-box;
        }
        body{
            height: 100vh;
            margin: 0;
            background-color: rgb(24, 24, 24);
        }
        header{
            background-color: rgb(30, 30, 30);
            height: 40px;
            display: flex;
            justify-content: space-between;
            top: 0;
        }
        .nadpis{
            padding: 9px;
            color: rgb(100, 100, 100);
            user-select: none;
        }
        .menu{
            display: flex;
        }
        .menu span{
            font-size: 30px;
            padding: 5px;
            user-select: none;
            cursor: pointer;
            transition: .1s;
        }
        .menu span:hover{
            text-shadow: 0 0 3px rgb(100,100,100);
            transition: .1s;
        }
        main{
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 100px;
        }
        section{
            width: 40%;
        }
        .item{
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
        }
        .sec-title{
            font-size: 20px;
            color: rgb(100, 100, 100);
        }
        .item-name{
            color: rgb(100, 100, 100);
            margin-left: 30px;
            font-size: 16px;
        }
        .item-data{
            color: rgb(80, 80, 80);
            margin-right: 30px;
            font-size: 16px;
        }
        .input{
            font-size: 16px;
            border : none;
            background-color: rgb(24,24,24);
        }
        .input:focus{
            outline: none;
        }
        #password{
            background-color: rgb(30,30,30);
            width: 150px;
            border-radius: 5px;
            padding: 2px 5px;
        }
        .btn{
            transition: .1s;

        }
        .btn:hover{
            box-shadow: 0 0 5px rgba(80,80,80,0.5);
            transition: .1s;
            cursor: pointer;
        }
        #password{
            transition: .1s;
        }
        #password:hover{
            background-color: rgb(35,35,35);
            box-shadow: 0 0 5px rgba(80,80,80,0.5);
            transition: .1s;
        }
        .pfp-upload-form{
            display: flex;
        }
        .pfp-upload-form input{
            height: 25px;
            margin: 0;
        }
        .logout{
            transition: .1s;
        }
        .logout:hover{
            background-color: rgb(35,35,35);
            box-shadow: 0 0 5px rgba(80,80,80,0.5);
            transition: .1s;
            cursor: pointer;
        }
        .upload-btn{
            transition: .1s;
        }
        .upload-btn:hover{
            background-color: rgb(35,35,35);
            box-shadow: 0 0 5px rgba(80,80,80,0.5);
            transition: .1s;
            cursor: pointer;
        }
        @media (max-width: 960px){
            section{
                width: 80%;
            }
            main{
                margin-top: 50px;
            }
            .item{
                flex-direction: column;
                margin-left: 10px;
            }
            .item-name{
                margin-left: 0;
            }
            .float-right{
                float: right;
            }
            .item-name{
                margin-bottom: 7px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="nadpis">Film Nitro</div>
        <div class="menu">
            <span id="home" class="material-symbols-outlined ico">home</span>
        </div>
    </header>
    <main>
        <section>
            
            <div class="sec-title">účet</div>
            <div class="item">
                <div class="item-name">uživatelské jméno:</div>
                <div class="item-data"><?PHP echo $username; ?></div>
            </div>
            <div class="item">
                <div class="item-name">heslo:</div>
                <form method="post" action="change_password.php">
                    <input id="password" name="password" class="item-data input" value="<?PHP echo $_SESSION['password']; ?>"></input>
                    <input class="btn float-right" style="border-radius: 5px; margin-right: 25px; border: none; background-color: rgb(30,30,30); color: rgb(100,100,100); height: 25px; font-size: 16px;" type="submit" value="změnit">
                </form>
            </div>
            <div class="item">
                <div class="item-name">profilový obrázek:</div>
                <form class="pfp-upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                    <input style="color: rgb(100, 100, 100);" type="file" name="profile_picture" id="profile_picture">
                    <input class="upload-btn float-right" style="margin-right:25px; background-color: rgb(30, 30, 30);
                    border: 0; color: rgb(100, 100, 100); font-size: 16px; border-radius: 5px;" type="submit" value="nahrát">
                </form>
            </div>
            <div class="item">
                <form style="display: flex; justify-content: center; width: 100%; margin-top: 50px;" action="logout.php" method="post" enctype="multipart/form-data">
                    <input class="logout" style="margin-right:25px; background-color: rgb(30, 30, 30);
                    border: 0; color: rgb(100, 100, 100); font-size: 16px; border-radius: 5px;
                    width: 200px; height: 35px" type="submit" value="odhlásit">
                </form>
            </div>
        </section>
    </main>
    <footer>
        
    </footer>
</body>
<script>
    document.getElementById("password").focus();

    var span = document.getElementById("home");

    span.addEventListener("click", function() {
        window.location.href = "main.php";
    });
</script>
</html>