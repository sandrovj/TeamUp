<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link rel="stylesheet" type="text/css" href="teamup.css">
  <title>TeamUp - Esporte é saúde e cidadania</title>
 </head>
 <body>


	<h1>TeamUp</h1>
	<hr width="85%">


 <?php
	/*-------------------------------------------------------------------------------------*/
	/*obtem o código do esporte passado pelo metodo GET*/
	/*-------------------------------------------------------------------------------------*/
	if(isset($_GET["cdesp"])) $cdesp = $_GET["cdesp"]; else $cdesp = "0";
	
		$host="localhost";
		//$host="dados.000webhost.com";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";
		// echo $query;
		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}
		if($cdesp>0) {
			$query="SELECT * FROM eventos where cd_espt=$cdesp";
			$nmespt=obtem_nome_esporte($cdesp);
			echo "<table  width=\"80%\" align=\"center\"><tr><td> <h3> Eventos cadastrados na categoria $nmespt </h3> </td></tr></table>";
		}
		else
			$query="SELECT * FROM eventos";
		$rs=mysqli_query($link, $query);
		$nlinha=0;
		$bgcolor="CCCCCC";
		echo "<table width=\"80%\" align=\"center\">";
		  while ($row = $rs->fetch_assoc()) {
			  if ($nlinha==0) 
				  echo "<tr bgcolor=00ABBD> <td>Data do evento </td><td> Descrição </td> <td> Participantes confirmados </td><td> Máximo de participantes </td></tr> ";
				printf ("<tr bgcolor=%s> <td>%s </td><td><a href=.\lista_participantes.php?cdevt=%d> (%s)</a></td> <td> (%d)</td><td> (%d)</td> </tr>", $bgcolor, $row["dt_evnt"], $row["cd_evnt"], $row["nm_evnt"], $row["qt_prtc_min"], $row["qt_prtc_max"]);
				($nlinha % 2? $bgcolor="CCCCCC": $bgcolor="BBBBBB");
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
