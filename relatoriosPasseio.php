<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
/* -----------------------------------------------------------------------------------------------------  */
    $idPasseio = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
    
/* -----------------------------------------------------------------------------------------------------  */
    if(!empty($idPasseio)){
      $nenhumPasseioSelecionado = false;
      $decoraçãoLink = '';
      //echo"SITUAÇÃO 1";
      

/* -----------------------------------------------------------------------------------------------------  */
        $pesquisaIdPasseio ="SELECT DISTINCT p.idPasseio, p.nomePasseio,SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente,
                                                    FORMAT(SUM(taxaPagamento), 2) AS totalTaxaPagamento, p.nomePasseio, p.dataPasseio, p.valorPasseio 
                                                    FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND pp.idPasseio=$idPasseio";
                                                    $resultadPesquisaIdPasseio = mysqli_query($conexao, $pesquisaIdPasseio);
        $pesquisaValorMedioVendido = "SELECT DISTINCT AVG(pp.valorVendido) AS valorMediaVendido 
                                      FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND pp.idPasseio=$idPasseio AND statusPagamento NOT IN(0,3)";
        $resultadoValorMedioVendido = mysqli_query($conexao, $pesquisaValorMedioVendido);
        $rowMediaVendido            = mysqli_fetch_assoc($resultadoValorMedioVendido);
        $valorMediaVendido          = $rowMediaVendido['valorMediaVendido'];
        while($rowPesquisaIdPasseio      = mysqli_fetch_assoc($resultadPesquisaIdPasseio)){
          
    
        $lucroBruto                    = $rowPesquisaIdPasseio['somarValorPago'];
        $valorPendente                 = $rowPesquisaIdPasseio['valorPendente'];
        $valorPendente                 = number_format((float) $valorPendente, 2, '.', '') * -1;
        $qtdCliente                    = $rowPesquisaIdPasseio['qtdCliente'];
        $valorPasseio                  = $rowPesquisaIdPasseio['valorPasseio'];
        $taxaPagamento                 = $rowPesquisaIdPasseio['totalTaxaPagamento'];
        $nomePasseio                   = $rowPesquisaIdPasseio['nomePasseio'];
        }
        /* -----------------------------------------------------------------------------------------------------  */
                                                    
                            $totalDespesas =        "SELECT SUM(d.totalDespesas) AS totalDespesas, p.dataPasseio FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.idPasseio=$idPasseio";
 
                                                    $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                                                    while($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)){
                                                      
                                                      $dataPasseio = date_create($rowTotalDespesa['dataPasseio']);

                                                      $valorTotalDespesas             = $rowTotalDespesa ['totalDespesas']/* + $valorTotalSeguroViagem */ ;
                                
        /* -----------------------------------------------------------------------------------------------------  */
                                                      
                                                      $lucroLiquido                   = $lucroBruto + $valorPendente;
                                                      $lucroDespesas                  = $lucroBruto - $valorTotalDespesas;
                                                      $lucroEstimado                  = $valorPendente + $lucroBruto - $valorTotalDespesas;
        /* -----------------------------------------------------------------------------------------------------  */
                                                    }


                                      
        /* -----------------------------------------------------------------------------------------------------  */
                

