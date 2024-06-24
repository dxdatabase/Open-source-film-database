<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
   <!-- DXdatabase crappy code under Creative Commons BY-SA license -->
<HTML>
   <HEAD>
   

  <title>Search a film by DX number : <?php echo $_GET['dx']; ?></title>
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
    if(isset($_GET['dx']))
    {
        if(empty($_GET['dx']))
        {
            echo('error - Enter a DX code, 6 numbers<br>');
        }else
        {
            $codedx=substr($_GET['dx'], 1, 4);  
           $codedxcomplet=substr($_GET['dx'], 0, 5);
            $f=fopen('film_database.csv','r');
            if($f)
            {
                while($ligne=fgets($f))
                {
                    $l=explode(';',$ligne);
                        $recherche=substr($l[1], 0, 5);
                        $rechercheflou=$l[0];
                        if($codedxcomplet==$recherche)
                        {
                            $nomsanshash = $l[2];
                           if  (str_replace("\n", "", $l[11])!="") { $image = $l[11]; } else { $image = "nopic.jpg"; }
                               if (strpos($nomsanshash, "#")) {$nomsanshash = substr($nomsanshash, 0, strpos($nomsanshash, "#"));}
                          $affichexact =  $affichexact."<footer class='footer'><img src='img/$image' width='150px' align='right'>Code DX: $l[1]<br><b>Name: ".$nomsanshash."</b><br>";
#           if  ($l[5]!="") { $certitude = " - certitude (4=high, 0=low) -> $l[5]";}
                                 if  ($l[5]!="") { $certitude = " - certitude : <img src='$l[5].gif'>";}
                       if  ($l[3]!="") { $affichexact = $affichexact."Information / Suspected emulsion: $l[3] $certitude<br>"; }
                  if  ($l[6]!="") { $affichexact = $affichexact."Origin: $l[6]<br>"; }   
                     if  ($l[4]!="") { $affichexact = $affichexact."Manufacturer: $l[4]<br>"; }
                       if  ($l[9]!="") { $affichexact = $affichexact."Distributor: $l[9]<br>"; }   
                                   if  ($l[7]!="") { $affichexact = $affichexact."Start date: $l[7]<br>"; }  
                                    if  ($l[8]!="") { $affichexact = $affichexact."end date: $l[8]<br>"; }  
                                       #DISPONIBILITE
                                        if ($l[10]=="2") {$avalab = "<FONT COLOR='green'>On the market</font>"; }
                                       if ($l[10]=="1") {$avalab = "Not sure if discontinued..."; }
                                        if ($l[10]=="0") {$avalab = "<FONT COLOR='red'>Discontinued :(</font>"; }

                                       $affichexact = $affichexact."availability : $avalab <br>";
            $affichexact =  $affichexact."</footer>";
              
                                                               $certitude="";
                        } else {

                         if($codedx==$rechercheflou)
                      { 
                      
                        $nomsanshash = $l[2];
                           if (strpos($nomsanshash, "#")) {$nomsanshash = substr($nomsanshash, 0, strpos($nomsanshash, "#"));}                                                if  (str_replace("\n", "", $l[11])!="") { $imagef = $l[11]; } else { $imagef = "nopic.jpg"; }
                                  $afficheflou = $afficheflou. "<footer class='footer'><img src='img/$imagef' width='150px' align='right'>Code DX: $l[1]<br><b>Name: $nomsanshash </b><br>";
                         #      if  ($l[5]!="") { $certitudef = " - certitude (4=high, 0=low) -> $l[5]";}
                                 if  ($l[5]!="") { $certitudef = " - certitude : <img src='$l[5].gif'>";}
                       if  ($l[3]!="") { $afficheflou = $afficheflou."Information / Suspected emulsion: $l[3] $certitudef<br>"; }
                  if  ($l[6]!="") { $afficheflou = $afficheflou."Origin: $l[6]<br>"; }   
                     if  ($l[4]!="") { $afficheflou = $afficheflou."Manufacturer: $l[4]<br>"; }
                       if  ($l[9]!="") { $afficheflou = $afficheflou."Distributor: $l[9]<br>"; }   
                                   if  ($l[7]!="") { $afficheflou = $afficheflou."Start date: $l[7]<br>"; }  
                                    if  ($l[8]!="") { $afficheflou = $afficheflou."end date: $l[8]<br>"; }      
                 
                                               #DISPONIBILITE
     #  echo $l[10];
                              if ($l[10]=="2") {$avalabf = "<FONT COLOR='green'>On the market</font>"; }
                                       if ($l[10]=="1") {$avalabf = "Not sure if discontinued..."; }
                                        if ($l[10]=="0") {$avalabf = "<FONT COLOR='red'>Discontinued :(</font>"; }
                                      $afficheflou = $afficheflou."availability : $avalabf <br>";
            $afficheflou =  $afficheflou."</footer>";
                                                                  $certitudef="";
             
                }
   }
         
            
        }    
          
          
          if (empty($affichexact)) {
          echo "FOUND NOTHING :(<br>";
          
           } else {
            echo "THIS FILM IS:$affichexact";
            }
            
                     if (empty($afficheflou)) {
          echo "FOUND NO SIMILAR EMULSION :(<br>";
          
           } else {
         
            echo "SIMILAR EMULSIONS:$afficheflou";
            

             }
             
                $affichecalcul = "<footer class='footer'><b>Manufacturer and film type (calculated from DX code, not very accurate...) :</b><br>";
             if ($codedx >= 0 && $codedx < 1) {$manuf="Fuji Acros/Neopan type";}
             if ($codedx >= 5 && $codedx < 6) {$manuf="Orwo Owopan film";}
             if ($codedx > 15 && $codedx < 22) {$manuf="Agfa Gevaert B&W film";}
             if ($codedx > 21 && $codedx < 25) {$manuf="Agfa Gevaert APX or Ortho type film";}
            if ($codedx > 24 && $codedx < 32) {$manuf="Agfa Gevaert B&W film";}
            if ($codedx > 31 && $codedx < 46) {$manuf="Sakura & Konica film";}

            if ($codedx > 45 && $codedx < 128) {$manuf="Agfa Gevaert chrome (slide) film";}	
            
            if ($codedx > 63 && $codedx < 80) {$manuf="Kodak Technical film";}	
            if ($codedx > 95 && $codedx < 112) {$manuf="Kodak IR film";} 
            if ($codedx > 127 && $codedx < 144) {$manuf="Fuji Fujicolor/Superia type film";}
            if ($codedx > 143 && $codedx < 160) {$manuf="Svema Russians film";}	
            if ($codedx > 159 && $codedx < 176) {$manuf="Fuji Fujicolor Pro 160 type film";}
            if ($codedx > 175 && $codedx < 192) {$manuf="Kodak Surveillance Film";}
            if ($codedx > 191 && $codedx < 208) {$manuf="Fuji Fujicolor Superia/Venus type film";}
            if ($codedx > 255 && $codedx < 272) {$manuf="Konica Minolta chrome film";}
            if ($codedx > 271 && $codedx < 288) {$manuf="Agfa Gevaert color film";}
            if ($codedx > 287 && $codedx < 304) {$manuf="Ferrania Scotch Color AT";}
            if ($codedx > 319 && $codedx < 336) {$manuf="Kodak Ektachrome type film";}
            if ($codedx > 367 && $codedx < 384) {$manuf="Kodak Ektachrome/Elitechrome type film";}	
            if ($codedx > 383 && $codedx < 400) {$manuf="Ferrania Imation Chrome";}
            if ($codedx > 415 && $codedx < 432) {$manuf="Konica Minolta Centuria type film";}
            if ($codedx > 447 && $codedx < 464) {$manuf="Konica Minolta VX type film";}
            if ($codedx > 484 && $codedx < 501) {$manuf="Agfa / Perutz basic color film (Agfacolor type)";}	
            if ($codedx > 511 && $codedx < 528) {$manuf="Fuji Fujichrome Velvia/Provia type film";}
            if ($codedx > 543 && $codedx < 560) {$manuf="Fuji Fujichrome Provia/Sensia type film";}
            if ($codedx > 559 && $codedx < 576) {$manuf="Fuji Fujicolor Superia type film";}
            if ($codedx > 575 && $codedx < 592) {$manuf="Fuji Fujicolor Super G/Superia/NP* type film";}
            if ($codedx > 623 && $codedx < 640) {$manuf="Fuji Fujicolor Superia/Venus type film";}
            if ($codedx > 639 && $codedx < 656) {$manuf="Konica Minolta IMPRESA film";}            
            if ($codedx > 671 && $codedx < 688) {$manuf="Fuji Fujichrome RSP type";}
            if ($codedx > 687 && $codedx < 704) {$manuf="Kodak 800 ISO Max/Portra/Supra film";}	
            if ($codedx > 721 && $codedx < 741) {$manuf="Agfa Gevaert Agfacolor-N/Ultra technology";}	

            if ($codedx > 740 && $codedx < 753) {$manuf="Agfa Gevaert Optima films (and Polaroid branded film)";}	
            if ($codedx > 751 && $codedx < 768) {$manuf="Agfa Gevaert (and Perutz) Agfacolor type film";}	
            if ($codedx > 783 && $codedx < 801) {$manuf="Agfa Gevaert Optima type film";}
            if ($codedx > 799 && $codedx < 816) {$manuf="Konica Minolta VX/LV/JX/XG type, and IMPRESA, Centuria First gen film";}
            if ($codedx > 831 && $codedx < 864) {$manuf="Kodak Ektachrome type film";}
            if ($codedx > 900 && $codedx < 976) {$manuf="Lucky Color";}
            if ($codedx > 1023 && $codedx < 1040) {$manuf="Kodak \"X\" films : Plus-X, Double-X, Tri-X...";}
            if ($codedx > 1055 && $codedx < 1072) {$manuf="Ferrania Scotch Color ATG/EXL";}
            if ($codedx > 1071 && $codedx < 1088) {$manuf="Kodak T-grain (Tmax) film";}	
            if ($codedx > 1087 && $codedx < 1104) {$manuf="ERA Chinese film";}
            if ($codedx > 1103 && $codedx < 1170) {$manuf="Kodak technical film ?";}
            if ($codedx > 1247 && $codedx < 1263) {$manuf="Kodak B&W chromogenic films and Gold type film";}	
            if ($codedx > 1262 && $codedx < 1312) {$manuf="Kodak first generation Portra/VR type film";}	
            if ($codedx > 1311 && $codedx < 1344) {$manuf="Kodak first generation Gold/Max/Ultima type film";}	
            if ($codedx > 1343 && $codedx < 1360) {$manuf="Kodak Kodachrome film";}	
            if ($codedx > 1359 && $codedx < 1376) {$manuf="Ferrania Imation Color HP";}
            if ($codedx > 1375 && $codedx < 1408) {$manuf="Ferrania Imaging Color FG (and Foma own films, or Foma cartridges for rebranded films)";}
            if ($codedx > 1407 && $codedx < 1440) {$manuf="Chineses films : Shenguang, Shanghai, Seagull or Rainbow";}	
            if ($codedx > 1439 && $codedx < 1456) {$manuf="Lucky B&W Chinese film";}	
            if ($codedx > 1487 && $codedx < 1504) {$manuf="Kodak \"Digital\" film";}
            if ($codedx > 1503 && $codedx < 1536) {$manuf="Kodak Royal/Elite/High Definition type film";}	
            if ($codedx > 1535 && $codedx < 1552) {$manuf="Kodak Max/Gold/Portra film, and cheap ColorPlus";}
            if ($codedx > 1551 && $codedx < 1568) {$manuf="Kodak basic Color Negative film";}	
            if ($codedx > 1567 && $codedx < 1584) {$manuf="Xiamen FUDA chinese film";}	
            if ($codedx > 1599 && $codedx < 1616) {$manuf="Lucky Color Super";}
            if ($codedx > 1727 && $codedx < 1735) {$manuf="Harman/Ilford Technical film.";}	   
            if ($codedx > 1734 && $codedx < 1744) {$manuf="SFX type film and Delta 3200";}	          
            if ($codedx > 1743 && $codedx < 1760) {$manuf="Harman/Ilford Pan films, Delta, and HP5(+)/FP4(+) ";}	          
            if ($codedx > 1759 && $codedx < 1770) {$manuf="Harman/Ilford chromogenic XP type films";}
            if ($codedx > 1769 && $codedx < 1775) {$manuf="Kentmere film ";}	
            if ($codedx > 1791 && $codedx < 1808) {$manuf="Kodak Vericolor/Portra type film";}	    
            if ($codedx > 1807 && $codedx < 1825) {$manuf="Agfa Gevaert Vista/HDC type film";}	
            if ($codedx > 1839 && $codedx < 1857) {$manuf="Perutz (Agfa) SC film & Agfa Vista. Used by a lot of rebranded film";}	
         
            if ($codedx > 1855 && $codedx < 1872) {$manuf="Kodak Kodachrome type film";}	          

            if ($codedx > 1919 && $codedx < 1952) {$manuf="Orwo CNS type film";}	          
            if ($codedx > 1951 && $codedx < 1968) {$manuf="Orwo CNN/OCN type film";}	          
            if ($codedx > 1967 && $codedx < 1984) {$manuf="Orwo PAN film";}	          
            if ($codedx > 2064 && $codedx < 2067) {$manuf="Kodak Codakolor II";}	   
            if ($codedx > 2400 && $codedx < 2405) {$manuf="Kodak Vericolor";}	
            if ($codedx > 3296 && $codedx < 3364) {$manuf="Rebranded Kodak film for Jean Coutu Pharmacies in canada";}                      
           
                if (empty($manuf)) {$manuf = "Unable to find manufacturer from DX code :(";}
           // echo $manuf;
            $affichecalcul = $affichecalcul.$manuf."</footer>";
            echo $affichecalcul;
 
 echo "<a href='index.php'>search another film</a>";
        //  header('Location: recherche.php');
        }
    }
}
   fclose($f);


  
?>
</body>
</html>
