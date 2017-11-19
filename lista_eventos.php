<!doctype html>
<html lang="pt-BR">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link rel="stylesheet" type="text/css" href="teamup.css">
  <title>TeamUp</title>
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
	/*-------------------------------------------------------------------------------------*/
	/*obtem o código do esporte passado pelo metodo GET*/
	/*-------------------------------------------------------------------------------------*/
	if(isset($_GET["cdesp"])) $cdesp = $_GET["cdesp"]; else $cdesp = "0";
	


		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		$link = mysqli_connect($host, $user, $pw, $db);

		if (mysqli_connect_errno()) {
				printf("Conexão falhou: %s\n", mysqli_connect_error());
				exit();
		}

		if($cdesp>0) {
			$query="SELECT cd_evnt, nm_evnt, DATE_FORMAT(dt_evnt, '%d/%m') as dt_evnt, qt_prtc_insc, qt_prtc_min FROM eventos where cd_espt=$cdesp";
			$nmespt=obtem_nome_esporte($cdesp);
			echo "<table  width=\"80%\" align=\"center\"><tr><td> <h3> Eventos cadastrados na categoria $nmespt </h3> </td></tr></table>";
		}
		else
			$query="SELECT cd_evnt, nm_evnt, DATE_FORMAT(dt_evnt, '%d/%m') as dt_evnt, qt_prtc_insc, qt_prtc_min FROM eventos where dt_evnt >= current_date() ORDER BY dt_evnt ASC";

		$rs=mysqli_query($link, $query);
		$nlinha=0;
		$bgcolor="#585858";
        echo "<p id=\"proxevt\"> <strong>Próximos eventos </strong> </p>";
		echo "<table width=\"80%\" align=\"center\">";
		  while ($row = $rs->fetch_assoc()) {
			  if ($nlinha==0)
				echo "<tr bgcolor=#1b1b1b> <td>Data do evento </td><td> Descrição </td> <td> Participantes inscritos </td><td> Mínimo de participantes </td></tr> ";
				printf ("<tr bgcolor=%s> <td>%s </td><td><a href=.\detalha_evento.php?cdevt=%d> %s</a></td> <td> %d</td><td> %d</td> </tr>", $bgcolor, $row["dt_evnt"], $row["cd_evnt"], $row["nm_evnt"], $row["qt_prtc_insc"], $row["qt_prtc_min"]);
				($nlinha % 2? $bgcolor="#585858": $bgcolor="#808080");
				$nlinha++;
			}
		echo "</table>";
		mysqli_close($link);
 ?>

<?php
	Function obtem_nome_esporte($cdesp){

 		$host="localhost";
		//$host="dados.000webhost.com";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";
		$query="SELECT nm_espt FROM esportes where cd_espt=$cdesp";

		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}
		
		$rs=mysqli_query($link, $query);
		  while ($row = $rs->fetch_assoc()) {
				$nmespt = $row["nm_espt"];
				
			}
		mysqli_close($link);
		return $nmespt;
	}
?>


 
 </body>
</html>

