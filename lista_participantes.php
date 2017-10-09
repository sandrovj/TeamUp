<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link rel="stylesheet" type="text/css" href="teamup.css">
 </head>
 <body>

	<h1>TeamUp</h1>
	<hr width="85%">

 <?php
	/*-------------------------------------------------------------------------------------*/
	/*obtem o código do esporte passado pelo metodo GET*/
	/*-------------------------------------------------------------------------------------*/
	if(isset($_GET["cdevt"])) $cdevt = $_GET["cdevt"]; else $cdevt = "0";
	
	lista_detalhes($cdevt);
	lista_participantes($cdevt);
	form_inscricao($cdevt);
	?>

	<?php
	
	Function lista_detalhes($cdevt)
	{
		echo "<p> <b> detalhes do evento </b>\n";
		$host="localhost";
		//$host="dados.000webhost.com"
		$user="id3193059_admin";
		$pw="teamup";
		$db="id3193059_teamup";
		if($cdevt>0) 
			$query="SELECT * FROM eventos where cd_evnt=$cdevt";
		// echo $query;
		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}
		$rs=mysqli_query($link, $query);
		  while ($row = $rs->fetch_assoc()) {
			    printf ("<p>Nome do evento: %s </p> \n", $row["nm_evnt"]);
			    printf ("<p>Data do evento: %s </p> \n", $row["dt_evnt"]);
			    printf ("<p>Hora do evento: %s </p> \n", $row["hr_evnt"]);
			    printf ("<p>Local do evento: %s </p> \n", $row["lc_evnt"]);
			}
		mysqli_close($link);
		return true;
	}
	Function lista_participantes($cdevt)
	{
		$host="localhost";
		//$host="dados.000webhost.com";
		$user="id3193059_admin";
		$pw="teamup";
		$db="id3193059_teamup";
		if($cdevt>0) 
		{
			$query="SELECT nm_atlt FROM atletas a, atlt_prtc_evnt b where b.cd_evnt=$cdevt and a.cd_atlt=b.cd_atlt";
			$link = mysqli_connect($host, $user, $pw, $db);
			/* check connection */
			if (mysqli_connect_errno()) {
					printf("Connect failed: %s\n", mysqli_connect_error());
					exit();
			}
			$rs=mysqli_query($link, $query);
			$nlinha=0;
			$bgcolor="CCDDFF";
			echo "<table>";
			  while ($row = $rs->fetch_assoc()) {
				  if ($nlinha==0) 
					  echo "<tr bgcolor=CCABBD> <td> Participantes confirmados </td></tr> ";
					printf ("<tr bgcolor=%s> <td>%s </td></tr>\n", $bgcolor, $row["nm_atlt"]);
					($nlinha % 2? $bgcolor="CCDDFF": $bgcolor="CCCCEE");
					$nlinha++;
				}
			echo "</table>";
			mysqli_close($link); 
			if ($nlinha==0)
				echo "Não há participantes inscritos.";
		}
		else
			echo "Não localizado o código do evento.";
		return true;
	}
	Function form_inscricao($cdevt)
	{
		echo "<table>";
		echo " <tr><td><a href=\".\confirmar_participação.php?cdevt=$cdevt\">Confirmar participação </a> </td> ";
		echo " <td><a href=\".\cancelar_participação.php?cdevt=$cdevt\">Cancelar participação </a> </td></tr>";
		   
		echo "   </table>";
	}
	?>
 </body>
</html>