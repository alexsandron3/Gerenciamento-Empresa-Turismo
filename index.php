<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>INÍCIO</title>
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
        <a class="nav-link" href="relatoriosPasseio.php">RELATÓRIOS </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
            <!-- <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a> -->
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


    <form action='' method='GET' autocomplete='OFF'>
      <div class='form-group row mb-5 mt-5'>
        <label class='col-sm-2 col-form-label' for='inicioDataPasseio'></label>
        <input type='date' class='form-control col-sm-2' name='inicioDataPasseio' id='inicioDataPasseio' value="">

        <label class='col-sm-2 col-form-label  pl-5' for='fimDataPasseio'>PERÍODO</label>
        <input type='date' class='form-control col-sm-2' name='fimDataPasseio' id='fimDataPasseio' value="" >
        <input type='submit' class='btn btn-primary btn-sm ml-5 ' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio' >
        <div class="form-check mt-2 col-12">
          <input class="form-check-input col-1 ml-1" type="checkbox" name="mostrarPasseiosExcluidos"value="1" id="mostrarPasseiosExcluidos">
          <label class="form-check-label  col-3 ml-5 pl-5" for="mostrarPasseiosExcluidos" >
          EXIBE PASSEIOS ENCERRADOS
          </label>
        </div>
      </div>
    </form>
  <div class="table-responsive">
    <table class="table table-hover">
      <thead class="thead-light">
        <tr>
          <th scope="col">PASSEIO</th>
          <th scope="col">DATA</th>
          <th scope="col">RESERVADOS</th>
          <th scope="col">INTERESSADOS</th>
          <th scope="col">PARCEIROS</th>
          <th scope="col">CRIANÇAS</th>
          <th scope="col">META DE VENDA</th>
          <th scope="col">VAGAS DISPONÍVEIS</th>
        </tr>
      </thead>
      <?php
        /* -----------------------------------------------------------------------------------------------------  */
        $buttonEviaDataPasseio    = filter_input(INPUT_GET, 'buttonEviaDataPasseio', FILTER_SANITIZE_STRING);
        $inicioDataPasseio        = filter_input(INPUT_GET, 'inicioDataPasseio', FILTER_SANITIZE_STRING);
        $fimDataPasseio           = filter_input(INPUT_GET, 'fimDataPasseio', FILTER_SANITIZE_STRING);
        $mostrarPasseiosExcluidos = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos', FILTER_VALIDATE_BOOLEAN);
        $inicioDataPasseioFormatado = date_create($inicioDataPasseio);
        $fimDataPasseioFormatado = date_create($fimDataPasseio);
        $exibePasseio = (empty($mostrarPasseiosExcluidos) OR is_null($mostrarPasseiosExcluidos)) ? false: true;
        $queryExibePasseio = ($exibePasseio == false)? 'AND statusPasseio NOT IN (0)' : ' ';
        $mensagemExibeExcluidos = ($exibePasseio == true)? 'EXBINDO PASSEIOS ENCERRADOS': ' EXIBINDO SOMENTE PASSEIOS ATIVOS';
        if($buttonEviaDataPasseio){
          if(empty($inicioDataPasseio)OR empty($fimDataPasseio)){
            echo"<p class='h4 text-center alert-warning'>  RELATÓRIO DE VENDAS <br/>". "PERÍODO SELECIONADO INVÁLIDO</p>";  
          }else{
            echo"<p class='h4 text-center alert-info'>  RELATÓRIO DE VENDAS <br/>". "PERÍODO SELECIONADO:  ".date_format($inicioDataPasseioFormatado, "d/m/Y") ." => ".date_format($fimDataPasseioFormatado, "d/m/Y") ." 
            <a target='_blank'href='listaRelatorioPasseios.php?inicioDataPasseio=".$inicioDataPasseio."&fimDataPasseio=".$fimDataPasseio."&mostrarPasseiosExcluidos=".$mostrarPasseiosExcluidos."'> *</a></br>
            " .$mensagemExibeExcluidos.  "
            
            </p>";
          }
        }else{
          echo"<p class='h4 text-center alert-info'>  RELATÓRIO DE VENDAS <br/></p>";  

        }
      /* -----------------------------------------------------------------------------------------------------  */
    $listaPasseios = "SELECT idPasseio, dataPasseio FROM passeio WHERE dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio' $queryExibePasseio ORDER BY dataPasseio";
    $resultadoListaPasseio = mysqli_query($conexao, $listaPasseios);

    while($rowResultadoListaPasseio = mysqli_fetch_assoc($resultadoListaPasseio)){
      $idPasseio = $rowResultadoListaPasseio['idPasseio'];
      $pagamentosUltimoDia = "SELECT dataPagamento, statusPagamento FROM pagamento_passeio WHERE dataPagamento >= NOW() - INTERVAL 1 DAY AND idPasseio = $idPasseio ";
      $resultadoPagamentosUltimoDia = mysqli_query($conexao, $pagamentosUltimoDia);
      $qtdPagamento = mysqli_num_rows($resultadoPagamentosUltimoDia);
      $interessadosUltimoDia =0;
      $quitadosUltimoDia =0;
      $parciaisUltimoDia =0;
      $parceirosUltimoDia =0;
      $criancasUltimoDia =0;
      $confirmadosUltimoDia =0;
      while($rowPagamentosUltimoDia = mysqli_fetch_assoc($resultadoPagamentosUltimoDia)){
        
        if($rowPagamentosUltimoDia ['statusPagamento'] == 0){
          $interessadosUltimoDia +=1;
        }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 1){
          $quitadosUltimoDia +=1;
          $confirmadosUltimoDia +=1;
        }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 2){
          $parciaisUltimoDia +=1;
          $confirmadosUltimoDia +=1;
        }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 3){
          $parceirosUltimoDia +=1;
        }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 4){
          $criancasUltimoDia +=1;
        }
      }
      


      $idPasseio = $rowResultadoListaPasseio['idPasseio'];
      $pagamentosUltimaHora = "SELECT dataPagamento, statusPagamento FROM pagamento_passeio WHERE dataPagamento >= NOW() - INTERVAL 1 HOUR AND idPasseio = $idPasseio";
      $resultadoPagamentosUltimaHora = mysqli_query($conexao, $pagamentosUltimaHora);
      $qtdPagamentoHora = mysqli_num_rows($resultadoPagamentosUltimaHora);
      $interessadosUltimaHora =0;
      $quitadosUltimaHora =0;
      $parciaisUltimaHora =0;
      $parceirosUltimaHora =0;
      $criancasUltimaHora =0;
      $confirmadosUltimaHora =0;
      while($rowPagamentosUltimaHora = mysqli_fetch_assoc($resultadoPagamentosUltimaHora)){
        
        if($rowPagamentosUltimaHora ['statusPagamento'] == 0){
          $interessadosUltimaHora +=1;
        }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 1){
          $quitadosUltimaHora +=1;
          $confirmadosUltimaHora +=1;
        }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 2){
          $parciaisUltimaHora +=1;
          $confirmadosUltimaHora +=1;
        }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 3){
          $parceirosUltimaHora +=1;
        }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 4){
          $criancasUltimaHora +=1;
        }
      }
      $recebeLotacaoPasseio    = "SELECT lotacao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseio'";
      $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
      $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
      $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
      $nomePasseio          = $rowLotacaoPasseio['nomePasseio']; 
      $dataPasseio          = date_create($rowLotacaoPasseio['dataPasseio']); 

      $getStatusPagamento       = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=$idPasseio AND statusPagamento NOT IN (0,4)";
      $resultadoStatusPagamento = mysqli_query($conexao, $getStatusPagamento);
      $qtdClientesConfirmados   = mysqli_num_rows($resultadoStatusPagamento);

      $getStatusPagamentoCliente       = "SELECT statusPagamento FROM pagamento_passeio WHERE idPasseio=$idPasseio";
      $resultadoStatusPagamentoCliente = mysqli_query($conexao, $getStatusPagamentoCliente);
      $interessado = 0;
      $quitado = 0;
      $parcial = 0;
      $parceiro = 0;
      $crianca = 0;
      $confirmados = 0;
      while($rowGetStatusPagamentoCliente = mysqli_fetch_assoc($resultadoStatusPagamentoCliente)){
        $statusCliente = $rowGetStatusPagamentoCliente['statusPagamento'];
        if($statusCliente == 0){
          $interessado +=1;
        }elseif($statusCliente == 1){
          $quitado +=1;
          $confirmados +=1;
        }elseif($statusCliente == 2){
          $parcial +=1;
          $confirmados +=1;
        }elseif($statusCliente == 3){
          $parceiro +=1;
        }elseif($statusCliente == 4){
          $crianca +=1;
        }

      }
      #----------------------------- STATUS -------------------------------------
      if($confirmadosUltimoDia > 0){
        $statusConfirmados = "text-warning";
      }else{
        $statusConfirmados = "";
      
      }

      if($interessadosUltimoDia > 0){
        $statusInteressados = "text-warning";
      }else{
        $statusInteressados = "";
      }

      if($parceirosUltimoDia > 0){
        $statusParceiros = "text-warning";
      }else{
        $statusParceiros = "";
      }

      if($criancasUltimoDia > 0){
        $statusCriancas = "text-warning";
      }else{
        $statusCriancas = "";
      }
      #------------------------------------------------------------------------------

      $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados);
    ?>
    <tbody>
      <tr>
        <td><?php echo $nomePasseio ?></td>
        <td><?php echo date_format($dataPasseio, "d/m/Y") ?></td>
        <td id="" data-toggle="tooltip" data-placement="top" title="<?php echo "RESERVADOS NA ÚLTIMA HORA: ".$confirmadosUltimaHora ?>" class="text-center more_info "><span class="<?php echo $statusConfirmados ?>"><?php echo "         ".$confirmados ?></span></td>
        <td data-toggle="tooltip" data-placement="top" title="<?php echo "INTERESSADOS NA ÚLTIMA HORA: ".$interessadosUltimaHora ?>" class="text-center more_info"> <span class="<?php echo $statusInteressados ?>"><?php echo"         ". $interessado ?> </span></td>
        <td data-toggle="tooltip" data-placement="top" title="<?php echo "PARCEIROS NA ÚLTIMA HORA: ".$parceirosUltimaHora ?>" class="text-center more_info"><span class="<?php echo $statusParceiros  ?>"><?php echo "         ".$parceiro ?></span></td>
        <td data-toggle="tooltip" data-placement="top" title="<?php echo "CRIANCAS NA ÚLTIMA HORA: ".$criancasUltimaHora ?>" class="text-center more_info"><span class="<?php echo $statusCriancas ?>"><?php echo "         ".$crianca ?></span></td>
        <td class="text-center"><?php echo $lotacaoPasseio ?></td>
        <td class="text-center"><?php echo $vagasRestantes ?></td>
      </tr>
      <?php
  }
      ?>
    </tbody>
  </table>
</div>
<script>
$(".more_info").click(function () {
    var $title = $(this).find(".title");
    if (!$title.length) {
        $(this).append('<span class="title"> </br>' + $(this).attr("title") + '</span>');
    } else {
        $title.remove();
    }
});


</script>
</body>
</html>