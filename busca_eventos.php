<html lang="en">
    <head>
        <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="teamup.css"><title>Document</title>
    </head>
 
    <body>
        <header>
            <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
            <a class="botao-topo" href=form_eventos.php>Crie seu evento</a>
            <a class="botao-topo" href=lista_eventos.php?cdesp=0>Veja os eventos disponiveis</a>             
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
            $bgcolor="CCCCCC";
            echo "<table width=\"80%\" align=\"center\">";
            
            while ($row = $rs->fetch_assoc()) {
			  if ($nlinha==0) 
				  echo "<tr bgcolor=00ABBD> <td>Data do evento </td><td> Descrição </td> <td> Participantes inscritos </td><td> Máximo de participantes </td></tr> ";
				printf ("<tr bgcolor=%s> <td>%s </td><td><a href=.\detalha_evento.php?cdevt=%d> (%s)</a></td> <td> (%d)</td><td> (%d)</td> </tr>", $bgcolor, $row["dt_evnt"], $row["cd_evnt"], $row["nm_evnt"], $row["qt_prtc_insc"], $row["qt_prtc_max"]);
				($nlinha % 2? $bgcolor="CCCCCC": $bgcolor="BBBBBB");
				$nlinha++;
			}
            echo "</table>";
		mysqli_close($link);
        }
        
        
    ?>
    </body>    
</html>