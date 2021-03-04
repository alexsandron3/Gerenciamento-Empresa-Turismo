<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
    $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_FLOAT);
    $queryBuscaDespesa = "SELECT DISTINCT d.valorIngresso, d.valorOnibus, d.valorMicro, d.valorVan, d.valorEscuna, d.valorAlmocoCliente, d.valorAlmocoMotorista, d.valorEstacionamento, d.valorGuia, d.valorAutorizacaoTransporte,
                          d.valorTaxi, d.valorKitLanche, d.valorMarketing, d.valorImpulsionamento, d.valorPulseira, d.valorSeguroViagem , d.outros, d.idPasseio,  d.idDespesa, d.quantidadeIngresso, d.quantidadeOnibus, d.quantidadeMicro, d.quantidadeVan, d.quantidadeEscuna,
                          d.quantidadeAlmocoCliente, d.quantidadeAlmocoMotorista, d.quantidadeEstacionamento, d.quantidadeGuia, d.quantidadeAutorizacaoTransporte, d.quantidadeTaxi, d.quantidadeKitLanche, d.quantidadeMarketing, d.quantidadeImpulsionamento, d.quantidadePulseira, d.quantidadeSeguroViagem,                     
                          p.nomePasseio, p.dataPasseio   
                          FROM despesa d, passeio p WHERE d.idpasseio='$idPasseioGet' AND d.idPasseio=p.idPasseio";
                          $resultadoBuscaDespesa = mysqli_query($conexao, $queryBuscaDespesa);
                          $rowDespesa = mysqli_fetch_assoc($resultadoBuscaDespesa);
                          $dataPasseio =  date_create($rowDespesa['dataPasseio']);
/* -----------------------------------------------------------------------------------------------------  */

/* -----------------------------------------------------------------------------------------------------  */
    if(!empty($idPasseioGet)){
      $queryTotalDespesas = "SELECT (valorIngresso * quantidadeIngresso) + (valorOnibus * quantidadeOnibus) + (valorMicro * quantidadeMicro) + (valorVan * quantidadeVan) + (valorEscuna * quantidadeEscuna) + (valorAlmocoCliente * quantidadeAlmocoCliente)
                                  + (valorAlmocoMotorista * quantidadeAlmocoMotorista)+ (valorEstacionamento * quantidadeEstacionamento)+ (valorGuia * quantidadeGuia) + (valorAutorizacaoTransporte * quantidadeAutorizacaoTransporte) + (valorTaxi * quantidadeTaxi)
                                  + (valorKitLanche * quantidadeKitLanche)+ (valorMarketing * quantidadeMarketing) + (valorImpulsionamento * quantidadeImpulsionamento) + (valorSeguroViagem * quantidadeSeguroViagem) + outros 
                                  AS totalDespesas FROM despesa WHERE idPasseio=$idPasseioGet";
                                  
                                  $resultadoTotalDespesas = mysqli_query($conexao, $queryTotalDespesas);
                                  $rowTotalDespesa = mysqli_fetch_assoc($resultadoTotalDespesas);
                                  $valorTotalDespesas = $rowTotalDespesa ['totalDespesas'] /* + $valorTotalSeguroViagem */;
    }
/* -----------------------------------------------------------------------------------------------------  */

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>ATUALIZAR DESPESAS</title>
</head>

