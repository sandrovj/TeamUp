<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="teamup.css"><title>Document</title>
    </head>
 
    <body>
        <header>
            <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
            <a id="createNew" class="botao-topo"'><img src="images/list%20(1).png" width="40" height="40" border="0"></a>
            <a class="botao-topo" href=lista_eventos.php?cdesp=0><img src="images/veja%20todos%20os%20eventos%20disponiveis2.png"></a> 
            <a class="botao-topo" href=form_eventos.php><img src="images/crie%20seu%20evento2.png"></a>
            
        </header>
        <hr width="85%">
    
    <?php
        if(isset($_POST["busca"])) $busca = $_POST["busca"]; else $busca = "";
        
        echo "<table  width=\"80%\" align=\"center\"><tr><td> <h3> Buscando por $busca </h3> </td></tr></table>";
        
        $host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

        $link = mysqli_connect($host, $user, $pw, $db);

		if (mysqli_connect_errno()) {
            printf("Conexão falhou: %s\n", mysqli_connect_error());
            exit();
		}
        else{
            $query = "SELECT * FROM eventos WHERE UCASE(nm_evnt) LIKE UCASE(\"%%$busca%%\") OR UCASE(lc_evnt) LIKE UCASE(\"%%$busca%%\")";
            
            $rs=mysqli_query($link, $query);
            
            $nlinha=0;
            $bgcolor="#808080";
            echo "<table width=\"80%\" align=\"center\">";
            
            while ($row = $rs->fetch_assoc()) {
			  if ($nlinha==0) 
				  echo "<tr bgcolor=#1b1b1b> <td>Data do evento </td><td> Descrição </td> <td> Participantes inscritos </td><td> Máximo de participantes </td></tr> ";
				printf ("<tr bgcolor=%s> <td>%s </td><td><a href=.\detalha_evento.php?cdevt=%d> %s</a></td> <td> %d</td><td> %d</td> </tr>", $bgcolor, $row["dt_evnt"], $row["cd_evnt"], $row["nm_evnt"], $row["qt_prtc_insc"], $row["qt_prtc_max"]);
				($nlinha % 2? $bgcolor="#808080": $bgcolor="#585858");
				$nlinha++;
			}
            echo "</table>";
		mysqli_close($link);
        }
        
        
    ?>
    </body>    
</html>