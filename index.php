<?php
  $dados = array(array('Campo A:', 'Campo B:', 'Campo C:'));
  if (isset($_POST['salvar'])) {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="Planilha para preenchimento.csv";');
    $planilha = fopen('php://output', 'w');
    foreach($dados as $linha)
      fputcsv($planilha, $linha, ';');
    exit;
  } else if (isset($_POST['abrir'])) {
    $dados = array();
    if ($planilha = fopen($_FILES['arquivos']['tmp_name'], 'r'))
      while ($linha = fgetcsv($planilha, 0, ';'))
        array_push($dados, $linha);
  }
  $tabela = '<table border="1">' . implode(array_map(fn($linha) => '<tr><td>' . implode('</td><td>', $linha) . '</td></tr>', $dados)) . '</table>';
?>
<!DOCTYPE html>
<html>
  <head><title>Exemplo de preenchimento de dados via planilha</title></head>
  <body>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="submit" value="Obter planilha para preenchimento" name="salvar"><br>
      <input type="button" value="Enviar planilha preenchida" onclick="document.getElementById('carregador').click()"><br>
      <input type="file" id="carregador" name="arquivos" style="display: none" onchange="document.getElementById('envio').click()" accept=".csv">
      <input type="submit" id="envio" name="abrir" style="display: none">
      <?= $tabela ?>
    </form>
  </body>
</html>
