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
$sql = "Select * from Opening";
$response = @mysqli_query($dbc, $sql);
echo '<p align="left"> [<a href="panel.php">Wróć</a>]</href></p>';
echo "<br />";
if(isset($_POST['wys'])){
    $log = $_POST['login'].$_POST['ID'];
    $log = htmlentities($log, ENT_QUOTES, "UTF-8");
    $sql_log = "SELECT * FROM Player WHERE Id = '$log'";
    $valid = true;
    $my_id = $_SESSION['Id'];
    if($db_respond = @$connection->query($sql_log)){
       $n_row = $db_respond->num_rows;
        if($n_row > 0  && !(is_numeric($log)) && $log != $my_id ) {
            if($_POST['formGame'] == 'None'){
                $_SESSION['er_sel'] = "Wybierz Otwarcie!";
                $valid = false;
            }
            else{
                $OpenId = $_POST['formGame'];
            }
        }
        else{
            $valid = false;
            $_SESSION['er_log'] = "Nie poprawny login badz ID";
        }
    }
    else{
        $valid = false;
        echo '<center><b>Blad polaczenia z baza danych</b></center>';
    }
    if($valid){
        $whiteid = $log;
        $blackid = $my_id;
        $wwon = 0;
        if($_POST['color'] == 'white'){
            $whiteid = $my_id;
            $blackid = $log;
        }
        if($_POST['winner'] == 'white'){
            $wwon = 1;
        }
        $sql_game = "INSERT INTO Game_Result VALUES ('$whiteid', NULL, $OpenId,'$blackid',$wwon )";
        $check_white = "SELECT * FROM Player_Result WHERE Player_Id = '$whiteid' AND Opening_Id = $OpenId";
        $check_black = "SELECT * FROM Player_Result WHERE Player_Id = '$blackid' AND Opening_Id = $OpenId";
        echo '</br>';
        if($db_respond = @$connection->query($sql_game)){
            echo '<center><b>Rozgrywka zostala pomyslnie dodana!</b></center>';
        }
        if($db_respond = @$connection->query($check_white)){
            $rownum = $db_respond->num_rows;
            if(!$rownum){
                if($wwon){
                    @$connection->query("INSERT INTO Player_Result VALUES ('$whiteid', $OpenId, 1,0,0,0)");
                }
                else{
                    @$connection->query("INSERT INTO Player_Result VALUES ('$whiteid', $OpenId, 0,1,0,0)");
                }
            }
            else{
                if($wwon){
                    @$connection->query("UPDATE Player_Result SET Wins_As_White = Wins_As_White + 1 
                      WHERE Player_Id = '$whiteid' AND Opening_Id = $OpenId");
                }
                else{
                    @$connection->query("UPDATE Player_Result SET Loses_As_White = Loses_As_White + 1
                      WHERE Player_Id = '$whiteid' AND Opening_Id = $OpenId");
                }
            }
        }
        if($db_respond = @$connection->query($check_black)){
            $rownum = $db_respond->num_rows;
            if(!$rownum){
                if($wwon){
                    @$connection->query("INSERT INTO Player_Result VALUES ('$blackid', $OpenId, 0,0,0,1)");
                }
                else{
                    @$connection->query("INSERT INTO Player_Result VALUES ('$blackid', $OpenId, 0,0,1,0)");
                }
            }
            else{
                if($wwon){
                    @$connection->query("UPDATE Player_Result SET Loses_As_Black = Loses_As_Black + 1
                      WHERE Player_Id = '$blackid' AND Opening_Id = $OpenId");
                }
                else{
                    @$connection->query("UPDATE Player_Result SET Loses_As_White = Loses_As_White + 1
                      WHERE Player_Id = '$blackid' AND Opening_Id = $OpenId");
                }
            }
        }

    }
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
<body>
<form method="post">
    <?php
    echo '
<h1><p><center><b>Wybierz otwarcie</center></b></h1>';
    echo '<br><br>';
    if($response) {
        echo '<center><select name="formGame"></center>';
        echo '<option value = "None" > Wybierz</option >';
        while ($row = mysqli_fetch_array($response)) {
            $OpName = $row['Name'];
            $OpId = $row['Id'];
            echo '<option value = '.$OpId.' >'.$OpName.'</option >';
        }
    }
    echo'
</select>
</p>';
?>
</br>
    <?php
        if(isset($_SESSION['er_sel'])){
            echo $_SESSION['er_sel'].'</br>';
            unset($_SESSION['er_sel']);
        }
    ?>
<p><center>Wybierz swój kolor bierek:</center></p>
    <select name = "color">
        <option value = "white">Biale</option>
        <option value = "black">Czarne</option>
    </select>
    <p><center>Wybierz zwycieski kolor bierek:</center></p>
    <select name = "winner">
        <option value = "white">Biale</option>
        <option value = "black">Czarne</option>
    </select>
    <p><center>Poproś drugiego gracza o zaakceptowanie wyniku:</center></p>
    Login: <br /> <input type="text" name="login" /> <br />
    ID: <br /> <input type="password" name="ID" /> <br /><br />
    <?php
    if(isset($_SESSION['er_log'])){
        echo $_SESSION['er_log'].'</br>';
        unset($_SESSION['er_log']);
    }
    ?>
    <input type="submit" value="Wyślij rozgrywkę!" name ="wys">
</form>

</body>
</html>
