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
	<hr width="85%">

 <?php
	/*-------------------------------------------------------------------------------------*/
	/*obtem os parâmetros passados pelo metodo POST*/
	/*-------------------------------------------------------------------------------------*/
	if(isset($_POST["nmpart"])) $nmpart = $_POST["nmpart"]; else $nmevt = "VAZIO";
	if(isset($_POST["empart"])) $empart = $_POST["empart"]; else $empart = "VAZIO";
	if(isset($_POST["telpart"])) $telpart = $_POST["telpart"]; else $telpart = "VAZIO";
	if(isset($_POST["cdevt"])) $cdevt = $_POST["cdevt"]; else $cdevt = "VAZIO";

	insere_participante($cdevt, $nmpart, $empart, $telpart);
	
	?>

	<?php
	

	Function insere_participante($cdevt, $nmpart, $empart, $telpart)
	{
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

			
	// verifica se há vagas para inscrição no evento
		$qtdvagas=Get_numero_vagas($cdevt);
		if($qtdvagas > 0 )
		{
		// verifica se o email do atleta já esta inserido na tabela de atletas, senão insere os dados nessa tabela

			if (!$cdatl=Get_codigo_atleta($empart))
				$cdatl=Insere_atleta($empart, $nmpart, $telpart);

			// insere um registro na tabela de relacionamento entre eventos e atletas participantes
			if(	$res=Set_participante_evento($cdatl, $cdevt))
			{
				echo"<p> Inscrição efetuada com sucesso.";
				Set_numero_vagas($cdevt);
                if (Atingiu_quorum_minimo($cdevt))
                    Envia_email_confirmacao($cdevt);
			}
            else
                echo"<p> Inscrição não efetuada. Verifique se o atleta já está inscrito no evento.";
		}
		else
			echo "<p>O numero máximo de participantes para esse evento já foi atingido.";

		echo "<hr width=\"85%\">";
		echo "<p><a href=.\detalha_evento.php?cdevt=$cdevt> Voltar para a página do evento </a>";

	}
//--------------------------------------------
     
    function Envia_email_confirmacao($cdevt){

            
        $host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		if($cdevt>0) 
		{
            $query="SELECT a.nm_evnt, a.lc_evnt, DATE_FORMAT(a.dt_evnt, '%d/%m') as dt_evnt, a.hr_evnt, b.email_atlt FROM eventos a, atletas b, atlt_prtc_evnt c WHERE a.cd_evnt = c.cd_evnt and b.cd_atlt=c.cd_atlt and a.cd_evnt=$cdevt ";

            $link = mysqli_connect($host, $user, $pw, $db);
            /* check connection */
            if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
            }

            $rs=mysqli_query($link, $query);
            $nlinha=0;
            $to="";
            while ($row = $rs->fetch_assoc()) {
                 if($nlinha>0)
                    $to=$to . ", ";
                else{
                    $nmevt=$row["nm_evnt"];
                    $lcevt=$row["lc_evnt"];
                    $dtevt=$row["dt_evnt"];
                    $hrevt=$row["hr_evnt"];
                }
                 $to=$to . $row["email_atlt"];
                 $nlinha++;
            }
            envia_email($cdevt, $to, $nmevt, $lcevt, $dtevt, $hrevt);
        
        }
		else
			echo "Não localizado o código do evento.";
		return true;
    }
   //----------------------------------------------  
      function envia_email($cdevt, $emprt, $nmevt, $lcevt, $dtevt, $hrevt){
         
        $from = "teamupowner@gmail.com";
         
        $to  = $emprt; 
        
        $text = trim($emprt);
        $textAr = explode("\n", $text);
        $textAr = array_filter($textAr, 'trim'); // remove any extra \r characters left behind

        
        $subject = "TeamUP - Evento confirmado: $nmevt";

        $message = '<html>
            <head>
                <title>O evento $nmevt está confirmado e sua participação está garantida!'.$nmevt.'</title>
            </head>
                <body>
                    <p>Evento confirmado:<strong>'.$nmevt.'</strong></p>
                    <table>
                        <tr>
                            <td>Data do evento: </td><td>'.$dtevt.'</td>
                        </tr>
                        <tr>
                            <td>Local do evento: </td><td>'.$lcevt.'</td>
                        </tr>
                    </table>
                    <p>Para mais detalhes sobre o evento, clique <a href="http://team-up.000webhostapp.com/detalha_evento.php?cdevt='.$cdevt.'">aqui</a>.</p>
                </body>
            </html>
        ';
        printf($message);

       $headers  = 'MIME-Version: 1.0' . "\r\n";
       $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
       $headers .= 'From: TeamUp <teamupowner@gmail.com>' . "\r\n";

        Mail ($to, $subject, $message, $headers);

        Echo "A mensagem de e-mail foi enviada.";         
     }
     
    
     
     
