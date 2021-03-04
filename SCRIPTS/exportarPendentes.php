<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");
   /* -----------------------------------------------------------------------------------------------------  */
   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT  p.nomePasseio, p.dataPasseio , p.idPasseio, c.nomeCliente, c.idCliente, c.referencia, pp.valorPendente , pp.anotacoes, pp.statusPagamento
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0,1,3) ORDER BY nomeCliente";
  

  /* -----------------------------------------------------------------------------------------------------  */
  $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);
  /* -----------------------------------------------------------------------------------------------------  */

  $quantidadeClientes = mysqli_num_rows($setRec);
  $dados = '';
  echo mb_convert_encoding( "NOME" . "\t". "REFERÊNCIA" ."\t". "PAGTO. PENDEDNTE". "\t". "ANOTAÇOES". "\n","UTF-16LE","UTF-8");
	/* -----------------------------------------------------------------------------------------------------  */
  
  while($rowDados = mysqli_fetch_array($setRec)){
    if($rowDados['statusPagamento'] == 4 AND $rowDados['valorPendente'] == 0){

    }else{
        $nomePasseio = $rowDados['nomePasseio'];
        $nomePasseioSubstituto = str_replace(" ", $nomePasseio, "_");
        $dataPasseio = date_create($rowDados['dataPasseio']);
        $filename = "LISTA DE PASSAGEIROS_".$nomePasseio. $nomePasseioSubstituto. "". date_format($dataPasseio, "d/m/Y");

        $comecoContador = 1;
        $nomeCliente = $rowDados['nomeCliente'];
        $referencia = $rowDados['referencia'];
        $operador =($rowDados['valorPendente'] < 0) ? -1 : 1;
        $pagtoPendente = $rowDados['valorPendente'];
        $anotacoes = $rowDados['anotacoes'];



        $dados= $nomeCliente . "\t". $referencia. "\t" . number_format($pagtoPendente * $operador, 2, '.','') . "\t". $anotacoes."\n"; 
        $dados = mb_convert_encoding($dados, "UTF-16LE","UTF-8");

        print $dados;
    }

  }
	/* -----------------------------------------------------------------------------------------------------  */

  header('Content-Encoding: UTF-8');
  header('Content-type: text/csv; charset=UTF-8');

  header('Content-Disposition: attachment; filename='.$filename.'.xls');
?> 