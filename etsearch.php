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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Panel Główny</title>
    <link rel="stylesheet" href = back.css type = "text/css" />
</head>
<body>

<?php
echo '<p align="left"> [<a href="panel.php">Wróć</a>]</href></p>';
echo "<br><br>";
?>

<form action="resultet.php" method="POST">
    <center><h3>Znajdz otwarcie po etykiecie</h3></center>
    <center><table>
            <tr>
                <td>Wprowadź etykietę</td>
                <td><input type="text" name="op_et" size="100"></td>
                <td><input type="submit" name="submit"></td>
            </tr>
        </table></center>

</form>

</body>
</html>

