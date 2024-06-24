<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
   <!-- DXdatabase crappy code under Creative Commons BY-SA license -->
<HTML>
   <HEAD>

      <TITLE>The Big Film Database for analog photographers - Search by DX number, code or name</TITLE>
        <meta charset="utf-8">
        <link rel="stylesheet" href="film.css">

   </HEAD>
<body>

<div class="wrapper">


  <header class="header"><h1>The Big Film Database !</h1>
        <p style="margin-left:85px;"><small>The biggest photographic film database in the world ! Search by name, code or DX number. <br>Find when a film is discontinued, who made it, who rebrand it ! Have fun !</small></p>
        </header>

 <footer class="footer">
     <p>IMPORTANT : For the past few years, the database has only been updated sporadically. To prevent this work from disappearing, I have decided to place it under a <a href="https://creativecommons.org/licenses/by-sa/4.0/">Creative Commons BY-SA license</a> on <a href="https://github.com/dxdatabase/Open-source-film-database">GitHub</a> (with the exception of the images, which remain the exclusive property of their creators, used under "fair use").</p> 
</footer>         

 <aside class="dxblock">
 <h3>Search by DX number
  <img src="dx_code.jpg" alt="Dx code picture"></h3>
            <form method="GET" action="rech.php">
                <p>&nbsp;<br>Please enter code (6 digits) : <br><input type="text" name="dx" minlength="6" maxlength="6" pattern="[0-9][0-9][0-9][0-9][0-9][0-9]" required> <input type="submit" value="Search"></p>
               
            </form>
</aside>
            
<article class="filmblock">
 <h3>Search by name
              <img src="films.jpg" alt="Funny films"></h3>
            <form method="GET" action="rechfilm.php">
                <p>Please enter film name (<b>one or two words</b>, please, like "brand filmname")<br> <input type="text" name="name" required> <input type="submit" value="Search"></p>
               
            </form>
</article> 
      
  <footer class="footer">
          <?php
          $lines = count(file('film_database.csv')) - 1;
          echo "<p><small>$lines films in database - v0.81";
          $zazar=rand (1, $lines);
          $file = new SplFileObject("film_database.csv");
if (!$file->eof()) {
     $file->seek($zazar);
     $contents = $file->current(); // $contents garde la bonne ligne
    }       
                    $l=explode(';',$contents);   
                    
    #        fclose($f);
        if (str_word_count($l[2], 0)>2)  {
                    $sefilm = substr(strstr($l[2]," "), 1);
                   # echo $sefilm;
                    } else {
                    $sefilm = $l[2];
                    }
                    $sefilm = preg_replace('/\s+/', '+', $sefilm);
                    
                    echo "<br>Random film for search engines : <a href='rechfilm.php?name=".$sefilm."'>".$l[2]."<a>";

          ?>
            </small></p>
     <p><small>The Big Film Database is in beta version with no warranty. If you don't understand this page, <a href="help.html">read the help!!</a><br></small> </p>
</footer>         
</div>
    </body>
</HTML>