//--------------------------------------------
     	function Atingiu_quorum_minimo($cdevt)
	{
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";
        $res=false;

		$query="SELECT qt_prtc_insc, qt_prtc_min from eventos where cd_evnt=$cdevt";

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
				$qtinsc=$row[0];
                $qtmin=$row[1];
                $res=$qtinsc>=$qtmin;
			}
			else {
				//erro na execução da query
				printf ("<p>Erro na execução da query para localizar o atleta na tabela - É preciso fazer a inscrição");
				//	$cdatlt=insere_atleta($empart, $nmpart, $telpart);
			}
		mysqli_close($link);
		return ($res);
	}
//--------------------------------------------
	Function Get_codigo_atleta($empart)
	{
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		$query="SELECT cd_atlt from atletas where email_atlt = \"$empart\"";

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
				$cdatlt=$row[0];
			}
			else {
				//erro na execução da query
				printf ("<p>Erro na execução da query para localizar o atleta na tabela - É preciso fazer a inscrição");
				//	$cdatlt=insere_atleta($empart, $nmpart, $telpart);
			}
		mysqli_close($link);
		//echo "<p>Resultado: $cdatlt";
		return $cdatlt;
	}

	Function Insere_atleta($empart, $nmpart, $telpart)
	{
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		$query="INSERT into atletas(email_atlt, nm_atlt, tel_atlt) VALUES (\"$empart\", \"$nmpart\", \"$telpart\")";

		//echo "<p> $query";

		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}

		$rs=mysqli_query($link, $query);
			if($rs){
			    printf ("<p>Atleta inserido com sucesso");
				$cdatlt=Get_codigo_atleta($empart);
			}
			else {
				printf ("<p>Falha na inserção do atleta - codigo: %b", $rs);
				$result=false;
				$cdatlt=null;
			}
		mysqli_close($link);
		return $cdatlt;
	}

	Function Get_numero_vagas($cdevt)
	{
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		$query="SELECT qt_prtc_insc, qt_prtc_max from eventos where cd_evnt = $cdevt";

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
				$qt_prtc_insc=$row[0];
				$qt_prtc_max=$row[1];
		//		echo "<p> Quantidade de participantes: Max= $qt_prtc_max / Inscritos= $qt_prtc_insc";
				$qtvagas=($qt_prtc_insc < $qt_prtc_max);
			}
			else {
				//inserir o registro na tabela
				printf ("<p>Não foi possivel verificar o numero de participantes");
				$qtvagas=0;			
			}

		mysqli_close($link);
		return $qtvagas;
	}
	

	
	
	Function Set_participante_evento($cdatlt, $cdevt)
	{
		$result=true;

		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";

		$query="INSERT into atlt_prtc_evnt(cd_atlt, cd_evnt) VALUES ($cdatlt, $cdevt)";

		//echo "<p> $query";

		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}

		$rs=mysqli_query($link, $query);
			if($rs)
			    printf ("<p>Participante inserido com sucesso");
			else {
				printf ("<p>Falha na inserção do participante - codigo: %b", $rs);
				$result=false;
				}
		mysqli_close($link);
		return $result;
	}

	Function Set_numero_vagas($cdevt)
	{
		$result=true;

		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";
		$query="UPDATE eventos set qt_prtc_insc = qt_prtc_insc + 1 where cd_evnt=$cdevt";

		$link = mysqli_connect($host, $user, $pw, $db);
		/* check connection */
		if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
		}

		$rs=mysqli_query($link, $query);
			if($rs)
			    printf ("<p>Numero de participantes atualizado com sucesso");
			else {
				printf ("<p>Falha na atualização do numero de participantes - codigo: %b", $rs);
				$result=false;
				}
		mysqli_close($link);
		return $result;
	}
	
	?>
 </body>
</html>

