<!DOCTYPE html>
<html>
<head>
<title>Menu de Opções</title>
<meta http-equiv="refresh" content="1" />
<style>
body {
  font-family: sans-serif;
}
nav {
  background-color: #f2f2f2;
  padding: 10px;
  text-align: center;
}
nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
nav li {
  display: inline;
  margin: 0 10px;
}
nav a {
  text-decoration: none;
  color: #333;
  padding: 5px 10px;
  border-radius: 5px;
}
nav a:hover {
  background-color: #ddd;
}

form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
label {
  display: block;
  margin-bottom: 5px;
}
input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}
input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
table {
  width: 60%; /* Largura da tabela */
  margin: 20px auto; /* Centraliza a tabela horizontalmente */
  border-collapse: collapse;
}
th, td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
th {
  background-color: #f2f2f2;
}
.error {
    color: red;
}
</style>

<script>
function formatarData() {
  const dataAtual = new Date();
  const ano = dataAtual.getFullYear();
  const mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
  const dia = String(dataAtual.getDate()).padStart(2, '0');
  const hora = String(dataAtual.getHours()).padStart(2, '0');
  const minuto = String(dataAtual.getMinutes()).padStart(2, '0');
  const segundo = String(dataAtual.getSeconds()).padStart(2, '0');

  document.getElementById("horarioBrasil").value = `${ano}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
}


function atualizarHorario() {
  const dataAtual = new Date();
  const ano = dataAtual.getFullYear();
  const mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
  const dia = String(dataAtual.getDate()).padStart(2, '0');
  const hora = String(dataAtual.getHours()).padStart(2, '0');
  const minuto = String(dataAtual.getMinutes()).padStart(2, '0');
  const segundo = String(dataAtual.getSeconds()).padStart(2, '0');

  document.getElementById("horarioBrasil").value = `${ano}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
}

// Chama a função para atualizar a hora inicialmente
atualizarHorario();

// Define um intervalo para atualizar a hora a cada segundo
setInterval(atualizarHorario, 10); 
</script>

</head>
<body onload="formatarData();atualizarHorario();">

<nav>
  <ul>
    <li><a href="index.php">Data e Hora Atual</a></li>
    <li><a href="agenda.php">Data Agendada</a></li>
    <li><a href="https://www.php.net/manual/en/timezones.php" target="_blank">Referência</a></li>
  </ul>
</nav>

<h1>Conversor de Horários</h1>

<?php

function gerarHorariosDateTime($horarioBrasil) {
  try {
    $dateTimeBrasil = new DateTime($horarioBrasil, new DateTimeZone('America/Sao_Paulo')); // Define o fuso horário do Brasil

    $dateTimeFlorida = clone $dateTimeBrasil;
    $dateTimeFlorida->setTimezone(new DateTimeZone('America/New_York')); // Fuso horário da Flórida (pode variar dependendo da região)

    $dateTimeMocambique = clone $dateTimeBrasil;
    $dateTimeMocambique->setTimezone(new DateTimeZone('Africa/Maputo'));

    $dateTimePortugal = clone $dateTimeBrasil;
    $dateTimePortugal->setTimezone(new DateTimeZone('Europe/Lisbon'));

    $dateTimeLosAngeles = clone $dateTimeBrasil;
    $dateTimeLosAngeles->setTimezone(new DateTimeZone('America/Los_Angeles'));

    return [
      "Brasil" => $dateTimeBrasil->format('Y-m-d H:i:s'),
      "Florida" => $dateTimeFlorida->format('Y-m-d H:i:s'),
      "Mocambique" => $dateTimeMocambique->format('Y-m-d H:i:s'),
      "Portugal" => $dateTimePortugal->format('Y-m-d H:i:s'),
      "Los Angeles" => $dateTimeLosAngeles->format('Y-m-d H:i:s')
    ];
  } catch (Exception $e) {
    return "Erro ao processar o horário: " . $e->getMessage();
  }
}

// Exemplo de uso:
date_default_timezone_set('America/Sao_Paulo'); 
$horarioBrasil = date('Y-m-d H:i:s');
$horarios = gerarHorariosDateTime($horarioBrasil);

if(is_array($horarios)){
    echo "<h2>Horários:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Local</th><th>Horário</th></tr>";
    foreach ($horarios as $local => $horario) {
        $dataHora = DateTime::createFromFormat('Y-m-d H:i:s', $horario);
        $formato = ($local == 'Brasil' || $local == 'Portugal') ? 'd/m/Y H:i:s' : 'd/m/Y h:i:s A'; //Formato com AM/PM para Florida e Moçambique
        echo "<tr><td>$local</td><td>" . $dataHora->format($formato) . "</td></tr>";
    }
    echo "</table>";
} else {
  echo $horarios;
}

?>

</body>
</html>