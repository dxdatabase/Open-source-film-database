<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
  <!-- DXdatabase crappy code under Creative Commons BY-SA license -->
<HTML>
  <HEAD>
  <title>Search a film : <?php echo $_GET['name']; ?></title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="film.css">
  </HEAD>
<body>

<div class="wrapper">
  <header class="header"><h1>The Big Film Database !</h1>
    <p style="margin-left:85px;"><small>The biggest photographic film database in the world ! Search by name, code or DX number. <br>Find when a film is discontinued, who made it, who rebrand it ! Have fun !</small></p>
    </header>

<?php
    $nom="";
    $trouver=true;
    if(isset($_GET['name']))
    {
        static $compte=0;
        $myvar=$_GET['name'];
        $nomfilm=explode(" ", $_GET['name']);
        $f=fopen('film_database.csv','r');
        if($f)
        {
            while($ligne=fgets($f))
            {
                $l=explode(';',$ligne);
                if (preg_match("/$nomfilm[0]/i", $l[2])) {
                    if (preg_match("/$nomfilm[1]/i", $l[2])) {
                        #ICI LIMITER LA RECHERCHE A 30 FILMS...
                        $compte++;
                        if ($compte<50) {
                            $nomsanshash = $l[2];
                            if (strpos($nomsanshash, "#")) { $nomsanshash = substr($nomsanshash, 0, strpos($nomsanshash, "#")); }
                            if (str_replace("\n", "", $l[11])!="") { $image = $l[11]; } else { $image = "nopic.jpg"; }
                            if ($l[1]!="") { $affichedx = " - (Code DX: <a href='rech.php?dx=$l[1]'>$l[1]</a>)"; }
                            $affichexact = $affichexact."<footer class='footer'><img src='img/$image' width='150px' align='right'><b>Name: $nomsanshash $affichedx</b><br>";
                            if ($l[5]!="") { $certitude = " - certitude : <img src='$l[5].gif'>"; }
                            if ($l[3]!="") { $affichexact = $affichexact."<b>Information / Suspected emulsion:</b> $l[3] $certitude<br>"; }
                            if ($l[6]!="") { $affichexact = $affichexact."<b>Origin:</b> $l[6]<br>"; }
                            if ($l[4]!="") { $affichexact = $affichexact."<b>Manufacturer:</b> $l[4]<br>"; }
                            if ($l[9]!="") { $affichexact = $affichexact."<b>Distributor:</b> $l[9]<br>"; }
                            if ($l[7]!="") { $affichexact = $affichexact."<b>Start date:</b> $l[7]<br>"; }
                            if ($l[8]!="") { $affichexact = $affichexact."<b>End date:</b> $l[8]<br>"; }
                            #DISPONIBILITE
                            if ($l[10]=="2") {$avalab = "<FONT COLOR='green'>On the market</font>"; }
                            if ($l[10]=="1") {$avalab = "Not sure if discontinued..."; }
                            if ($l[10]=="0") {$avalab = "<FONT COLOR='red'>Discontinued :(</font>"; }

                            $affichexact = $affichexact."<b>availability:</b> $avalab <br>";
                            #Faut virer les valeurs qu'il peut réutiliser ce con
                            $affichedx="";
                            $certitude="";
                            $affichexact = $affichexact."</footer>";

                        } else {
                            $afficheerreur="<p><font color='red'><b>Too much result, try to be more specific...</b></font></p>";
                        }
                    }
                }
            }
            echo "Found this:<br>$affichexact";
            echo "$afficheerreur";

            echo "<aside class=\"dxblock\"><a href='index.php'>SEARCH ANOTHER FILM</a><br><br><small>If you find errors, missing film, please email me : dawar404 at gmail !</small></aside>";
            // header('Location: recherche.php');
        }

    } else {
        echo "Error... Try again : <a href='http://industrieplus.net/dxdatabase/'>http://industrieplus.net/dxdatabase</a><br><br>";
    }
    fclose($f);
?>
</body>
</html>
