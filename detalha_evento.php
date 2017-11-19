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

	<header>
            <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
            <a id="createNew" class="botao-topo"'><img src="images/list%20(1).png" width="40" height="40" border="0"></a>
            <a class="botao-topo" href=lista_eventos.php?cdesp=0><img src="images/veja%20todos%20os%20eventos%20disponiveis2.png"></a> 
            <a class="botao-topo" href=form_eventos.php><img src="images/crie%20seu%20evento2.png"></a>
            
        </header>
	<hr width="80%">

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

		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

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
		  while ($row = $rs->fetch_assoc()) {;
			    printf ("<p class=\"detevt\"><b>Detalhes do evento  %s </b></p> \n", $row["nm_evnt"]);
			    printf ("<p class=\"detevt\">Data: %s </p> \n", $row["dt_evnt"]);
			    printf ("<p class=\"detevt\">Hora: %s </p> \n", $row["hr_evnt"]);
			    printf ("<p class=\"detevt\">Local: %s </p> \n", $row["lc_evnt"]);
			}
        
		mysqli_close($link);
		return true;
	}

	Function lista_participantes($cdevt)
	{
		$host="localhost";
		//$host="dados.000webhost.com";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

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
			$bgcolor="#808080";
			echo "<table class=detevt>";
			  while ($row = $rs->fetch_assoc()) {
				  if ($nlinha==0) 
					  echo "<tr bgcolor=#1b1b1b> <td> Participantes confirmados </td></tr> ";
					printf ("<tr bgcolor=%s> <td>%s </td></tr>\n", $bgcolor, $row["nm_atlt"]);
					($nlinha % 2? $bgcolor="#808080": $bgcolor="#585858");
					$nlinha++;
				}
			echo "</table>";
			mysqli_close($link); 
			if ($nlinha==0)
				echo "<p class=detevt> Não há participantes inscritos.<p>";
		}
		else
			echo "<p class=detevt>Não localizado o código do evento.<p>";
		return true;
	}

	Function form_inscricao($cdevt)
	{
		echo "<table class=detevt>";
		echo " <tr><td><a href=\".\\form_participacao.php?cdevt=$cdevt&cdmnt=1\"><img src=\"images/participar.png\"></a> </td> ";
		   
		echo "   </table>";
	}
	?>
 </body>
</html>

