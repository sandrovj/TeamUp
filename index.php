<!doctype html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="Generator" content="EditPlus®">
      <meta name="Author" content="">
      <meta name="Keywords" content="">
      <meta name="Description" content="">
      <link rel="stylesheet" type="text/css" href="teamup.css">
      <title>Document</title>
     </head>
    
    <body>

        <h1>TeamUp</h1>
        <hr width="85%">


        <?php
            lista_ultimos_eventos();
        ?>



        <table border="0" width="80%" align="center">

            <tr><td> <h3> Categorias </h3> </td> </tr>
            <tr>
                       <table width="80%" align="center">
                       <tr><td><a href=".\lista_eventos.php?cdesp=1"><img src=".\images\futebol1.jpg" width="208" height="160" border="0" alt=""> </a> </td>

                       <td><a href=".\lista_eventos.php?cdesp=2"><img src=".\images\voleibol1.jpg" width="208" height="160" border="0" alt=""> </a> </td>		   

                       <td><a href=".\lista_eventos.php?cdesp=3"><img src=".\images\tenis1.jpg" width="208" height="160" border="0" alt=""> </a> </td>		   

                       <td><a href=".\lista_eventos.php?cdesp=4"><img src=".\images\corrida1.jpg" width="208" height="160" border="0" alt=""> </a> </td></tr>

                       </table>
            </tr>
         </table>

        <?php
            Function lista_ultimos_eventos()
            {
                $host="localhost";
                //$host="dados.000webhost.com";
                $user="id3200529_admin";
                $pw="teamup";
                $db="id3200529_teamup";
                $query="SELECT a.cd_evnt, a.nm_evnt, DATE_FORMAT(a.dt_evnt, '%d-%m-%Y') as dt_evnt, b.nm_img FROM eventos a, imagem_esporte b where a.cd_img_evnt = b.cd_img LIMIT 4";
                $link = mysqli_connect($host, $user, $pw, $db);
                /* check connection */
                if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                }
                $rs=mysqli_query($link, $query);
                echo "<table border=0 width=\"80%\" align=\"center\">";
                echo "<tr><td> <h3> Eventos </h3> </td></tr>";
                echo "</table>";
                echo "<table border=0 width=\"80%\" align=\"center\">";
                echo "<tr> \n";
                  while ($row = $rs->fetch_assoc()) {
                        printf ("<td width=\"110\">\n");
                        printf (" <table border=0>\n <tr> <td> <a href=\".\lista_participantes.php?cdevt=%d\"> %s <br> %s </a></td> </tr>\n",  $row["cd_evnt"],  $row["nm_evnt"], $row["dt_evnt"]);
                        printf ("<tr> <td> <a href=\".\lista_participantes.php?cdevt=%d\"><img src=\"images/%s\" width=\"200\" height=\"150\" border=\"0\" alt=\"\">  </a> </td> </tr>\n </table>", $row["cd_evnt"], $row["nm_img"]);
                        printf ("</td>\n");
                    }
                echo "</tr></table>";
                echo "<hr width=\"85%\">";
                mysqli_close($link);
                return true;
            }
         ?>

    </body>
</html>