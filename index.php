<?php
    session_start();
    if(isset($_SESSION['loged']) && ($_SESSION['loged']))
    {
        header('Location:panel.php');
        exit();
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>COSA - Chess Openings Simple Analyzer</title>
    <link rel="stylesheet" href = back.css type = "text/css" />
</head>
<h1>
    COSA - Chess Openings Simple Analyzer
</h1>
<body>
<br>


	<form action="zaloguj.php" method="post">

		Login: <br /> <input type="text" name="login" /> <br />
		ID: <br /> <input type="password" name="ID" /> <br /><br />
		<input type="submit" value="Zaloguj się" />
	</form>
    </br></br>
    Jeżeli nie masz konta:</br>
    [<a href="rejestracja.php">Zarejestruj sie</a>]
    </br></br>
<?php
    if(isset($_SESSION['blad']))
    {
        echo $_SESSION['blad'];
    }
 ?>

</body>
</html>
