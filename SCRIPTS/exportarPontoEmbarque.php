<?php
   session_start();
   header("Content-type: text/html; charset=utf-8");
   include_once("../PHP/conexao.php");
   include_once("../PHP/functions.php");
    //echo "<pre>";
   /* -----------------------------------------------------------------------------------------------------  */



   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, p.dataPasseio ,c.nomeCliente, c.idadeCliente, c.referencia, c.idCliente, pp.localEmbarque
                          FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente ORDER BY localEmbarque";
     #echo $buscaPeloIdPasseio;

   

   /* -----------------------------------------------------------------------------------------------------  */
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);
   /* -----------------------------------------------------------------------------------------------------  */

  $quantidadeClientes = mysqli_num_rows($setRec);
  $dados = '';
  echo "NOME" . "\t". "IDADE" ."\t". "REFERENCIA". "\t". "PONTO DE EMBARQUE" . "\n";
  
  while($rowDados = mysqli_fetch_array($setRec)){
    $nomePasseio = $rowDados['nomePasseio'];
    $nomePasseioSubstituto = str_replace(" ", $nomePasseio, "_");
    $dataPasseio = date_create($rowDados['dataPasseio']);
    $filename = "PONTOS DE EMBARQUE_".$nomePasseio. $nomePasseioSubstituto. "". date_format($dataPasseio, "d/m/Y");

    $comecoContador = 1;
    $nomeCliente = $rowDados['nomeCliente'];
    $localEmbarque = $rowDados['localEmbarque'];
    $idCliente = $rowDados['idCliente'];
    $idade = calcularIdade($idCliente, $conn, "");
    $referencia = $rowDados['referencia'];


    $dados= $nomeCliente . "\t". $idade. "\t" .$referencia ."\t". $localEmbarque. "\n"; 
    print $dados;

  }

header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');

header('Content-Disposition: attachment; filename='.$filename.'.xls');
?> 