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
echo '<p align="left"> [<a href="namesearch.php">Wróć</a>]</href></p>';
echo "<br><br>";
$Ask = $_POST['op_name'];
$Ask = htmlentities($Ask, ENT_QUOTES, "UTF-8");
echo "Szukasz otwarć o nazwie podobnej do: $Ask".'<br /><br />';
$sql1 = "SELECT * FROM Opening WHERE Name LIKE '%$Ask%' ORDER BY Name";

$response1 = @mysqli_query($dbc, $sql1);
echo '<table align="center"
    cellspacing="5" cellpadding="8">
    <tr><td align ="center"><b>Typ</b></td>
    <td align ="center"><b>Nazwa</b></td>
    <td align ="center"><b>Sekwencja Ruchów</b></td><tr></tr><tr></tr>
    </tr>';
if($response1) {
    while ($row = mysqli_fetch_array($response1)) {
        $NewId = $row['Id'];
        $sql2 = "SELECT Sequence FROM Move WHERE Opening_Id = $NewId ORDER BY Number_Of_Move ";
        $response2 = @mysqli_query($dbc, $sql2);
        echo '<tr><td align="left">' .
            $row['Category'] . '</td><td align="center">' .
            $row['Name'] . '</td><td align="center">';
        while ($row2 = mysqli_fetch_array($response2)) {
            echo $row2['Sequence'] . ' ';
        }
        echo '</td></tr>';
    }
    $response1->close();
    $response2->close();
}
?>

</body>
</html>

