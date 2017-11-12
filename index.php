<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="teamup.css">
            <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
            <link rel="stylesheet" type="text/css" href="jquery-ui-1-8-11.css">
            <title>TeamUp</title>
    </head>
 
    <body>

 <?php
	// Tratamento dos cookies, referentes à preferencia do usuário
	 $stesp="";
		if(isset($_GET["filter"]) || !isset($_COOKIE['teamup-ctrl'])) {
		if(isset($_GET["esp1"])) $stesp = $_GET["esp1"].", "; else $stesp = "";
		if(isset($_GET["esp2"])) $stesp = $stesp.$_GET["esp2"].", "; 
		if(isset($_GET["esp3"])) $stesp = $stesp.$_GET["esp3"].", "; 
		if(isset($_GET["esp4"])) $stesp = $stesp.$_GET["esp4"].", "; 
		if(isset($_GET["esp5"])) $stesp = $stesp.$_GET["esp5"].", "; 
    	if(isset($_GET["esp6"])) $stesp = $stesp.$_GET["esp6"].", "; 
    	if(isset($_GET["esp7"])) $stesp = $stesp.$_GET["esp7"].", "; 
    	if(isset($_GET["esp8"])) $stesp = $stesp.$_GET["esp8"].", "; 
    	if(isset($_GET["esp9"])) $stesp = $stesp.$_GET["esp9"].", "; 
    	if(isset($_GET["esp10"])) $stesp = $stesp.$_GET["esp10"].", "; 
    	if(isset($_GET["esp11"])) $stesp = $stesp.$_GET["esp11"].", "; 
    	if(isset($_GET["esp12"])) $stesp = $stesp.$_GET["esp12"].", "; 
		$stesp=substr($stesp, 0, strlen($stesp)-2);
		
		$r1=setcookie("teamup-ctrl[1]", "usr", time()+300); //id do usuário (e-mail)
		$r2=setcookie("teamup-ctrl[2]", $stesp, time()+300); // string com os codigos dos esportes preferidos pelo usuáio;
		//echo "Resultado da criação dos cookies: $r1 + $r2; cdusr: usr, cdesp setado para: $stesp";
	 }
	else{
		// retornos seguintes à pagina
		if (isset($_COOKIE['teamup-ctrl'])) {
			foreach ($_COOKIE['teamup-ctrl'] as $name => $value) {
				$name = htmlspecialchars($name);
				$value = htmlspecialchars($value);
				//  echo "Leitura do cookie numero $name: $value <br />\n";
				if ($name=="2") $stesp = $value;
			}
		}
	}
	//echo "<p>Conteudo de stesp= $stesp </p>";
?> 


        <header>
            <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
            <a class="botao-topo" href=form_eventos.php>Crie seu evento</a>
            <a class="botao-topo" href=lista_eventos.php?cdesp=0>Veja todos os eventos disponiveis</a> 
            <a id="createNew" class="botao-topo"'><img src="images/list%20(1).png" width="40" height="40" border="0"></a>
            
        </header>
    
        <div id="busca">
            <form method="POST" action=".\busca_eventos.php">
                <input id = "caixa-busca" type="search" name="busca" placeholder="Procurar por esporte ou localidade " size="40">
            </form>
        </div>
        
        <div id="lista-eventos">
            <?php
                lista_ultimos_eventos($stesp);
            ?>
            <hr width="85%">
        </div>

        <div id="categorias">
            <?php
                lista_categorias();
            ?>
            
        </div>

<?php
	Function lista_ultimos_eventos($stesp)
	{

		
		$host="localhost";
		$user="id3200529_admin";
		$pw="teamup";
		$db="id3200529_teamup";
        
        if (empty($stesp))
		  $query="SELECT a.cd_evnt, a.nm_evnt, DATE_FORMAT(a.dt_evnt, '%d/%m') as dt_evnt, b.nm_img FROM eventos a, imagem_esporte b WHERE a.cd_img_evnt = b.cd_img ORDER BY a.cd_evnt DESC LIMIT 4";
        else{
            
            $query="SELECT a.cd_evnt, a.nm_evnt, DATE_FORMAT(a.dt_evnt, '%d-%m-%Y') as dt_evnt, b.nm_img FROM eventos a, imagem_esporte b WHERE a.cd_img_evnt = b.cd_img and a.cd_espt in ($stesp) ORDER BY a.cd_evnt DESC LIMIT 4";
        }

		
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

		//---------------
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
        
<?php
    Function montaDialogoEsportes(){

        $host="localhost";
        $user="id3200529_admin";
        $pw="teamup";
        $db="id3200529_teamup";
        $query="SELECT cd_espt, nm_espt FROM esportes";

        // echo $query;

        $link = mysqli_connect($host, $user, $pw, $db);
        /* check connection */
        if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
        }

        echo "var \$dialog = \$('<div></div>')";
        echo ".html('<form id=\"myform\" action=\"\"> <input type=\"hidden\" id=\"filter\" name=\"filter\" value=\"1\"/> <br />";
        $rs=mysqli_query($link, $query);
          while ($row = $rs->fetch_assoc()) {
              $nome=$row["nm_espt"];
              $cod=$row["cd_espt"];
              printf("<input type=\"checkbox\" id=\"%s\" name=\"esp%d\" value=\"%d\" />%s<br />",$nome, $cod, $cod, $nome );
            }
        mysqli_close($link);
        echo "</form>')";
        return true;

    //var $dialog = $('<div></div>')
    //    .html('<form id="myform" action=""> <input type="hidden" id="filter" name="filter" value="1" required/> <br /> <input type="checkbox" id="futebol" name="esp1" value="1" />Futebol<br /><input type="checkbox" name="esp2" value="2" /> Voleibol <br /><input type="checkbox" name="esp3" value="3" />Tênis<br /><input type="checkbox" name="esp4" value="4" />Corrida<br /><input type="checkbox" name="esp5" value="5" />Outros esportes<br /></form>')
    //
    }
     
?>

     
<script type="text/javascript">
    
	$(document).ready(function(){
    
    //Aciona a função para montar dinamicamente os esportes para a caixa de dialogo
    <?php
        montaDialogoEsportes();
    ?>
        .dialog({
        autoOpen: false,
        title: 'Informe seu email e modalidades preferidas',
        /*position: { my: "center top", at: "top center"},*/
        buttons: {
          "Confirmar": function() {  $('form#myform').submit();},
          "Cancelar": function() {$(this).dialog("close");}
        }
    });

	$('#createNew').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});

	$('form#myform').submit(function(){
		
	  $dialog.dialog('close');
	});        


	});
    
</script>

    </body>
</html>

