<?php
    session_start();
    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if(isset($_POST['zarejestruj'])){
       $validated = true;
       $fname = $_POST['imie'];
       if(strlen($fname) < 3 || strlen($fname) > 20)
       {
           $validated = false;
           $_SESSION['er_fname'] = "Niepoprawne imie";
       }
       if(!ctype_alpha($fname)){
           $validated = false;
           $_SESSION['er_fname'] = 'Imie moze skladac sie wylacznie z liter alfabetu angielskiego';
       }
       $lname = $_POST['nazwisko'];
        if(strlen($lname) < 3 || strlen($lname) > 20)
        {
            $validated = false;
            $_SESSION['er_lname'] = "Niepoprawne nazwisko";
        }
        if(!ctype_alpha($lname)){
            $validated = false;
            $_SESSION['er_lname'] = 'Nazwisko moze skladac sie wylacznie z liter alfabetu angielskiego';
        }
        $kraj = $_POST['kraj'];
        if(!empty($kraj) && !ctype_alpha($kraj)){
            $validated = false;
            $_SESSION['er_kraj'] = 'Nazwa kraju moze skladac sie wylacznie z liter alfabetu angielskiego';
        }
        $data_ur = $_POST['data'];
        $date_int = (int)$data_ur['0'] * 1000 + (int)$data_ur['1'] * 100 +
            (int)$data_ur['2'] * 10 + (int)$data_ur['3'];
        if($data_ur >= 2018 || $data_ur < 1900){
            $validated = false;
            $_SESSION['er_data'] = 'Niepoprawna data urodzenia';
        }

        $elo = $_POST['elo'];
        if($elo > 3000 || $elo < 0){
            $validated = false;
            $_SESSION['er_elo'] = 'Niepoprawny ranking ELO';
        }
        if($validated){
            $nickname = substr($fname,0 , 3);
            $nickname = $nickname.substr($lname, 0, 3);
            $sql = "SELECT * FROM Player WHERE Id LIKE '$nickname%'";
            if($db_respond = @$connection->query($sql)) {
                $n_row = $db_respond->num_rows;
                while($n_row){
                    $los = rand(1,999);
                    $sql2 = "SELECT * FROM Player WHERE Id LIKE '$nickname.$los%'";
                    $db_respond2 = @$connection->query($sql2);
                    $n_row = $db_respond2->num_rows;
                }
                echo "</br>";
                $nickname = $nickname.$los;
                $password = "h".rand(1000000,9999999);
                echo $nickname;
                echo "</br>";
                echo $password;
                $final_id = $nickname.$password;
                if($connection->query("INSERT INTO Player VALUES 
                    ('$fname', '$lname', '$data_ur', '$kraj', '$elo', '$final_id')")){
                    $_SESSION['registered'] = true;
                    $_SESSION['reg_nick'] = $nickname;
                    $_SESSION['reg_pass'] = $password;
                    header('Location: newaccount.php');
                }
                else{
                    echo "Problem";
                }
                $connection->close();
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
    <p align="left">[<a href="index.php">Wróć</a>]</href></p>
    <br><br>
    <form method="post">
        Imię: <br /> <input type="text" name="imie"/><br />
        <?php
            if(isset($_SESSION['er_fname'])){
                echo '<div class ="error">'.$_SESSION['er_fname'].'</div>';
                unset($_SESSION['er_fname']);
             }
        ?>
        Nazwisko: <br /> <input type="text" name="nazwisko"/></br>
        <?php
        if(isset($_SESSION['er_lname'])){
            echo '<div class ="error">'.$_SESSION['er_lname'].'</div>';
            unset($_SESSION['er_lname']);
        }
        ?>
        Data urodzenia: <br /> <input type="date" name="data"/></br>
        <?php
        if(isset($_SESSION['er_data'])){
            echo '<div class ="error">'.$_SESSION['er_data'].'</div>';
            unset($_SESSION['er_data']);
        }
        ?>
        Kraj: <br /> <input type="text" name="kraj"/></br>
        <?php
        if(isset($_SESSION['er_kraj'])){
            echo '<div class ="error">'.$_SESSION['er_kraj'].'</div>';
            unset($_SESSION['er_kraj']);
        }
        ?>
        Ranking ELO: <br /> <input type="number" name="elo"/></br> </br>
        <?php
        if(isset($_SESSION['er_elo'])){
            echo '<div class ="error">'.$_SESSION['er_elo'].'</div>';
            unset($_SESSION['er_elo']);
        }
        ?>
        <input type ="submit" value ="zarejestruj" name = "zarejestruj"/>

    </form>
</body>
</html>