/* -----------------------------------------------------------------------------------------------------  */

       
    }else{
      //echo"SITUAÇÃO 2";
      $nenhumPasseioSelecionado = true;
      $decoraçãoLink = 'text-reset text-decoration-none';


    }
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>RELATÓRIOS</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">INÍCIO </a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="#">RELATÓRIOS </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="logout.php" >SAIR </a>
        </li>
      </ul>
    </div>
  </nav>
  <?php
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
  ?>
  <div class="container-fluid mt-3">
    <p class="h4 text-center alert-info">
        <?php  
            if($nenhumPasseioSelecionado){
              $valorPendente            = 0;
              $lucroBruto               = 0; 
              $valorMediaVendido        = 0; 
              $lucroLiquido             = 0; 
              $lucroDespesas            = 0; 
              $totalDespesas            = 0; 
              $qtdCliente               = 0; 
              $lucroEstimado            = 0; 
              $valorTotalDespesas       = 0;
              $valorPasseio             = 0;
              $taxaPagamento            = 0; 
                echo"<p class='h4 text-center alert-info'> SELECIONE O INTERVALO</p>";
                echo"<form action='' method='GET' autocomplete='OFF'>";
                  echo"<div class='form-group row mb-5'>";
                    echo"<label class='col-sm-2 col-form-label' for='inicioDataPasseio'></label>";
                    echo"<input type='date' class='form-control col-sm-2' name='inicioDataPasseio' id='inicioDataPasseio'>";

                    echo"<label class='col-sm-2 col-form-label  pl-5' for='fimDataPasseio'>PERÍODO</label>";
                    echo"<input type='date' class='form-control col-sm-2' name='fimDataPasseio' id='fimDataPasseio' >";
                    echo"<input type='submit' class='btn btn-primary btn-sm ml-5' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>";
                  echo"</div>";
                echo"</form>";
/* -----------------------------------------------------------------------------------------------------  */
                $buttonEviaDataPasseio = filter_input(INPUT_GET, 'buttonEviaDataPasseio', FILTER_SANITIZE_STRING);
                $inicioDataPasseio     = filter_input(INPUT_GET, 'inicioDataPasseio', FILTER_SANITIZE_STRING);
                $fimDataPasseio        = filter_input(INPUT_GET, 'fimDataPasseio', FILTER_SANITIZE_STRING);
/* -----------------------------------------------------------------------------------------------------  */
                if($buttonEviaDataPasseio){
                  if(!empty($inicioDataPasseio) && !empty($fimDataPasseio)){
                    //echo"SITUAÇÃO 3";
                    $decoraçãoLink = 'text-reset text-decoration-none';
/* -----------------------------------------------------------------------------------------------------  */
                    $pesquisaIntervaloData ="SELECT DISTINCT p.idPasseio, p.nomePasseio, SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente,
                                            FORMAT(SUM(taxaPagamento), 2) AS totalTaxaPagamento, p.nomePasseio, p.dataPasseio, p.valorPasseio 
                                            FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'";
                                            $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);

                    $pesquisaValorMedioVendido = "SELECT DISTINCT AVG(pp.valorVendido) AS valorMediaVendido 
                                                  FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio' AND statusPagamento NOT IN(0,3)";
                    $resultadoValorMedioVendido = mysqli_query($conexao, $pesquisaValorMedioVendido);
                    $rowMediaVendido            = mysqli_fetch_assoc($resultadoValorMedioVendido);
                    $valorMediaVendido             = $rowMediaVendido['valorMediaVendido'];                                            
                                            while($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)){
                                              
                                        
                                            $lucroBruto                    = $rowPesquisaIntervaloData['somarValorPago'];
                                            $valorPendente                 = $rowPesquisaIntervaloData['valorPendente'];
                                            $valorPendente                   = number_format((float) $valorPendente, 2, '.', '')* -1;

                                            $qtdCliente                    = $rowPesquisaIntervaloData['qtdCliente'];
                                            $valorPasseio                  = $rowPesquisaIntervaloData['valorPasseio'];
                                            $taxaPagamento                 = $rowPesquisaIntervaloData['totalTaxaPagamento'];

/* -----------------------------------------------------------------------------------------------------  */
                                            }
/* -----------------------------------------------------------------------------------------------------  */

                    $totalDespesas =        "SELECT SUM(d.totalDespesas) AS totalDespesas FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'"; 
                                            $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                                            while($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)){
                                              
                                            
                                              $valorTotalDespesas             = $rowTotalDespesa ['totalDespesas']/* + $valorTotalSeguroViagem */ ;
                        
/* -----------------------------------------------------------------------------------------------------  */
          
                                              $lucroLiquido                   = $lucroBruto + $valorPendente;
                                              $lucroDespesas                  = $lucroBruto - $valorTotalDespesas;
                                              $lucroEstimado                  = $valorPendente + $lucroBruto -$valorTotalDespesas;
/* -----------------------------------------------------------------------------------------------------  */
                                            }
                                              $inicioDataPasseioFormatado = date_create($inicioDataPasseio);
                                              $fimDataPasseioFormatado = date_create($fimDataPasseio);

                                              echo"<p class='h4 text-center alert-warning'> PERÍODO SELECIONADO:  ".date_format($inicioDataPasseioFormatado, "d/m/Y") ." => ".date_format($fimDataPasseioFormatado, "d/m/Y") ." <a target='_blank'href='listaRelatorioPasseios.php?inicioDataPasseio=".$inicioDataPasseio."&fimDataPasseio=".$fimDataPasseio."&mostrarPasseiosExcluidos=1'> *</a></p>";
                                            

                  }else{
                    //echo"SITUAÇÃO 4";
                    $inicioDataPasseioPadrao = '2000-01-01';
                    $fimDataPasseioPadrao    = '2099-01-01';
                    $decoraçãoLink = 'text-reset text-decoration-none';
 /* -----------------------------------------------------------------------------------------------------  */
                    $pesquisaIntervaloData ="SELECT DISTINCT p.idPasseio, p.nomePasseio, SUM(pp.valorPago) AS somarValorPago, SUM(pp.valorPendente) AS valorPendente, COUNT(pp.idPagamento) AS qtdCliente, AVG(pp.valorVendido) AS valorMediaVendido,
                                            FORMAT(SUM(taxaPagamento), 2) AS totalTaxaPagamento, p.nomePasseio, p.dataPasseio, p.valorPasseio 
                                            FROM pagamento_passeio pp, passeio p  WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'";
                                            $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
                                            
                    $pesquisaValorMedioVendido = "SELECT DISTINCT AVG(pp.valorVendido) AS valorMediaVendido 
                                                  FROM pagamento_passeio pp, passeio p WHERE pp.idPasseio=p.idPasseio AND dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao' AND statusPagamento NOT IN(0,3)";
                    $resultadoValorMedioVendido = mysqli_query($conexao, $pesquisaValorMedioVendido);
                    $rowMediaVendido            = mysqli_fetch_assoc($resultadoValorMedioVendido);
                    $valorMediaVendido             = $rowMediaVendido['valorMediaVendido'];
                                            
                                              while($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData) ){
                                                                        
                                                                  
                                                                      $lucroBruto                    = $rowPesquisaIntervaloData['somarValorPago'];
                                                                      $valorPendente                 = $rowPesquisaIntervaloData['valorPendente'];
                                                                      $valorPendente                 = number_format((float) $valorPendente, 2, '.', '') *-1;
                                                                      $qtdCliente                    = $rowPesquisaIntervaloData['qtdCliente'];
                                                                      $valorPasseio                  = $rowPesquisaIntervaloData['valorPasseio'];
                                                                      $taxaPagamento                 = $rowPesquisaIntervaloData['totalTaxaPagamento'];

                          /* -----------------------------------------------------------------------------------------------------  */
                                                                      }
                                        
