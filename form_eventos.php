<!doctype html>
<html lang="pt-BR">
 <head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="teamup.css">
 </head>
 <body>

	<header>
        <a id="logo-topo" href=index.php><img src="images/logo.jpg" width="246" height="70" border="0"></a>
        <a class="botao-topo" href=form_eventos.php>Crie seu evento</a>
        <a class="botao-topo" href=lista_eventos.php?cdesp=0>Veja os eventos disponiveis</a> 
            
    </header>

	<form id="form-criacao" method="POST" action=".\gravar_evento.php">
	<table width="80%" align="center" border="0" class="a">
		<tr><td colspan="2"><h3> Criar um novo evento </h3></td></tr>
        <tr><td align="rigth"> <strong> Nome:</strong></td> <td><input type="text" name="nmevt" size="60" required></td></tr>
        <tr><td align="rigth"> <strong>Local: </strong></td> <td><input type="text" name="lcevt" size="60" required></td></tr>
        <tr><td align="rigth"> <strong>Organizador (e-mail): </strong></td> <td><input type="email" name="emorg" size="60" required></td></tr>
        <tr><td> <strong>Data:</strong> </td> <td>	<input type="date" name="dtevt" size="10" required></td></tr>
        <tr><td> <strong>Horário:</strong> </td> <td>	<input type="time" name="hrevt" size="10" required></td></tr>
        <tr><td> <strong>Participantes (máximo): </strong></td> <td>	<input type="text" name="qtprt" size="3" required></td></tr>
        <tr><td> <strong>Modalidade esportiva: </strong></td> <td>	<select name="cdesp" >
				<option value="1" label="FUTEBOL" selected> Futebol </option>
				<option value="2" label="VOLEIBOL"> Voleibol </option>
				<option value="3" label="TENIS">Tenis </option>
				<option value="4" label="CORRIDA">Corrida </option>
                <option value="5" label="BASQUETE" selected> Basquete </option>
				<option value="6" label="TENIS DE MESA"> Tenis de Mesa </option>
				<option value="7" label="SKATE">Skate </option>
				<option value="8" label="CICLISMO"> Ciclismo </option>
                <option value="9" label="ARTES MARCIAIS" selected> Artes Marciais </option>
				<option value="10" label="AUTOMOBILISMO"> Automobilismo </option>
				<option value="11" label="POKER">Poker </option>
				<option value="12" label="OUTROS ESPORTES">Outros Esportess </option>
			</select></td></tr>
        <tr><td align="rigth"> <strong>Convidar amigos (e-mail)</strong>: </td> <td> <textarea cols=60 rows="5" name="cnvds" maxlength="500" wrap="hard" placeholder="Informe o email dos convidados separados por vírgula"></textarea></td></tr>
		<tr><td>  </td> <td><input type="submit" value="Confirmar">	<input type="reset" value="Cancelar"></td></tr>
	</table>
	</form>
 </body>
</html>

