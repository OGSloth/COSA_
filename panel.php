<?php
session_start();

if(!isset($_SESSION['loged']))
{
    header('Location: index.php');
    exit();
}
if(isset($_GET['link'])){
    $link = $_GET['link'];
    if($link == "openings"){
        $link = '<center><font size="15px"><b>Znajdź otwarcie po:</b></font><br /><br /><br />
                 <a href ="namesearch.php"><div class = "button">Nazwie</div></a><br /><br />
                 <a href ="etsearch.php"><div class = "button">Etykiecie</div></a><br /><br />
                 <a href ="movesearch.php"><div class = "button">Sekwencji ruchów</div></a><br /><br />
                 <font size="15px"><b>Sprawdź listę wszystkich otwarć:</b></font><br /><br />
                 <a href ="handbook.php"><div class = "button">Vademecum</div></a><br />
                 <p><span style="color:red">Uwaga! Lista wszystkich otwarć jest bardzo duza!  Plik moze sie dluzej ladowac! </span></p>                 
                 </center>';
    }
    else if($link == "stats"){
        $link = '<center><font size="15px"><b>Sprawdź swoje:</b></font><br /><br /><br />
                 <a href ="mystats.php"><div class = "button">Statystyki Rozgrywek</div></a><br /><br />
                 <a href ="tournaments.php"><div class = "button">Turnieje</div></a><br /><br />                 
                 </center>';
    }
    else if($link == "ins"){
        $link = '<center><font size="15px"><b>Wprowadź:</b></font><br /><br /><br />
                 <a href ="proby.php"><div class = "button">Statystyki Rozgrywek</div></a><br /><br />
                 <a href ="addgame.php"><div class = "button">Rozgrywke</div></a><br /><br />
                 <a href ="tourgame.php"><div class = "button">Rozgrywke Turniejową</div></a><br /><br />
                 <font size="15px"><b>Utwórz:</b></font><br /><br /><br />
                 <a href ="tuniej.php"><div class = "button">Turniej</div></a><br /><br />                               
                 </center>';
    }
    else if($link == "info"){
        $link  =  '<center><font size="7px"><b>
                    COSA powstało jako projekt zaliczeniowy na przedmiot: ,,Bazy Danych"
                    studiów licencjackich na wydziale MIM Uniwersytetu Warszawskiego.
                    Stworzone przez Marcina Gadomskiego'.'<br />'.'
                    e-mail: ma.gadomski@student.uw.edu.pl
                    Kopiowanie i wykorzystywanie kodu jest dozwolone, a nawet bardzo mile widziane                 
                    </b></font>';
    }
    else if($link == "find"){
            $link = '<center><font size="15px"><b>Znajdź:</b></font><br /><br /><br />
                 <a href ="alltours.php"><div class = "button">Turniej</div></a><br /><br />
                 <a href ="findpl.php"><div class = "button">Gracza</div></a><br /><br />
                 </center>';
    }
    else{
        $link = '<p align="center"> <font size = "15px" color="black">Witaj w COSA!</font></p>';
    }
}

else{
    $link = '<p align="center"> <font size = "15px" color="black">Witaj w COSA!</font></p><br /><br /><br />'.'<font size = "6px">
    Program przeznaczony dla osób, które rozpoczynają swoją przygodę z szachami, miłośników szachów oraz
    dla tych, którzy chcą poprawić swoje umiejętności fazy początkowej gry. COSA umożliwia śledzenie
    statystyk otwarć szachowych własnych rozgrywek, tak jak i graczy zawodowych. 
    Dodatkowo jest bardzo użyteczny dla małych społeczności szachowych, gdyż
    pozwala na tworzenie własnych turniejów i ich analizę .</font>';
}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Panel Główny</title>
    <link rel="stylesheet" href = panelfront.css type = "text/css" />
</head>
<div id = "container">
    <body>
    <center>
        <?php
        echo '<p align="left"><a href="logout.php">[Wyloguj się]</a></p>';

        ?>
        <div id="topbar">
            <?php
            echo '<h1><p align="center"><b>';
            echo str_repeat('&nbsp;', 14);
            echo 'Witaj '.$_SESSION['First_Name'].'!</b></p></h1>';
            ?>
        </div>
        <div id="sidebar">
            <div id = "menu">
                <a href = "panel.php?link=openings" name="openings"><div class = "option">Otwarcia</div></a>
                <a href = "panel.php?link=stats" name="stats"><div class = "option">Moje statystyki</div></a>
                <a href = "panel.php?link=ins" name="ins"><div class = "option">Wprowadź</div></a>
                <a href = "panel.php?link=find" name="find"><div class = "option">Znajdź</div></a>
                <a href = "panel.php?link=info" name="info"><div class = "option">Informacje</div></a>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div id="content">
            <?php
            echo $link;
            ?>
        </div>
        <div id="footer">
        </div>
    </center>
    </body>
</div>
</html>