/* -----------------------------------------------------------------------------------------------------  */
                                          

                    $totalDespesas =        "SELECT SUM(d.totalDespesas) AS totalDespesas  FROM  despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND p.dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'"; 
                                           
                                            $resultadoTotalDespesas = mysqli_query($conexao, $totalDespesas);
                                            while($rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas)){
                                              
                                            
                                              $valorTotalDespesas             = $rowTotalDespesa ['totalDespesas'] /* + $valorTotalSeguroViagem */ ;
                        
/* -----------------------------------------------------------------------------------------------------  */
                                              $lucroLiquido                   = $lucroBruto + $valorPendente;
                                              
                                              $lucroDespesas                  = $lucroBruto - $valorTotalDespesas;
                                              $lucroEstimado                  = $valorPendente + $lucroBruto -$valorTotalDespesas;
/* -----------------------------------------------------------------------------------------------------  */
                                            }
                                            if($inicioDataPasseioPadrao == '2000-01-01' && $fimDataPasseioPadrao == '2099-01-01' ){
                                              echo"<p class='h4 text-center alert-warning'> EXIBINDO INFORMAÇÕES SOBRE TODOS OS PASSEIOS <a target='_blank' href='listaRelatorioPasseios.php?inicioDataPasseio=&fimDataPasseio=&mostrarPasseiosExcluidos=1'> *</a></p>";
                                            }else{
                                              //
                                            }
                                            
                                            
                  }
                }else{
                  //
                }
            }else{ 
              
                echo $nomePasseio." ", date_format($dataPasseio, "d/m/Y");
            } 
        ?>
    </p>
    <div class="form-group row mt-3">
        <label class="col-sm-2 col-form-label"  data-toggle="tooltip" data-placement="top" title="SOMA DE TODO VALOR NÃO PAGO PELOS CLIENTES" for="valorPendente">VALOR PENDENTE</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="valorPendente" id="valorPendente" placeholder="0" value="<?php echo number_format((float) $valorPendente, 2, '.', '') ?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="TAXAS DE PAGAMENTO COMO PARCELAMENTO E OUTROS" for="taxaPagamento">TAXAS DE PAGAMENTO</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="taxaPagamento" id="taxaPagamento" placeholder="0" value="<?php echo number_format((float) $taxaPagamento, 2, '.', '') ?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="SOMA DE TODO VALOR PAGO PELOS CLIENTES SEM DESCONTOS" for="lucroBruto">RECEBIMENTOS</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroBruto" id="lucroBruto" placeholder="0" value="<?php echo number_format((float) $lucroBruto, 2, '.', '') ?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="EXCLUÍDOS PAGAMENTOS DE CRIANÇAS E PARCEIROS" for="valorMediaVendido">VALOR MÉDIO VENDIDO</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="valorMediaVendido" id="valorMediaVendido" placeholder="0" value="<?php echo number_format((float) $valorMediaVendido, 2, '.', '') ?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="RECEBIMENTOS - TOTAL DAS DESPESAS" for="lucroDespesas">LUCRO REAL</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroDespesas" id="lucroDespesas" placeholder="0" value="<?php echo number_format((float) $lucroDespesas, 2, '.', '')?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="DESPESAS PASSEIO + SEGURO VIAGEM" for="totalDespesas"> <a target="_blank" class="<?php echo $decoraçãoLink?> " rel="noopener noreferrer" href="editaDespesas.php?id=<?php echo $idPasseio ?>">TOTAL DESPESAS</a> </label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="totalDespesas" id="totalDespesas" placeholder="0" value="<?php echo number_format((float) $valorTotalDespesas, 2, '.', '') ?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="QTD DE CLIENTES QUE FIZERAM UM PAGAMENTO" for="qtdCliente"> <a target="_blank" class="<?php echo $decoraçãoLink?> " rel="noopener noreferrer" href="listaPasseio.php?id=<?php echo $idPasseio ?>"> QTD DE CLIENTES</a></label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="qtdCliente" id="qtdCliente" placeholder="0" value="<?php echo number_format((float) $qtdCliente, 2, '.', '') ?>" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="VALOR PENDENTE + RECEBIMENTOS - TOTAL DESPESAS" for="lucroEstimado">LUCROS ESTIMADOS</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="lucroEstimado" id="lucroEstimado" placeholder="0" value="<?php echo number_format((float) $lucroEstimado, 2, '.', '') ?>" readonly>
        </div>
        <label class="col-sm-2 col-form-label" data-toggle="tooltip" data-placement="top" title="VALOR DO PASSEIO INSERIDO NO ATO DO CADASTRO DO PASSEIO" for="valorPasseio">VALOR DO PASSEIO</label>
        <div class="col-sm-2">
        <input type="text" class="form-control " name="valorPasseio" id="valorPasseio" placeholder="0" value="<?php echo number_format((float) $valorPasseio, 2, '.', '')  ?>" readonly>
        </div>
    </div>
  </div>
</body>
</html>