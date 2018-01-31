<?php
    session_start();
    if(isset($_SESSION['reg_nick'])){
        $nick = $_SESSION['reg_nick'];
        $pass = $_SESSION['reg_pass'];
    }

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>COSA - New Account Creator</title>
</head>

<body>
    Witaj w COSA! <br>
    Twój login to: <?php echo $nick."</br>"; ?>
    Twoje hasło to : <?php echo $pass."</br>"; ?>
    <a href="index.php">Zaloguj sie!</a>
</body>
</html>
