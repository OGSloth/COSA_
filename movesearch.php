<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <link rel="stylesheet" href = back.css type = "text/css" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Panel Główny</title>
</head>
<body>

<?php

echo '<p align="left">[<a href="panel.php">Wróć</a>]</href></p>';
echo "<br><br>";
if (empty($_POST["num"]) && !isset($_POST["num"])) {
    echo "Nie wprowadziles ruchow";
    $numer = (int)0;
    $sql;
}else{
    $lista = $_POST['list'].' '.$_POST['sekw'];
    $numer = (int)$_POST['num'];
    $int = (is_numeric($_POST['num']) ? (int)$_POST['num'] : 0);
    $tekst = $_POST['sekw'];
    $tekst = htmlentities($tekst, ENT_QUOTES, "UTF-8");
    if($int == 0){
        $sql = "SELECT Opening_Id FROM Move WHERE Sequence LIKE '$tekst' AND  Number_Of_Move = 1) t1";

    }
    else{
        $sql = $_POST['ruchy'];
        $plus = $int + 1;
        echo "<br>";
        $sql = "$sql JOIN (SELECT Opening_Id FROM Move WHERE Sequence LIKE '$tekst' AND  Number_Of_Move = $plus
         ) t$plus ON t$int.Opening_Id = t$plus.Opening_Id ";
    }

    $int++;
    echo "Ilosc ruchow wprowadzonych: $int".'<br />';
    echo "Wprowadzone ruchy: $lista".'<br />';

}

?>


<form action="movesearch.php" method="POST">
    <center><h3>Znajdz otwarcie po sekwencji</h3></center>
    <center><table>
            <tr>
                <td>Wprowadź Ruch:</td>
                <td><input type="text" name="sekw" size="100"></td>
                <td><input type="submit" name="submit"></td>
                <input type="hidden" name="num" value="<?=$int?>" >
                <input type="hidden" name="ruchy" value="<?=$sql?>" >
                <input type="hidden" name="list" value="<?=$lista?>" >
            </tr>
        </table></center>
    <br /><br />
</form>

<?php
    if(isset($int)){
        $sql1 = "SELECT t1.Opening_Id FROM ($sql";
        $response = @mysqli_query($dbc, $sql1);
        if($response) {
            echo '<table align="center" cellspacing="5" cellpadding="8">
            <tr><td align ="center"><b>Nazwy Możliwych Otwarć:</b></td></tr><tr></tr><tr></tr>';
            while ($row = mysqli_fetch_array($response)) {
                $Id = $row['Opening_Id'];
                $sql2 = "SELECT Name FROM Opening WHERE Id = $Id";
                $response2 = @mysqli_query($dbc, $sql2);
                if($response2) {
                    $row2 = mysqli_fetch_array($response2);
                    $OpName = $row2['Name'];

                    echo '<tr><td align="center">' .
                        $OpName . '</td></tr>';

                }
            }
            $response->close();
            $response2->close();
        }

    }
?>

</body>
</html>

