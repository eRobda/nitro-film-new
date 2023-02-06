<?php
$vysledek = "";

if(isset($_POST['username']) && isset($_POST['password'])){
    //connect to database
    $db = mysqli_connect('eu-cdbr-west-03.cleardb.net', 'b59667cc031b8b', '79dfa041', 'heroku_f1e9af68bb8ac45');

    //get the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    //query the database to see if the entered credentials match any records
    $query = "SELECT * FROM credentials WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);


    //if the credentials match, start a session and redirect to the main page
    if(mysqli_num_rows($result) == 1){
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['pfp'] = null;
        header("Location: main.php");
    }else{
        $vysledek = "nesprávné údaje!";
    }

    $servername = "eu-cdbr-west-03.cleardb.net";
    $username = "b59667cc031b8b";
    $password = "79dfa041";
    $dbname = "heroku_f1e9af68bb8ac45";

    if($vysledek != "nesprávné údaje!"){
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $usernamee = $_SESSION['username'];
    
        $sql = "SELECT * FROM users WHERE username='$usernamee'";
        $resultt = $conn->query($sql);
    
        if ($resultt->num_rows > 0) {
            // output data of each row
            while($row = $resultt->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["password"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }
}
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
            flex-direction: column;
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
        input{
            font-size: 16px;
            transition: .1s;
        }
        input:hover{
            color: rgb(150, 150,150);
            transition: .1s;
        }
        .login-btn{
            transition: 0.1s;
        }
        .login-btn:hover{
            box-shadow: 0 0 5px rgb(100, 100, 100);
            cursor: pointer;
            transition: 0.1s;
        }
        .chyba{
            margin-bottom: 20px;
            color: rgb(122, 40, 34);
        }
    </style>
</head>
<body>
    <header>
        <div class="nadpis">Film Nitro</div>
    </header>
    <div class="chyba"><?php echo $vysledek;?></div>
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="uživatelské jméno:" required>
        <input type="password" name="password" placeholder="heslo:" required>
        <input class="login-btn" type="submit" value="Login">
    </form>
</body>
</html>


