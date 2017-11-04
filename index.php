<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="teamup.css"><title>TeamUp</title>
    </head>
 
    <body>
        <header>
            <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
            <a class="botao-topo" href=form_eventos.php>Crie seu evento</a>
            <a class="botao-topo" href=lista_eventos.php?cdesp=0>Veja os eventos disponiveis</a> 
            
        </header>
    
        <div id="busca">
            <form method="POST" action=".\busca_eventos.php">
                <input id = "caixa-busca" type="search" name="busca" placeholder="Procurar por esporte ou localidade " size="40">
            </form>
        </div>
        
        <div id="lista-eventos">
            <?php
                lista_ultimos_eventos();
            ?>
            <hr width="85%">
        </div>

        <div id="categorias">
            <?php
                lista_categorias();
            ?>
            
        </div>

        <?php
            Function lista_ultimos_eventos()
            {


                $host="localhost";
                $user="id3200529_admin";
                $pw="teamup";
                $db="id3200529_teamup";

                $query="SELECT a.cd_evnt, a.nm_evnt, DATE_FORMAT(a.dt_evnt, '%d/%m') as dt_evnt, b.nm_img FROM eventos a, imagem_esporte b WHERE a.cd_img_evnt = b.cd_img ORDER BY a.cd_evnt DESC LIMIT 4";



                //Primeira tabela contem o Label, e os links para criar e listar eventos
                echo "<table border=0 width=\"80%\" align=\"center\">";
                echo "<tr><td> <h3> Proximos Eventos </h3> </td> <td align=\"center\"></tr>";
                echo "</table>";
                //---------------------------------------------------


                $link = mysqli_connect($host, $user, $pw, $db);
                if (mysqli_connect_errno()) {
                        printf("Conexão ao banco de dados falhou: %s\n", mysqli_connect_error());
                        exit();
                }

                $rs=mysqli_query($link, $query);

                //-----------------------------------------

                echo "<table border=0 width=\"80%\" align=\"center\">";
                echo "<tr> \n";
                  while ($row = $rs->fetch_assoc()) {
                        printf ("<td width=\"110\">\n");
                        printf (" <table class=\"dados-evt\" border=0>\n <tr> <td> <a href=\".\detalha_evento.php?cdevt=%d\"> <strong>%s <br> %s </strong></a></td> </tr>\n",  $row["cd_evnt"],  $row["nm_evnt"], $row["dt_evnt"]);
                        printf ("<tr> <td> <a href=\".\detalha_evento.php?cdevt=%d\"><img src=\"images/%s\" width=\"228\" height=\"171\" border=\"0\" alt=\"\">  </a> </td> </tr>\n </table>", $row["cd_evnt"], $row["nm_img"]);
                        printf ("</td>\n");
                    }
                echo "</tr></table>";
                mysqli_close($link);
                return true;
            }
        
            Function lista_categorias()
            {


                $host="localhost";
                $user="id3200529_admin";
                $pw="teamup";
                $db="id3200529_teamup";

                $query="SELECT a.cd_espt, a.nm_espt, b.nm_img_catg FROM esportes a, imagem_esporte b WHERE a.cd_espt = b.cd_img ORDER BY a.cd_espt ASC LIMIT 12";



                //Primeira tabela contem o Label, e os links para criar e listar eventos
                echo "<table border=0 width=\"80%\" align=\"center\">";
                echo "<tr><td> <h3> Categorias </h3> </td> <td align=\"center\"></tr>";
                echo "</table>";
                //---------------------------------------------------


                $link = mysqli_connect($host, $user, $pw, $db);
                if (mysqli_connect_errno()) {
                        printf("Conexão ao banco de dados falhou: %s\n", mysqli_connect_error());
                        exit();
                }

                $rs=mysqli_query($link, $query);

                //-----------------------------------------

                echo "<table border=0 width=\"80%\" align=\"center\">";
                echo "<tr> ";
                  while ($row = $rs->fetch_assoc()) {

                        
                        
                        printf ("<td> <a href=\".\lista_eventos.php?cdesp=%d\"> <img src=\"images/%s\" width=\"64\" heigth=\"64\" border=\"0\" title=\"%s\" > </a> </td>\n",  $row["cd_espt"],  $row["nm_img_catg"], $row["nm_espt"]);
                        
                    }
                echo "</tr></table>";
                mysqli_close($link);
                return true;
            }
         ?>
        <footer>
            
        </footer>
    </body>
</html>