<body>
  <!-- NAVBAR -->
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
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item " href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item active" href="cadastroDespesas.php">DESPESAS</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="logout.php" >SAIR </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- TODO FORM -->
  <div class="container-fluid mt-4">
    <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
    <div class="container-fluid ">
      <form action="SCRIPTS/atualizaDespesas.php" autocomplete="off" method="POST" onclick="calculoTotalDespesas()">
          <?php
            echo"<p class='h4 text-center alert-info'>". $rowDespesa  ['nomePasseio']. " ".date_format($dataPasseio, "d/m/Y") ."</p>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorIngresso'>INGRESSO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorIngresso' id='valorIngresso' placeholder='VALOR DO INGRESSO' value='". number_format((float)$rowDespesa['valorIngresso'],2, '.', ''). "' onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                      echo"<input type='text' class='form-control' name='quantidadeIngresso' id='quantidadeIngresso' placeholder='QTD'  value='". $rowDespesa ['quantidadeIngresso']."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalIngresso' id='valorTotalIngresso' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorOnibus'>ONIBUS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorOnibus' id='valorOnibus' placeholder='VALOR DO ONIBUS' value='". number_format((float)$rowDespesa['valorOnibus'],2, '.', ''). "'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeOnibus' id='quantidadeOnibus' placeholder='QTD' value='". $rowDespesa ['quantidadeOnibus']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalOnibus' id='valorTotalOnibus' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorMicro'>MICRO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorMicro' id='valorMicro' placeholder='VALOR DO MICRO' value='". number_format((float)$rowDespesa['valorMicro'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeMicro' id='quantidadeMicro' placeholder='QTD' value='". $rowDespesa ['quantidadeMicro']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalMicro' id='valorTotalMicro' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorVan'>VAN</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorVan' id='valorVan' placeholder='VALOR DO VAN' value='". number_format((float)$rowDespesa['valorVan'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeVan' id='quantidadeVan' placeholder='QTD' value='". $rowDespesa ['quantidadeVan']."'onblur='calculoTotalDespesas()' > ";
              echo"</div>"; 
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalVan' id='valorTotalVan' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorEscuna'>ESCUNA</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorEscuna' id='valorEscuna' placeholder='VALOR DO ESCUNA' value='". number_format((float)$rowDespesa['valorEscuna'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeEscuna' id='quantidadeEscuna' placeholder='QTD' value='".$rowDespesa ['quantidadeEscuna']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalEscuna' id='valorTotalEscuna' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorSeguroViagem'>SEGURO VIAGEM</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorSeguroViagem' id='valorSeguroViagem' placeholder='VALOR DO SEGURO VIAGEM' value='".number_format((float)$rowDespesa['valorSeguroViagem'],2, '.', '') ."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeSeguroViagem' id='quantidadeSeguroViagem' placeholder='QTD' value='".$rowDespesa ['quantidadeSeguroViagem']."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalSeguroViagem' id='valorTotalSeguroViagem' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorAlmocoCliente'>ALMOCO CLIENTE</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorAlmocoCliente' id='valorAlmocoCliente' placeholder='ALMOCO CLIENTE' value='". number_format((float)$rowDespesa['valorAlmocoCliente'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeAlmocoCliente' id='quantidadeAlmocoCliente' placeholder='QTD' value='". $rowDespesa ['quantidadeAlmocoCliente']."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalAlmocoCliente' id='valorTotalAlmocoCliente' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorAlmocoMotorista'>ALMOCO MOTORISTA</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorAlmocoMotorista' id='valorAlmocoMotorista' placeholder='ALMOCO MOTORISTA' value='". number_format((float)$rowDespesa['valorAlmocoMotorista'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeAlmocoMotorista' id='quantidadeAlmocoMotorista' placeholder='QTD' value='". $rowDespesa ['quantidadeAlmocoMotorista']."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalAlmocoMotorista' id='valorTotalAlmocoMotorista' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorEstacionamento'>ESTACIONAMENTO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorEstacionamento' id='valorEstacionamento' placeholder='ESTACIONAMENTO' value='". number_format((float)$rowDespesa['valorEstacionamento'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeEstacionamento' id='quantidadeEstacionamento' placeholder='QTD' value='". $rowDespesa ['quantidadeEstacionamento']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalEstacionamento' id='valorTotalEstacionamento' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorGuia'>GUIA</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorGuia' id='valorGuia' placeholder='VALOR GUIA' value='". number_format((float)$rowDespesa['valorGuia'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeGuia' id='quantidadeGuia' placeholder='QTD' value='". $rowDespesa ['quantidadeGuia']."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalGuia' id='valorTotalGuia' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorAutorizacaoTransporte'>AUTORIZAÇÃO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorAutorizacaoTransporte' id='valorAutorizacaoTransporte' placeholder='AUTORIZACAO TRANSPORTE' value='". number_format((float)$rowDespesa['valorAutorizacaoTransporte'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeAutorizacaoTransporte' id='quantidadeAutorizacaoTransporte' placeholder='QTD' value='". $rowDespesa ['quantidadeAutorizacaoTransporte']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalTransporte' id='valorTotalTransporte' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorTaxi'>TAXI</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorTaxi' id='valorTaxi' placeholder='TAXI' value='". number_format((float)$rowDespesa['valorTaxi'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeTaxi' id='quantidadeTaxi' placeholder='QTD' value='". $rowDespesa ['quantidadeTaxi']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalTaxi' id='valorTotalTaxi' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorMarketing'>MARKETING</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorMarketing' id='valorMarketing' placeholder='MARKETING' value='". number_format((float)$rowDespesa['valorMarketing'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeMarketing' id='quantidadeMarketing' placeholder='QTD' value='". $rowDespesa ['quantidadeMarketing']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalMarketing' id='valorTotalMarketing' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorKitLanche'>KIT LANCHE</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorKitLanche' id='valorKitLanche' placeholder='KIT LANCHE' value='".number_format((float)$rowDespesa['valorKitLanche'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeKitLanche' id='quantidadeKitLanche' placeholder='QTD' value='". $rowDespesa ['quantidadeKitLanche']."'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalKitLanche' id='valorTotalKitLanche' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";
            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorImpulsionamento'>IMPULSIONAMENTO</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorImpulsionamento' id='valorImpulsionamento' placeholder='INMPULSIONAMENTO' value='". number_format((float)$rowDespesa['valorImpulsionamento'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadeImpulsionamento' id='quantidadeImpulsionamento' placeholder='QTD' value='". $rowDespesa ['quantidadeImpulsionamento']."'onblur='calculoTotalDespesas()' >";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalImpulsionamento' id='valorTotalImpulsionamento' placeholder='TOTAL'  value='0' onblur='calculoTotalDespesas()'>";
              echo"</div>";  
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='valorPulseira'>PULSEIRAS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='valorPulseira' id='valorPulseira' placeholder='PULSEIRA' value='". $rowDespesa ['valorPulseira']."'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-1'>";
                echo"<input type='text' class='form-control' name='quantidadePulseira' id='quantidadePulseira' placeholder='QTD' value='". $rowDespesa ['quantidadePulseira']."'onchange='calculoTotalDespesas()'>";
              echo"</div>";
              echo"<div class='col-sm-2'>";
                echo"<input type='text' readonly class='form-control col-sm-8' name='valorTotalPulseira' id='valorTotalPulseira' placeholder='TOTAL'  value='0' onchange='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='outros'>OUTROS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='outros' id='outros' placeholder='OUTROS' value='". number_format((float)$rowDespesa['outros'],2, '.', ''). "'onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<div class='form-group row'>";
              echo"<label class='col-sm-2 col-form-label' for='totalDespesas'>TOTAL DESPESAS</label>";
              echo"<div class='col-sm-6'>";
                echo"<input type='text' class='form-control' name='totalDespesas' id='totalDespesas' placeholder='TOTAL DESPESAS' value='". $valorTotalDespesas. "'readonly='readonly' onblur='calculoTotalDespesas()'>";
              echo"</div>";
            echo"</div>";

            echo"<button type='submit' name='cadastrarClienteBtn' id='submit' class='btn btn-primary btn-lg'>ATUALIZAR</button>";  
          ?>
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseioSelecionado" value="<?php echo $rowDespesa ['idPasseio']?>">
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idDespesa" id="idDespesa" value="<?php echo $rowDespesa ['idDespesa']?>">
        <input type="hidden" class="form-control col-sm-1 ml-3" name="nomePassseio" id="nomePasseio" value="<?php echo  $rowDespesa['nomePasseio']?>">
        <input type="hidden" class="form-control col-sm-1 ml-3" name="dataPasseio" id="dataPasseio" value="<?php echo $rowDespesa['dataPasseio']?>">
         
      </form>
  </div>
  <script src="config/script.php"></script>
</body>

</html>