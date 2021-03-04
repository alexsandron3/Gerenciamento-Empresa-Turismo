<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

   /* -----------------------------------------------------------------------------------------------------  */
  //SCRIPT PARA EXPORTAR ARQUIVO EXCEL


   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

   $buscaPeloIdPasseio = "SELECT  p.nomePasseio, p.dataPasseio, p.idPasseio, c.nomeCliente, c.rgCliente, c.orgaoEmissor, c.idCliente, c.idCliente, c.dataNascimento, pp.idPagamento, pp.valorPago  
                          FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente AND pp.statusPagamento NOT IN(0) ORDER BY nomeCliente";

   

  /* -----------------------------------------------------------------------------------------------------  */
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);
  /* -----------------------------------------------------------------------------------------------------  */

  $quantidadeClientes = mysqli_num_rows($setRec);
  $dados = '';
  echo mb_convert_encoding( "NOME" . "\t". "IDADE" ."\t". "EMISSOR". "\t" ."N. DOCTO."  ."\n","UTF-16LE","UTF-8");
  /* -----------------------------------------------------------------------------------------------------  */
  
  while($rowDados = mysqli_fetch_array($setRec)){
    $nomePasseio = $rowDados['nomePasseio'];
    $nomePasseioSubstituto = str_replace(" ", $nomePasseio, "_");
    $dataPasseio = date_create($rowDados['dataPasseio']);
    $idCliente = $rowDados['idCliente'];
    $rgCliente = $rowDados['rgCliente'];
    $filename = "LISTA DE PASSAGEIROS_".$nomePasseio. $nomePasseioSubstituto. "". date_format($dataPasseio, "d/m/Y");

    $comecoContador = 1;
    $nomeCliente = $rowDados['nomeCliente'];
    $idade = calcularIdade($idCliente, $conn, "");
    $emissor = $rowDados['orgaoEmissor'];



    $dados= $nomeCliente . "\t". $idade. "\t" . $emissor ."\t" .$rgCliente ."\n"; 
    $dados = mb_convert_encoding($dados, "UTF-16LE","UTF-8");

    print $dados;

  }
  /* -----------------------------------------------------------------------------------------------------  */

  header('Content-Encoding: UTF-8');
  header('Content-type: text/csv; charset=UTF-8');

  header('Content-Disposition: attachment; filename='.$filename.'.xls');
  /* -----------------------------------------------------------------------------------------------------  */

?> 