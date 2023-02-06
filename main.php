<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

$username = $_SESSION['username'];
//echo "Welcome, $username";

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

/* check if a password was found */
if (!$pfp) {
    exit();
}
else{
    $_SESSION['pfp'] = $pfp;
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Nitro Film</title>
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
            margin: 0;
            background-color: rgb(24, 24, 24);
            height: 90vh;
        }
        header{
            background-color: rgb(30, 30, 30);
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 0 20px rgb(30, 30, 30);
        }
        .nadpis{
            padding: 9px;
            color: rgb(100, 100, 100);
            user-select: none;
        }
        .menu{
            height: 100%;
            display: flex;
            transition: .2s;
        }
        .menu:hover{
            cursor: pointer;
            transition: .2s;
        }
        .menu:hover .ico{
            box-shadow: 0 0 7px rgb(120,120,120);
            transition: .2s;
        }
        .username{
            color: rgb(100,100,100);
            margin: 8px 3px;
            user-select: none;
        }
        .ico{
            border-radius: 50%;
            user-select: none;
            cursor: pointer;
            transition: .2s;
            height: 30px;
            width: 30px;
            margin: 5px;
        }

        main{
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .main{
            height: 35px;
            width: 300px;
            transition: .1s;
            scale: 1.1;
            position: absolute;
            animation: none;
            z-index: 10000;
        }
        .main:hover{
            background-color: rgb(35,35,35);
            box-shadow: 0 0 7px rgba(80,80,80,0.5);
            transition: .1s;
        }
        .main input{
            width: 100%;
            height: 100%;
            font-size: 14px;
            background-color: rgb(30, 30, 30);
            color: rgb(70,70,70);
            padding-left: 10px;
            border: none;
            border-radius: 5px;
        }
        .main input:focus{
            outline: none;
            caret-color: rgb(100, 100, 100);
            color: rgb(100, 100, 100);
        }
        .main span{
            position: absolute;
            margin-left: 266px;
            padding: 7px;
            font-size: 20px;
            user-select: none;
            cursor: pointer;
            transition: .1s;
        }
        .main span:hover{
            text-shadow: 0 0 5px rgb(100,100,100);
            transition: .1s;
        }
        main video{
            border-radius: 5px;
            opacity: 0;
            margin-top: 7%;
            z-index: 1000;

        }
        .loading{
            position: absolute;
            background-color: rgb(24,24,24);
            z-index: 1000;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .loading div{
            color: rgb(100, 100, 100);
            font-size: 20px;
            user-select: none;
        }
        @keyframes search-input{
            0%{
                scale: 1.1;
            }
            100%{
                margin-top: -37%;
                scale: 1;
            }
        }
        @keyframes search-video{
            0%{
                opacity: 0;
                scale: 0;
            }
            100%{
                opacity: 1;
                scale: 1;
            }
        }
        @keyframes search-text{
            0%{
                font-size: 0px;
                opacity: 0;
            }
            100%{
                font-size: 19px;
                opacity: 1;
            }
        }
        #text{
            font-size: 16px;
            margin-top: 20px;
            animation: none;
            animation-duration: 3s;
        }
        .loading{
            display: none;
        }
        #video{
            width: auto;
            height: 80vw;
        }
        .loading-text{
            position: absolute;
            color: rgb(70, 70, 70);
            font-size: 19px;
            animation: none;
            opacity: 0;
        }
        .premium{
            color: rgb(212, 175, 55);
            transition: .2s;
            text-shadow: 0 0 3.5px rgb(212, 175, 55);
        }
    </style>
</head>
<body>
    <header>
        <div class="nadpis premium">Film Nitro</div>

        <div class="menu" id="acc">
            <div class="username premium"><?PHP echo $username; ?></div>
            <img id="pfp" src="<?php echo $_SESSION["pfp"]; ?>" class="ico premium">
        </div>
    </header>
    <main>
        <div class="main" id="main">
            <span id="search" class="material-symbols-outlined">search</span>
            <input id="input" type="text">
        </div>
        <video id="video" controls autoplay>
            <source src="" type="video/mp4">
            <source src="" type="video/ogg">
            Your browser does not support the video tag.
        </video>
        <div class="loading-text" id="loading-text">načítání...</div>
    </main>
</body>
<script>
    setInterval(() => {
        let loading = document.getElementById("loading-text");

        if(loading.innerHTML == "načítání..."){
            loading.innerHTML = "načítání";
        }
        else if(loading.innerHTML == "načítání"){
            loading.innerHTML = "načítání.";
        }
        else if(loading.innerHTML == "načítání."){
            loading.innerHTML = "načítání..";
        }
        else if(loading.innerHTML == "načítání.."){
            loading.innerHTML = "načítání...";
        }
    }, 500);
</script>
<script>
    function Odkaz(film, callback){
        fetch('https://722e-89-111-94-168.eu.ngrok.io/?arg='+ film)
        .then(response => response.text())
        .then(data => callback(data))
    }

    document.getElementById("search").addEventListener("click", function(){
        //document.getElementById("loading-screen").style.display = "flex";
        document.title = "Načítání...";
        document.getElementById("main").style.animation = "search-input 1s ease 1 forwards";
        document.getElementById("loading-text").style.animation = "search-text 1s ease 1 forwards";
        Odkaz(document.getElementById('input').value, function(data){
            document.title = "Nitro Film";
            document.getElementById("video").style.animation = "search-video 1s ease 1 forwards";
            document.getElementById("loading-text").style.opacity = "0";
            if(data != "nenalezeno"){
                document.getElementById("video").src = data;
            }
            else{
                alert("film nebyl nalezen");
            }
        });
    });
</script>
<script>
    var span = document.getElementById("acc");

    span.addEventListener("click", function() {
        window.location.href = "account.php";
    });
</script>