<?php
    session_start();
    include_once("PHP/conexao.php");
/* -----------------------------------------------------------------------------------------------------  */
    $idCliente = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
    $queryBuscaIdCliente = "SELECT nomeCliente, idadeCliente, referencia FROM cliente WHERE idCliente = '$idCliente'";
                                $resultadoIdCliente = mysqli_query($conexao, $queryBuscaIdCliente);
                                $rowIdCliente = mysqli_fetch_assoc($resultadoIdCliente);
/* -----------------------------------------------------------------------------------------------------  */

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="config/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
    integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
  <title>PAGAMENTO</title>
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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="pesquisarCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
          </div>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            LISTAGEM
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="">CLIENTE</a>
            <a class="dropdown-item" href="">PASSEIO</a>
            <a class="dropdown-item" href="">PAGAMENTO</a>
          </div> -->
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item active" href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
          </div>
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
      <form action="" autocomplete="off" method="POST" onkeydown="calculoPagamentoCliente()">
        <?php
        if($idCliente == 0){
          echo"<p class='h4 text-center alert-danger'>POR FAVOR, SELECIONE UM CLIENTE </p>";
        }else {
          echo"<p class='h4 text-center alert-primary'>CLIENTE: ". $rowIdCliente ['nomeCliente']. "</p>";
        } 
        ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="nomePasseio">PASSEIO</label>
          
          
          <select class="form-control ml-3 col-sm-3" name="passeiosLista" id="selectIdPasseio">
            <option value="0">SELECIONAR</option>
          
          <?php
            
            if($idCliente > 0){  
              $resultadoBuscaNomePasseio = "SELECT * FROM passeio ORDER BY dataPasseio";
              $resultadoNomePasseio = mysqli_query($conexao, $resultadoBuscaNomePasseio);
              while($rowNomePasseio = mysqli_fetch_assoc($resultadoNomePasseio)){
                ?>
                <option value="<?php echo $rowNomePasseio ['idPasseio'] ;?>"><?php echo $rowNomePasseio ['nomePasseio']; echo " "; echo $rowNomePasseio ['dataPasseio'];?>  </option>    
            <?php }
            }
          ?>
          <input type="submit" class="btn btn-primary btn-sm ml-2" value="CARREGAR INFORMAÇÕES" name="buttonCarregarInformacoes">
          <input type="hidden" class="form-control col-sm-1 ml-3" name="passeioSelecionado" id="passeioSelecionado" 
          onchange="idPasseioSelecionado()" readonly="readonly">
        </div>
      </form>
      <form action="SCRIPTS/realizaPagamento.php" method="post" autocomplete="OFF" >
      <div class="form-group-row">
          <?php
