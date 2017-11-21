<!doctype html>
<html lang="pt-BR">
 <head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="teamup.css">
 </head>
 <body>

	<header>
            <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
            <a id="createNew" class="botao-topo"'><img src="images/list%20(1).png" width="40" height="40" border="0"></a>
            <a class="botao-topo" href=lista_eventos.php?cdesp=0><img src="images/veja%20todos%20os%20eventos%20disponiveis2.png"></a> 
            <a class="botao-topo" href=form_eventos.php><img src="images/crie%20seu%20evento2.png"></a>
            
        </header>

 <?php
	/*-------------------------------------------------------------------------------------*/
	/*obtem o código do esporte passado pelo metodo POST*/
	/*-------------------------------------------------------------------------------------*/
	if(isset($_POST["nmevt"])) $nmevt = $_POST["nmevt"]; else $nmevt = "VAZIO";
	if(isset($_POST["lcevt"])) $lcevt = $_POST["lcevt"]; else $lcevt = "VAZIO";
	if(isset($_POST["dtevt"])) $dtevt = $_POST["dtevt"]; else $dtevt = "VAZIO";
	if(isset($_POST["hrevt"])) $hrevt = $_POST["hrevt"]; else $hrevt = "VAZIO";
    if(isset($_POST["minpt"])) $minpt = $_POST["minpt"]; else $minpt = "VAZIO";
	if(isset($_POST["maxpt"])) $maxpt = $_POST["maxpt"]; else $maxpt = "VAZIO";
	if(isset($_POST["cdesp"])) $cdesp = $_POST["cdesp"]; else $cdesp = "VAZIO";
	if(isset($_POST["emorg"])) $emorg = $_POST["emorg"]; else $emorg = "VAZIO";
    if(isset($_POST["cnvds"])) $cnvds = $_POST["cnvds"]; else $cnvds = "VAZIO";

	printf("<div id=\"tela-gravar\">");
    printf("<p> <b> DETALHES DO EVENTO</b>\n");
	printf("<p> Nome do evento: %s \n", $nmevt);
	printf("<p> Local do evento: %s \n", $lcevt);
	printf("<p> Data do evento: %s \n", $dtevt);
	printf("<p> Hora do evento: %s \n", $hrevt);
    printf("<p> Mínimo de participantes: %s \n", $minpt);
	printf("<p> Máximo de participantes: %s \n", $maxpt);
	printf("<p> Código da modalidade: %s \n", $cdesp);
	printf("<p> e-mail do organizador: %s \n", $emorg);

	grava_evento($nmevt, $lcevt, $dtevt, $hrevt, $cdesp, $emorg, $minpt ,$maxpt);
    $cdevt = Get_codigo_evento($nmevt,$dtevt);
    envia_convites($nmevt, $lcevt, $dtevt, $hrevt,$cnvds,$cdevt);
	 printf("</div>");
    ?>

	<?php
	
	Function grava_evento($nmevt, $lcevt, $dtevt, $hrevt, $cdesp, $emorg, $minpt, $maxpt)
	{

		$host="localhost";
		//$host="dados.000webhost.com"
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

					//	$query="SELECT * FROM eventos where cd_evnt=$cdevt";
		$query="INSERT into eventos(nm_evnt, lc_evnt, dt_evnt, hr_evnt, cd_espt, em_orgn, qt_prtc_min ,qt_prtc_max, cd_img_evnt) VALUES (\"$nmevt\", \"$lcevt\", date(\"$dtevt\"), time(\"$hrevt\"), $cdesp, \"$emorg\", $minpt ,$maxpt, $cdesp)";
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
			    printf ("<p><b>Evento Registrado!</b>");
			else 
				printf ("<p>Falha na inserção do registro - codigo: %b", $rs);
		mysqli_close($link);
		return true;
	}
     
     Function envia_convites($nmevt, $lcevt, $dtevt, $hrevt,$cnvds,$cdevt){
         
        $from = "teamupowner@gmail.com";
         
        $to  = ''; 
        
        $text = trim($cnvds);
        $textAr = explode("\n", $text);
        $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

        foreach ($textAr as $line) {
            $to .= $line.',';
        } 
 

        $subject = "TeamUP - Você foi convidado para um evento!";

        $message = '<html>
            <head>
                <title>Você foi convidado para o evento '.$nmevt.'</title>
            </head>
                <body>
                    <p>Você foi convidado para o evento <strong>'.$nmevt.'</strong></p>
                    <table>
                        <tr>
                            <td>Data do evento: </td><td>'.$dtevt.'</td>
                        </tr>
                        <tr>
                            <td>Local do evento: </td><td>'.$lcevt.'</td>
                        </tr>
                    </table>
                    <p>Para se inscrever no evento, clique <a href="http://team-up.000webhostapp.com/detalha_evento.php?cdevt='.$cdevt.'">aqui</a>.</p>
                </body>
            </html>
        ';

       $headers  = 'MIME-Version: 1.0' . "\r\n";
       $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
       $headers .= 'From: TeamUp <teamupowner@gmail.com>' . "\r\n";

        Mail ($to, $subject, $message, $headers);
         
     }
     
     Function Get_codigo_evento($nmevt,$dtevt)
	{
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		$query="SELECT cd_evnt from eventos where nm_evnt = \"$nmevt\" AND dt_evnt=\"$dtevt\"";

		//echo "<p> $query";

		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}

		$rs=mysqli_query($link, $query);
			if($rs)
			{
				$row = $rs->fetch_row();
				$cdevt=$row[0];
			}
			else {
				//erro na execução da query
				printf ("<p>Erro na execução da query para localizar o atleta na tabela - É preciso fazer a inscrição");
				//	$cdatlt=insere_atleta($empart, $nmpart, $telpart);
			}
		mysqli_close($link);
		//echo "<p>Resultado: $cdatlt";
		return $cdevt;
	}
	?>
 </body>
</html>

