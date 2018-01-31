<?php
session_start();
require_once "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
$valid = false;
if(isset($_POST['submit'])){
    $valid = true;
    if($_POST['formTour'] == 'None'){
        $valid = false;
        $_SESSION['er_tour'] = "Wybierz turniej!";
    }
}
echo '<p align="left"> [<a href="panel.php">Wróć</a>]</href></p>';
echo "<br><br>";
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
    echo '<p><center><b>Wybierz Turniej</center></b>';
    echo '<br>';
    $tour_id = $_SESSION['Id'];
    $tour_sql = "Select * From Tournament WHERE Is_Public = 1";
    if($db_respond = @mysqli_query($dbc,$tour_sql)) {
        echo '<center><select name="formTour"></center>';
        echo '<option value = "None" > Wybierz</option >';
        while ($row = mysqli_fetch_array($db_respond)) {
            $TourId = $row['Id'];
            $TourName = $row['Tournament_Name'];
            echo '<option value = '.$TourId.' >'.$TourName.'</option >';
        }
    }
    echo '</select>';
    ?>
    <br /><br />
    <input type="submit" name="submit" value = "Znajdz">
</form>
<?php
if($valid){
    echo '<br /><br />';
    $tdbId = $_POST['formTour'];
    $sql_pl = "SELECT * FROM Tournament_Players WHERE Tournament_Id = $tdbId";
    $sql_game = "SELECT * FROM Tournament_Results WHERE Tournament_Id = $tdbId";
    if($db_respond = @$connection->query($sql_pl)){
        while($row = mysqli_fetch_array($db_respond)){
            $name = $row['Player_Id'];
            $sql_tour_pl = "SELECT * FROM Player WHERE Id = '$name'";
            if($db_respond2 = @$connection->query($sql_tour_pl)){
                while($pl_row = mysqli_fetch_array($db_respond2)){
                    $_SESSION[$name] = $pl_row['First_Name'].'  '.$pl_row['Last_Name'];
                }
            }
        }
    }
    if($db_respond = @$connection->query($sql_game)){
        echo '<table style="width:100%"><tr>
                        <td><b>Bialy gracz</b></td>
                        <td><b>Czarny gracz</b></td> 
                        <td><b>Otwarcie</b></td>
                        <td><b>Zwyciezyl</b></td>
                        </tr>';
        while($row = mysqli_fetch_array($db_respond)){
            $GameId = $row['Game_Result_Game_Id'];
            $sql_game_detail = "SELECT * FROM Game_Result WHERE Game_Id = $GameId";
            if($db_game = @$connection->query($sql_game_detail)){
                while($game_row = mysqli_fetch_array($db_game)){
                    $wname = $game_row['White_Id'];
                    $wname = $_SESSION[$wname];
                    $bname = $game_row['Black_Id'];
                    $bname = $_SESSION[$bname];
                    $winner = $wname;
                    if(!$game_row['White_Won']){
                        $winner = $bname;
                    }
                    $op_id = $game_row['Opening_Id'];
                    $op_db = @$connection->query("SELECT * FROM Opening WHERE Id = $op_id");
                    $op_row = mysqli_fetch_array($op_db);
                    $op_name = $op_row['Name'];
                    echo '<tr><td>'.$wname.'</td><td>'.$bname.'</td><td>'.$op_name.'</td><td>'.$winner.'</td></tr>';
                }
            }
        }
        echo '</table>';
    }
    if($db_respond = @$connection->query($sql_pl)){
        while($row = mysqli_fetch_array($db_respond)){
            $name = $row['Player_Id'];
            $sql_tour_pl = "SELECT * FROM Player WHERE Id = '$name'";
            if($db_respond2 = @$connection->query($sql_tour_pl)){
                while($pl_row = mysqli_fetch_array($db_respond2)){
                    unset($_SESSION[$name]);
                }
            }
        }
    }
}
?>

</body>
</html>
