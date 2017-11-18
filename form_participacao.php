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
	if(isset($_GET["cdevt"])) $cdevt = $_GET["cdevt"]; else $cdevt = 0;



	echo "<form method=\"POST\" action=\".\manter_participante.php?cd_evt=$cdevt\">\n";

	echo "<table id=\"form-insc\" width=\"80%\" align=\"center\" border=\"0\" class=\"a\">\n";
	
	echo "<tr><td colspan=\"2\"><h3> Formulário de Inscrição </h3></td></tr>\n";
	echo "<tr><td align=\"rigth\"> E-mail de contato: </td> <td><input type=\"email\" name=\"empart\" size=\"60\" required></td></tr>\n";
	echo "<tr><td align=\"rigth\"> Nome do participante: </td> <td><input type=\"text\" name=\"nmpart\" size=\"60\" required></td></tr>\n";
	echo "<tr><td> Telefone para contato: </td> <td>	<input type=\"tel\" name=\"telpart\" size=\"20\" required></td></tr>\n";
	echo "<tr><td>  </td> <td><input type=\"submit\" value=\"Confirmar\">	<input type=\"reset\" value=\"Cancelar\"></td></tr>\n";
	echo "</table>\n";
	echo "<input type=\"hidden\" name=\"cdevt\" value=\"$cdevt\">\n";
	echo "</form>\n";

 ?>
 </body>
</html>

