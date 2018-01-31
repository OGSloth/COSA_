<?php
session_start();
if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
require_once "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if(isset($_POST['zatw'])){
    $valid = true;
    if($_POST['formGame'] == 'None'){
        $_SESSION['er_sel'] = "Wybierz Otwarcie";
        $valid = false;
    }
    $w_w = $_POST['w_won'];
    if($w_w != 0 && ($w_w > 200 || $w_w < 0 || empty($w_w))){
        $_SESSION['er_ww'] = "Liczba rozgrywek nieustawiona, przekraczajaca 200 lub mniejsza od 0";
        $valid = false;
    }
    $b_w = $_POST['b_won'];
    if($b_w != 0 && ($b_w > 200 || $b_w < 0 || empty($b_w))){
        $_SESSION['er_bw'] = "Liczba rozgrywek nieustawiona, przekraczajaca 200 lub mniejsza od 0";
        $valid = false;
    }
    $w_l = $_POST['w_lost'];
    if($w_l != 0 && ($w_l > 200 || $w_l < 0 || empty($w_l))){
        $_SESSION['er_wl'] = "Liczba rozgrywek nieustawiona, przekraczajaca 200 lub mniejsza od 0";
        $valid = false;
    }
    $b_l = $_POST['b_lost'];
    if($b_l != 0 && ($b_l > 200 || $b_l < 0 || empty($b_l))){
        $_SESSION['er_bl'] = "Liczba rozgrywek nieustawiona, przekraczajaca 200 lub mniejsza od 0";
        $valid = false;
    }
    if($valid){
        $myid = $_SESSION['Id'];
        $gameid = $_POST['formGame'];
        $check = "SELECT * FROM Player_Result WHERE Player_Id = \"$myid\" AND Opening_Id = $gameid";
        if($db_respond = @$connection->query($check)){
            $rownum = $db_respond->num_rows;
            if(!$rownum){
                $ins = "INSERT INTO Player_Result VALUES 
                        ('$myid','$gameid','$w_w','$w_l','$b_w','$b_l')";
                $connection->query($ins);
            }
            else{
                $fooarr = $db_respond->fetch_array();
                $ww = $w_w + $fooarr['Wins_As_White'];
                $wl = $w_l + $fooarr['Loses_As_White'];
                $bw = $b_w + $fooarr['Loses_As_Black'];
                $bl = $b_l + $fooarr['Loses_As_Black'];
                $delt = "DELETE FROM Player_Result WHERE Player_Id = '$myid' AND Opening_Id = '$gameid'";
                $ins = "INSERT INTO Player_Result VALUES 
                        ('$myid','$gameid','$ww','$wl','$bw','$bl')";
                $connection->query($delt);
                $connection->query($ins);
            }
            echo '</br></br><center><b>Statystyka została pomyślnie dodana!</b></center>';
        }

    }


}
echo '<p align="left">[<a href="panel.php">Wróć</a>]</href></p>';
echo "<br><br>";
$sql = "Select * from Opening";
$response = @mysqli_query($dbc, $sql);
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <link rel="stylesheet" href = back.css type = "text/css" />
   <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Panel Główny</title>
    <style>
        .error
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
<form method="post">
<?php
echo '
<p><center><b>Wybierz otwarcie</center></b>';
echo '<br><br>';
if($response) {
    echo '<center><select name="formGame"></center>';
    echo '<option value = "None" > Wybierz</option >';
    while ($row = mysqli_fetch_array($response)) {
        $OpName = $row['Name'];
        $OpId = $row['Id'];
        echo '<option value = '.$OpId.' > '.$OpName.'</option >';
    }
}
    echo'
</select>
</p>';
?>
<br><br>
    <?php
    if(isset($_SESSION['er_sel'])){
        echo '<div class ="error">'.$_SESSION['er_sel'].'</div>';
        unset($_SESSION['er_sel']);
    }
    ?>
    Zwyciestw jako bialy: <br /> <input type="number" name="w_won"/></br> </br>
    <?php
    if(isset($_SESSION['er_ww'])){
        echo '<div class ="error">'.$_SESSION['er_ww'].'</div>';
        unset($_SESSION['er_ww']);
    }
    ?>
    Porazek jako bialy: <br /> <input type="number" name="w_lost"/></br> </br>
    <?php
    if(isset($_SESSION['er_wl'])){
        echo '<div class ="error">'.$_SESSION['er_wl'].'</div>';
        unset($_SESSION['er_wl']);
    }
    ?>
    Zwyciestw jako czarny: <br /> <input type="number" name="b_won"/></br> </br>
    <?php
    if(isset($_SESSION['er_bw'])){
        echo '<div class ="error">'.$_SESSION['er_bw'].'</div>';
        unset($_SESSION['er_bw']);
    }
    ?>
    Porazek jako czarny: <br /> <input type="number" name="b_lost"/></br> </br>
    <?php
    if(isset($_SESSION['er_bl'])){
        echo '<div class ="error">'.$_SESSION['er_bl'].'</div>';
        unset($_SESSION['er_bl']);
    }
    ?>
    </br> </br>
    <input type="submit" name ="zatw" value = "Zatwierdz"/>
</form>
</body>
<?php
    $connection->close();
?>
</html>