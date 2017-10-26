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

	<a href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
	<hr width="85%">

 <?php
	/*-------------------------------------------------------------------------------------*/
	/*obtem o código do esporte passado pelo metodo POST*/
	/*-------------------------------------------------------------------------------------*/
	if(isset($_POST["nmevt"])) $nmevt = $_POST["nmevt"]; else $nmevt = "VAZIO";
	if(isset($_POST["lcevt"])) $lcevt = $_POST["lcevt"]; else $lcevt = "VAZIO";
	if(isset($_POST["dtevt"])) $dtevt = $_POST["dtevt"]; else $dtevt = "VAZIO";
	if(isset($_POST["hrevt"])) $hrevt = $_POST["hrevt"]; else $hrevt = "VAZIO";
	if(isset($_POST["qtprt"])) $qtprt = $_POST["qtprt"]; else $qtprt = "VAZIO";
	if(isset($_POST["cdesp"])) $cdesp = $_POST["cdesp"]; else $cdesp = "VAZIO";
	if(isset($_POST["emorg"])) $emorg = $_POST["emorg"]; else $emorg = "VAZIO";

	
	printf("<p> Nome do evento: %s \n", $nmevt);
	printf("<p> Local do evento: %s \n", $lcevt);
	printf("<p> Data do evento: %s \n", $dtevt);
	printf("<p> Hora do evento: %s \n", $hrevt);
	printf("<p> Qtde de participantes: %s \n", $qtprt);
	printf("<p> Código da modalidade: %s \n", $cdesp);
	printf("<p> e-mail do organizador: %s \n", $emorg);

	grava_evento($nmevt, $lcevt, $dtevt, $hrevt, $cdesp, $emorg, $qtprt);
	
	?>

	<?php
	
	Function grava_evento($nmevt, $lcevt, $dtevt, $hrevt, $cdesp, $emorg, $qtprt)
	{
		echo "<p> <b> detalhes do evento </b>\n";

		$host="localhost";
		//$host="dados.000webhost.com"
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

					//	$query="SELECT * FROM eventos where cd_evnt=$cdevt";
		$query="INSERT into eventos(nm_evnt, lc_evnt, dt_evnt, hr_evnt, cd_espt, em_orgn, qt_prtc_max, cd_img_evnt) VALUES (\"$nmevt\", \"$lcevt\", date(\"$dtevt\"), time(\"$hrevt\"), $cdesp, \"$emorg\", $qtprt, $cdesp)";
		//**lembrete -> ajustar codigo da imagem, para permitir upload pelo usuário

		//echo $query;

		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}

		$rs=mysqli_query($link, $query);
			if($rs)
			    printf ("<p>Registro inserido com sucesso");
			else 
				printf ("<p>Falha na inserção do registro - codigo: %b", $rs);
		mysqli_close($link);
		return true;
	}

	
	?>
 </body>
</html>

