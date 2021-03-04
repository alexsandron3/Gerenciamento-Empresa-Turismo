<?php
  //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
  include_once("../includes/header.php");

   /* -----------------------------------------------------------------------------------------------------  */



   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, p.dataPasseio ,c.nomeCliente, c.idadeCliente, c.referencia, c.idCliente, pp.anotacoes, pp.localEmbarque
                          FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) ORDER BY localEmbarque";
     #echo $buscaPeloIdPasseio;

   

   /* -----------------------------------------------------------------------------------------------------  */
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);
   /* -----------------------------------------------------------------------------------------------------  */

  $quantidadeClientes = mysqli_num_rows($setRec);
  $dados = '';
  echo mb_convert_encoding( "NOME" . "\t". "IDADE" ."\t". "REFERENCIA". "\t". "PONTO DE EMBARQUE" . "\t". "ANOTAÇÕES". "\n","UTF-16LE","UTF-8");
	/* -----------------------------------------------------------------------------------------------------  */
  
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
    $anotacoes = $rowDados['anotacoes'];


    $dados= $nomeCliente . "\t". $idade. "\t" .$referencia ."\t". $localEmbarque. "\t". $anotacoes . "\n"; 
    $dados = mb_convert_encoding($dados, "UTF-16LE","UTF-8");

    print $dados;

  }
	/* -----------------------------------------------------------------------------------------------------  */

  header('Content-Encoding: UTF-8');
  header('Content-type: text/csv; charset=UTF-8');

  header('Content-Disposition: attachment; filename='.$filename.'.xls');
?> 