/* -----------------------------------------------------------------------------------------------------  */
            $idPasseioSelecionado = filter_input(INPUT_POST, 'passeiosLista', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
            $queryBuscarPasseioPeloId = "SELECT nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseioSelecionado'";
                                    $resultadoPasseioSelecionado = mysqli_query($conexao, $queryBuscarPasseioPeloId);
                                    $rowPasseioSelecionado = mysqli_fetch_assoc($resultadoPasseioSelecionado);
/* -----------------------------------------------------------------------------------------------------  */
            $buttonCarregarInformacoes = filter_input(INPUT_POST, 'buttonCarregarInformacoes', FILTER_SANITIZE_STRING);
            $idPasseio = $idPasseioSelecionado;
/* -----------------------------------------------------------------------------------------------------  */
            
            $queryBuscaSeJaExistePagamento = "SELECT idPagamento FROM pagamento_passeio WHERE idCliente='$idCliente' AND idPasseio='$idPasseio'";
                                $resultadoqueryBuscaSeJaExistePagamento = mysqli_query($conexao, $queryBuscaSeJaExistePagamento);
/* -----------------------------------------------------------------------------------------------------  */
            if($idCliente > 0) {
              if($buttonCarregarInformacoes){
                if($idPasseioSelecionado == 0){
                  echo"NENHUM PASSEIO SELECIONADO";
                }else{
                  if(mysqli_num_rows($resultadoqueryBuscaSeJaExistePagamento) == 0 ){
/* -----------------------------------------------------------------------------------------------------  */
                    $verificaSeExisteDespesa = "SELECT d.idPasseio, p.idPasseio FROM despesa d, passeio p WHERE d.idPasseio=p.idPasseio AND d.idPasseio='$idPasseioSelecionado'";
                    #echo $verificaSeExisteDespesa;
                                                $resultadoVerificaSeExisteDespesa = mysqli_query($conexao, $verificaSeExisteDespesa);
/* -----------------------------------------------------------------------------------------------------  */
                    if(mysqli_num_rows($resultadoVerificaSeExisteDespesa) !=0){
                      //echo"<p class='text-center alert-success'>SUCESSO, ESTE CLIENTE AINDA NÃO FEZ UMA COMPRA NESSE PASSEIO </p>";  
                      echo"<p class='h4 text-center alert-info'>PASSEIO: ". $rowPasseioSelecionado ['nomePasseio']. " ".$rowPasseioSelecionado ['dataPasseio'] ."</p>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='valorVendido'>VALOR VENDIDO</label>";
                        echo"<div class='col-sm-6'>";
                          echo"<input type='text' class='form-control' name='valorVendido' id='valorVendido' placeholder='VALOR VENDIDO' value='0' required onblur='calculoPagamentoCliente()'>";
                        echo"</div>";
                      echo"</div>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='valorPago'>VALOR PAGO</label>";
                        echo"<div class='col-sm-6'>";
                          echo"<input type='text' class='form-control' name='valorPago' id='valorPago' placeholder='VALOR PAGO'  value='0' onchange='calculoPagamentoCliente()'readonly='readonly' >";
                        echo"</div>";
                        echo"<div class='col-sm-2'>";
                          echo"<input type='text' class='form-control' name='novoValorPago' id='novoValorPago' placeholder='NOVO PAGAMENTO' value='0' onblur='(new calculoPagamentoCliente()).novoValorPago()'>";
                          echo"<input type='hidden' class='form-control' name='valorAntigo' id='valorAntigo' placeholder='valorAntigo' value='0' >";
                        echo"</div>";
                      echo"</div>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='valorPendenteCliente'>VALOR PENDENTE</label>";
                        echo"<div class='col-sm-6'>";
                          echo"<input type='text' class='form-control' name='valorPendenteCliente' id='valorPendenteCliente'  placeholder='VALOR PENDENTE' readonly='readonly' onblur='calculoPagamentoCliente()'>";
                        echo"</div>";
                      echo"</div>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='taxaPagamento'>TAXA DE PAGAMENTO</label>";
                        echo"<div class='col-sm-6'>";
                          echo"<input type='text' class='form-control' name='taxaPagamento' id='taxaPagamento' value='0'  placeholder='TAXA DE PAGAMENTO' onblur='calculoPagamentoCliente()'>";
                        echo"</div>";
                      echo"</div>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='localEmbarque'>LOCAL DE EMBARQUE</label>";
                        echo"<div class='col-sm-6'>";
                          echo"<input type='text' class='form-control' name='localEmbarque' id='localEmbarque'  placeholder='LOCAL DE EMBARQUE' required='required' autocomplete='on' onchange='calculoPagamentoCliente()'>";
                        echo"</div>";
                      echo"</div>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='previsaoPagamento'>PREVISÃO PAGAMENTO</label>";
                        echo"<div class='col-sm-3'>";
                          echo"<input type='date' class='form-control' name='previsaoPagamento' id='previsaoPagamento' placeholder='PREVISÃO PAGAMENTO'>";
                        echo"</div>";
                      echo"</div>";
                      echo"";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='meioTransporte'>TRANSPORTE</label>";
                        echo"<select class='form-control col-sm-3 ml-3' name='meioTransporte' id='meioTransporte'>";
                          echo"<option value='' selected> SELECIONAR</option>";
                          echo"<option value='CARRO'>CARRO</option>";
                          echo"<option value='ONIBUS'>ÔNIBUS</option>";
                          echo"<option value='MICRO'>MICRO</option>";
                          echo"<option value='VAN'>VAN</option>";
                        echo"</select>";
                      echo"</div>";
                      echo"<input type='hidden' class='form-control' name='statusPagamento' id='statusPagamento' placeholder='statusPagamento'  onchange='calculoPagamentoCliente()'>";
                      echo"<input type='hidden' class='form-control' name='idadeCliente' id='idadeCliente' placeholder='idadeCliente'  value='".$rowIdCliente ['idadeCliente'] . "'>";
                      echo"<div class='form-group row'>";
                        echo "<label class='col-sm-2 col-form-label' for='referenciaCliente'>REFERÊNCIA</label>";
                        echo"<textarea class='form-control col-sm-3 ml-3' name='referenciaCliente' id='referenciaCliente' cols='3' rows='1' disabled='disabled'
                          placeholder='INFORMAÇÕES' onkeydown='upperCaseF(this)' maxlength='100'>".$rowIdCliente ['referencia'].  "</textarea> ";
                      echo"</div>";
                      echo"<fieldset class='form-group' >";
                        echo"<div class='row'>";
                          echo"<legend class='col-form-label col-sm-2 pt-0'>SEGURO VIAGEM</legend>";
                          echo"<div class='col-sm-5'>";
                            echo"<div class='form-check'>";
                              echo"<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClienteSim'
                              value='1'  required>";
                              echo"<label class='form-check-label' for='seguroViagemClienteSim'>
                                SIM
                              </label>";
                            echo"</div>";
                            echo"<div class='form-check'>";
                              echo"<input class='form-check-input' type='radio' name='seguroViagemCliente' id='seguroViagemClientenao'
                              value='0' >";
                              echo"<label class='form-check-label' for='seguroViagemClientenao'>
                                NÃO
                              </label>";
                            echo"</div>";
                          echo"</div>";
                        echo"</div>";
                      echo"</fieldset>";
                     echo"<fieldset class='form-group' >";
                        echo"<div class='row'>";
                          echo"<legend class='col-form-label col-sm-2 pt-0'>CLIENTE PARCEIRO</legend>";
                          echo"<div class='col-sm-5'>";
                            echo"<div class='form-check'>";
                              echo"<input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceiroSim'
                              value='1'  required onclick='calculoPagamentoCliente()'>";
                              echo"<label class='form-check-label' for='clienteParceiroSim'>
                                SIM
                              </label>";
                            echo"</div>";
                            echo"<div class='form-check'>";
                              echo"<input class='form-check-input' type='radio' name='clienteParceiro' id='clienteParceironao'
                              value='0' onclick='calculoPagamentoCliente()' checked>";
                              echo"<label class='form-check-label' for='clienteParceironao'>
                                NÃO
                              </label>";
                            echo"</div>";
                          echo"</div>";
                        echo"</div>";
                      echo"</fieldset>";
                      echo"<div class='form-group row'>";
                        echo"<label class='col-sm-2 col-form-label' for='anotacoes'>ANOTAÇÕES</label>";
                          echo"<textarea class='form-control col-sm-3 ml-3' name='anotacoes' id='anotacoes' cols='5' rows='3'
                          placeholder='ANOTAÇÕES' onkeydown='upperCaseF(this)' maxlength='500'></textarea>";
                          echo"<label class='col-sm-2 col-form-label' for='anotacoes'>HISTÓRICO</label>";
                          echo"<textarea class='form-control col-sm-3 ml-3' name='historicoPagamento' id='historicoPagamento' cols='6' rows='3'
                          placeholder='historicoPagamento' maxlength='500'>  </textarea>";
                          echo"<textarea style='display:none;' class='form-control col-sm-3 ml-3' name='historicoPagamentoAntigo' id='historicoPagamentoAntigo' cols='6' rows='3'
                          placeholder='historicoPagamentoAntigo' maxlength='500' disabled='disabled' onblur='(new calculoPagamentoCliente()).novoValorPago()'>  </textarea>";
                      echo"</div>"; 
                    }else{
                    
                      echo"<p class='h4 text-center alert-warning'>VOCÊ PRECISA CRIAR AS DESPESAS DESTE PASSEIO, REDIRECIONANDO PARA A ÁREA DE CRIAÇÃO DE DESPESAS</p>";
                      echo" <script>
                                setTimeout(function () {
                                  window.location.href = 'cadastroDespesas.php';
                              }, 3000);
                            </script>
                      ";

                    }
                  }else{
                    echo"<p class='h4 text-center alert-info'>PASSEIO: ". $rowPasseioSelecionado ['nomePasseio']. " ".$rowPasseioSelecionado ['dataPasseio'] ."</p>";
                    echo"<p class='h4 text-center alert-warning'>ESTE CLIENTE JÁ REALIZOU O PAGAMENTO PARA ESTE PASSEIO, REDIRECIONANDO PARA A ÁREA DE PAGAMENTO </p>";
                    echo" <script>
                              setTimeout(function () {
                                window.location.href = 'listaPasseio.php?id=".$idPasseio."';
                            }, 5000);
                          </script>
                    ";
                  }
                }
              }
            }
          ?>
          
          </select>
        </div>
        <input type="submit" class="btn btn-primary btn-sm" value="FINALIZAR PAGAMENTO" name="buttonFinalizarPagamento">
        
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idClienteSelecionado" id="idCliente" 
          readonly="readonly" value="<?php echo $idCliente ?>">
        <input type="hidden" class="form-control col-sm-1 ml-3" name="idPasseioSelecionado" id="idPasseio" 
          readonly="readonly" value="<?php echo $idPasseioSelecionado ?>">
      </form>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>