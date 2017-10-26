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
	if(isset($_GET["cdevt"])) $cdevt = $_GET["cdevt"]; else $cdevt = 0;



	echo "<form method=\"POST\" action=\".\manter_participante.php?cd_evt=$cdevt\">\n";

	echo "<table width=\"80%\" align=\"center\" border=\"0\" class=\"a\">\n";
	
	echo "<tr><td colspan=\"2\"><h3> Inscrição no evento: $cdevt - Codigo: $cdevt </h3></td></tr>\n";
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

