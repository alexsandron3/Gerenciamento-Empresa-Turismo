<?php
   session_start();

   include_once("../PHP/conexao.php");



   /* -----------------------------------------------------------------------------------------------------  */



   $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);;

   $buscaPeloIdPasseio = "SELECT 

                             c.nomeCliente AS nome, c.dataNascimento,c.cpfCliente, pp.valorseguroViagemCliente

                           FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente

                           ";
                           #echo$buscaPeloIdPasseio;
/* "SELECT  p.nomePasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.rgCliente, c.dataCpfConsultado, c.telefoneCliente, c.orgaoEmissor, c.idadeCliente, c.dataCpfConsultado, 
pp.statusPagamento, pp.idPagamento, pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro 
FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente" */
   

   

   /* -----------------------------------------------------------------------------------------------------  */
   $comecoContador0 = 1;
   $setRec = mysqli_query($conexao, $buscaPeloIdPasseio);

   
   /* -----------------------------------------------------------------------------------------------------  */
   $rowDados = mysqli_fetch_array($setRec);
  
/*   $nomeCliente0 = $rowDados['nome'];
  $dataNascimento0 = $rowDados['dataNascimento'];
  $tipoDocumento0 = "CPF";
  $numeroDocumento0 = $rowDados['cpfCliente'];
  $valorSeguroViagem0 = $rowDados['valorseguroViagemCliente'];
  

  $texto0 = "$nomeCliente0";

  $divisor0 = explode(" ", $texto0);

  
  $fimContador0 = count($divisor0);



  while($comecoContador0 < $fimContador0){
    $arraySobrenome0[] = $divisor0[$comecoContador0];
    $comecoContador0 = $comecoContador0 +1;
    $sobrenome0 = implode(' ',$arraySobrenome0);
    $nomeSeguroViagem0 = $sobrenome0 ." /" . $divisor0[0];
    $dados0= $nomeCliente0 . "\t". $dataNascimento0. "\t". $numeroDocumento0."\t". $valorSeguroViagem0. "\t". $nomeSeguroViagem0. "\n"; 

  } */

   /* -----------------------------------------------------------------------------------------------------  */

  $dados = " ";

  while($rowDados = mysqli_fetch_array($setRec)){
    $comecoContador = 1;
    $comecoContador1 =1;

    $nomeCliente = $rowDados['nome'];
    $dataNascimento = $rowDados['dataNascimento'];
    $tipoDocumento = "CPF";
    $numeroDocumento = $rowDados['cpfCliente'];
    $valorSeguroViagem = $rowDados['valorseguroViagemCliente'];
    

    $texto = "$nomeCliente";
    

    $divisor = explode(" ", $texto);
    
    $fimContador = count($divisor);
    while($comecoContador < $fimContador){
      $arraySobrenome[$comecoContador1] = $divisor[$comecoContador];
      $comecoContador = $comecoContador +1;
      $comecoContador1 = $comecoContador1 +1;
      $sobrenome = implode(" ",$arraySobrenome);
      $nomeSeguroViagem = $sobrenome ."/" . $divisor[0];
      
        #echo $comecoContador1;
    }
    $dados= $nomeCliente . "\t". $dataNascimento. "\t". $numeroDocumento."\t". $valorSeguroViagem. "\t". $nomeSeguroViagem. "\n"; 

    echo "<pre>";
        #echo $comecoContador;
        echo $dados;
        var_dump($sobrenome);
        echo count($divisor);
    echo "</pre>"; 


  }


  /* header("Content-type: application/octet-stream");  

  header("Content-Disposition: attachment; filename=seguroViagem.xls");  

  header("Pragma: no-cache");  

  header("Expires: 0"); */

?> 