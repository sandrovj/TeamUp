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

	<h1>TeamUp</h1><a href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
	<hr width="85%">

	<form method="POST" action=".\gravar_evento.php">
	<table width="80%" align="center" border="0" class="a">
		<tr><td colspan="2"><h3> Criar um novo evento </h3></td></tr>
		<tr><td align="rigth"> Nome do evento: </td> <td><input type="text" name="nmevt" size="60" required></td></tr>
		<tr><td align="rigth"> Local do evento: </td> <td><input type="text" name="lcevt" size="60" required></td></tr>
		<tr><td align="rigth"> Organizador (e-mail): </td> <td><input type="email" name="emorg" size="60" required></td></tr>
		<tr><td> Data do evento: </td> <td>	<input type="date" name="dtevt" size="10" required></td></tr>
		<tr><td> Hora do evento: </td> <td>	<input type="time" name="hrevt" size="10" required></td></tr>
		<tr><td> Participantes (máximo): </td> <td>	<input type="text" name="qtprt" size="3" required></td></tr>
		<tr><td> Modalidade esportiva: </td> <td>	<select name="cdesp" >
				<option value="1" label="futebol" selected> Futebol </option>
				<option value="2" label="voleibol"> Voleibol </option>
				<option value="3" label="tenis">Tênis </option>
				<option value="4" label="corrida">Corrida </option>
			</select></td></tr>
		<tr><td>  </td> <td><input type="submit" value="Confirmar">	<input type="reset" value="Cancelar"></td></tr>
	</table>
	</form>
 </body>
</html>

