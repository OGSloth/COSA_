<?php
session_start();
require_once "connect.php";
if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
$valid = false;
if(isset($_POST['submit'])){
    if(empty($_POST['fname']) && empty($_POST['lname'])){
        $_SESSION['err'] = '<div class ="error"> Wprowadź imię lub nazwisko!</div><br /><br />';
    }
    else{
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $valid = true;
        $fname = $_POST['fname'];
        $fname = htmlentities($fname, ENT_QUOTES, "UTF-8");
        $lname = $_POST['lname'];
        $lname = htmlentities($lname, ENT_QUOTES, "UTF-8");
        $sql = "SELECT * FROM Player WHERE First_Name = \"$fname\" OR Last_Name = \"$lname\" ";
    }
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

<form method="POST">
    <center><h3>Znajdź gracza:</h3></center>
    <center><table>
            <tr>
                <td>Wprowadź imię gracza:</td>
                <td><input type="text" name="fname" size="100"></td></tr><tr>
                <td>Wprowadź naziwsko gracza:</td>
                <td><input type="text" name="lname" size="100"></td></tr><tr>
            </tr>
        </table></center>
                <p align="center"> <input type="submit" name="submit"></p>
</form>
<?php
    if(isset($_SESSION['err'])){
        echo $_SESSION['err'];
        unset($_SESSION['err']);
    }
    if($valid) {
        if ($db_respond = @$connection->query($sql)) {
            echo '<center><table><tr><td>Imię i Nazwisko</td><td>Data urodzenia</td>
                  <td>Pochodzenie</td><td>ELO</td></tr>';
            while($row = mysqli_fetch_array($db_respond)){
                $name = $row['First_Name'].$row['Last_Name'];
                $Id = $row['Id'];
                $hash = hash(md5, $Id);
                echo '<tr><td><a href="elsestat.php?link='.$hash.'" style="color: white" id="$id">'.$name.'</a></td>
                      <td>'.$row['Date_of_birth'].'</td>
                      <td>'.$row['Country'].$int.'</td>
                      <td>'.$row['ELO'].'</td></tr>';
            }
            echo '</center></table>';
        }
    }
?>
</body>
</html>

