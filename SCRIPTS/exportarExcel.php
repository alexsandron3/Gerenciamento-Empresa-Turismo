<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

   /* -----------------------------------------------------------------------------------------------------  */
  //SCRIPT PARA EXPORTAR ARQUIVO EXCEL

   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT p.nomePasseio, p.idPasseio, c.nomeCliente, p.dataPasseio, c.cpfCliente, c.dataNascimento, pp.statusPagamento, pp.idPagamento, 
                              pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro, SUBSTRING_INDEX(c.nomeCliente, ' ', 1) AS primeiroNome 
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.seguroViagem= 1 AND pp.statusPagamento NOT IN(0) ";
     

   

   /* -----------------------------------------------------------------------------------------------------  */
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);
  

   /* -----------------------------------------------------------------------------------------------------  */
  $valorSeguroViagem = 2.47;
  $quantidadeClientes = mysqli_num_rows($setRec);
  $totalSeguroViagem = $valorSeguroViagem * $quantidadeClientes;
   /* -----------------------------------------------------------------------------------------------------  */

  $dados = '';
  echo "\t" . "\t" . "\t" . "\t" ."R$".$totalSeguroViagem ."\n";
  echo "NOME" . "\t". "DATA NASCIMENTO" ."\t". "TIPO DOCTO". "\t". "NUMERO DOCTO" . "\t" ."VALOR" . "\t" ."NOME SEGURO VIAGEM". "\n";
   /* -----------------------------------------------------------------------------------------------------  */
  
  while($rowDados = mysqli_fetch_array($setRec)){
    $nomePasseio = $rowDados['nomePasseio'];
    $nomePasseioSubstituto = str_replace(" ", $nomePasseio, "_");
    $dataPasseio = date_create($rowDados['dataPasseio']);
    $filename = "SEGURO VIAGEM_".$nomePasseio. $nomePasseioSubstituto. "". date_format($dataPasseio, "d/m/Y");
    
    $comecoContador = 1;
    $nomeCliente = $rowDados['nomeCliente'];
    $dataNascimento = $rowDados['dataNascimento'];
    $tipoDocumento = "CPF";
    $numeroDocumento = $rowDados['cpfCliente'];
    $primeiroNome = $rowDados['primeiroNome'];

    if (($pos = strpos($nomeCliente, " ")) !== FALSE) { 
    $nomeSeguroViagem = substr($nomeCliente, strpos($nomeCliente, " ") + 1);    
    
    }else{
      $nomeSeguroViagem = "";
    }

    $dados= $nomeCliente . "\t". $dataNascimento. "\t". $tipoDocumento. "\t" .$numeroDocumento ."\t". $valorSeguroViagem. "\t". $nomeSeguroViagem. "/$primeiroNome". "\n"; 
    

    print $dados;

  }
  /* -----------------------------------------------------------------------------------------------------  */

header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename='.$filename.'.xls');
?> 