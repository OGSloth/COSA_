<?php
session_start();
require_once "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);
if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
$find_pl = "SELECT * FROM Player";
if($db_respond = $connection->query($find_pl)){
    while($row = mysqli_fetch_array($db_respond)){
        $search = $row['Id'];
        $search = hash(md5, $search);
        if($search == $_GET['link']){
            $myid = $row['Id'];
        }
    }
}
$sql = "SELECT * FROM Player_Result WHERE Player_Id = \"$myid\" ";
if(isset($_POST['popul'])){
    $ord = "ORDER BY 
        (Wins_As_White + Loses_As_Black + Wins_As_Black + Loses_As_White) DESC";
    $sql = $sql.$ord;
}
else if(isset($_POST['zwyc'])){
    $ord = "ORDER BY (Wins_As_White + Wins_As_Black) / 
        (Wins_As_White + Loses_As_Black + Wins_As_Black + Loses_As_White) DESC";
    $sql = $sql.$ord;
}
else if(isset($_POST['white'])){
    $ord = "ORDER BY (Wins_As_White) / 
        (Wins_As_White + Loses_As_White) DESC";
    $sql = $sql.$ord;
}
else if(isset($_POST['black'])){
    $ord = "ORDER BY (Wins_As_Black) / 
        (Loses_As_Black + Wins_As_Black) DESC";
    $sql = $sql.$ord;
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
<?php
echo '<p align="left"> [<a href="panel.php">Wróć</a>]</href></p>';
echo "<br><br>";
?>
<form method="post">
    <center><b>Sortuj po:</b></center>
    <center> <input type ="submit" value ="Popularności" name = "popul"/>
        <input type ="submit" value ="% Zwycięstw" name = "zwyc"/></br>
        <input type ="submit" value ="Wydajność białymi" name = "white"/>
        <input type ="submit" value ="Wydajność czarnymi" name = "black"/>
    </center>
</form>
<?php
echo "<br>";
$response = @mysqli_query($dbc, $sql);
if($response) {
    $row_num = $response->num_rows;
    if(!$row_num){
        echo "Brak rozgrywek!";
    }
    else{
        echo '<table align="left" cellspacing="5" cellpadding="8">
                <tr><td align ="left"><b>Nazwa Otwarcia:</b></td>
                <td align ="left"><b>Zwyciestwa po bialej stronie:</b></td> 
                <td align ="left"><b>Porażki po białej stronie:</b></td>
                <td align ="left"><b>Zwyciestwa po czarnej stronie:</b></td>
                <td align ="left"><b>Porażki po czarnej stronie:</b></td>
                </tr>';
        while($row = mysqli_fetch_array($response)){
            $OpId = $row['Opening_Id'];
            $sql2 = "SELECT Name FROM Opening WHERE Id = $OpId";
            $response2 = @mysqli_query($dbc, $sql2);
            while($row2 = mysqli_fetch_array($response2)) {
                $nazwa_ot = $row2['Name'];
                echo '<tr><td align ="left"><b>' . $nazwa_ot . '</b></td>' .
                    '<td align ="left"><b>' . $row['Wins_As_White'] . '</b></td>'.
                    '<td align ="left"><b>' . $row['Loses_As_White'] . '</b></td>'.
                    '<td align ="left"><b>' . $row['Wins_As_Black'] . '</b></td>'.
                    '<td align ="left"><b>' . $row['Loses_As_Black'] . '</b></td></tr>';
            }
        }
        echo '</table>';
    }
    $connection->close();
}
else{
    echo "Problem polaczenia z baza danych";
}
?>
<br>
</body>
</html>
