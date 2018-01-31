<?php
    session_start();
    if(!isset($_POST['login']) || !isset($_POST['ID'])){
        header('Location: index.php');
        exit();
    }
    require_once "connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0)
    {
        echo "Błąd połączenia z Bazą Danych: ".$connection->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
        $ID = $_POST['ID'];
        $log = $login.$ID;
        $log = htmlentities($log, ENT_QUOTES, "UTF-8");
        $sql = "SELECT * FROM Player WHERE Id = '$log'";
        echo "<br><br>";
        if($db_respond = @$connection->query($sql))
        {
            $n_row = $db_respond->num_rows;
            if($n_row > 0  && !(is_numeric($log)))
            {
                $row = $db_respond->fetch_assoc();
                $_SESSION['First_Name'] = $row['First_Name'];
                unset($_SESSION['blad']);
                $_SESSION['loged'] = true;
                $_SESSION['Id'] = $log;
                $db_respond->free();
                header('Location:panel.php');
            }
            else {
                $_SESSION['blad'] = '<span style="color:lawngreen">Nieprawidlowy login lub ID!</span>';
                header('Location:index.php');
            }
        }
        $connection->close();
    }

?>
