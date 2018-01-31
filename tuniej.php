<?php
session_start();
require_once "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
$valid = true;
$made = false;
if(isset($_POST['zatw'])){
    if(!isset($_POST['nazwa']) || empty($_POST['nazwa'])){
        $valid = false;
    }
    $nazwat = $log = htmlentities($_POST['nazwa'], ENT_QUOTES, "UTF-8");
    $privatet = 0;
    if(isset($_POST['priv']) && !empty($_POST['priv'])){
        $privatet = 1;
    }
    if($valid){
        $sql = "INSERT INTO Tournament VALUES (NULL, \"$nazwat\", $privatet)";
        if($db_respond = @$connection->query($sql))
        {
            $nazwaorg = $_POST['nazwa'];
            $last_insert_id = $connection->insert_id;
            $made = true;
            $myid = $_SESSION['Id'];
            $ins = "INSERT INTO Tournament_Players VALUES 
                        ($last_insert_id,'$myid')";
            @$connection->query($ins);
        }
        else{
            echo "Failed Connection";
        }
    }
}
?>
<?php
echo '<p align="left">[<a href="panel.php">Wróć</a>]</href></p>';
echo "<br><br>";
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Panel Główny</title>
    <link rel="stylesheet" href = back.css type = "text/css" />
</head>
<body>
<center><b>Utwórz turniej!</b></center>
</br>
<center>
    <?php
        if($made){
            echo '<b>Pomyslnie utworzono turniej '.$nazwaorg.'</b>';
        }
    ?>
    <form method="post">
        </br>
        Nazwa turnieju: <br /> <input type="text" name="nazwa"/>
        <?php
            if(!$valid){
                echo '</br><font size = "3" color = "red"> Te pole nie moze byc puste! </font>';
            }
        ?>
        </br></br>
        Czy turniej jest prywatny:<label><input type ="checkbox" name="priv"/></label></br></br>
        <input type = "submit" value = "Zatwierdz" name = "zatw">
    </form>

</center>
</body>
</html>