<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
/* -----------------------------------------------------------------------------------------------------  */
    $idClienteGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */
    $queryBuscaPeloIdCliente = "SELECT * FROM cliente WHERE idCliente='$idClienteGet'";
                          $resultadoBuscaPeloIdCliente = mysqli_query($conexao, $queryBuscaPeloIdCliente);
                          $rowResultadoBuscaPeloIdCliente = mysqli_fetch_assoc($resultadoBuscaPeloIdCliente);
/* -----------------------------------------------------------------------------------------------------  */
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>EDITAR CLIENTE</title>
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
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            CADASTRAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item " href="cadastroCliente.php">CLIENTE</a>
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
  <!-- TODO FORM -->
  <div class="container-fluid mt-4">
    <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
    <div class="container-fluid ">
      <form action="SCRIPTS/atualizaCliente.php" autocomplete="off" method="POST" onclick=ageCount()>
      <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $rowResultadoBuscaPeloIdCliente ['idCliente'] ?>">
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="nomeCliente">NOME</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" placeholder="NOME COMPLETO"
              onkeydown="upperCaseF(this)" value="<?php echo $rowResultadoBuscaPeloIdCliente ['nomeCliente']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="emailCliente">EMAIL</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" name="emailCliente" id="emailCliente"
              placeholder="EMAIL DO CLIENTE" value="<?php echo $rowResultadoBuscaPeloIdCliente ['emailCliente']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="rgCliente">RG</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="rgCliente" id="rgCliente" placeholder="RG" value="<?php echo $rowResultadoBuscaPeloIdCliente ['rgCliente']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="orgaoEmissor">EMISSOR</label>
          <select class="form-control col-sm-3 ml-3" name="orgaoEmissor" id="orgaoEmissor">
            <option value="<?php echo $rowResultadoBuscaPeloIdCliente ['orgaoEmissor']; ?>"><?php echo $rowResultadoBuscaPeloIdCliente ['orgaoEmissor']; ?></option>
            <option value="DETRAN">DETRAN</option>
            <option value="IFP"> IFP</option>
            <option value="OAB">OAB</option>
            <option value="CERTIDAO NASCIMENTO">CERTIDAO NASCIMENTO</option>
            <option value="SSP">SSP</option>
            <option value="DIC">DIC</option>
            <option value="MDMB">MDMB</option>
            <option value="IIRG">IIRG</option>
            <option value="SSPIIPM">SSPIIPM</option>
            <option value="RGD">RGD</option>
            <option value="SSPCE">SSPCE</option>
            <option value="MB">MB</option>
            <option value="SE/DPMAF/DPF">SE/DPMAF/DPF</option>
            <option value="IFRJ">IFRJ</option>
            <option value="CRC">CRC</option>
            <option value="CGPI">CGPI</option>
            <option value="SSP/PB"> SSP/PB</option>
            <option value="CNH">CNH</option>
            <option value="MTPS">MTPS</option>
            <option value="PMERJ">PMERJ</option>
          </select>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="cpfCliente">CPF</label>
          <div class="col-sm-6">
            <input type="text" class="form-control " name="cpfCliente" id="cpfCliente" placeholder="CPF DO CLIENTE" value="<?php echo $rowResultadoBuscaPeloIdCliente ['cpfCliente']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="telefoneCliente">TELEFONE</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="telefoneCliente" id="telefoneCliente"
              placeholder="XX 9 XXXX-XXXX" value="<?php echo $rowResultadoBuscaPeloIdCliente ['telefoneCliente']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="dataNascimento">NASCIMENTO</label>
          <input type="date" class="form-control col-sm-3 ml-3" name="dataNascimento" id="dataNascimento"
          onblur="ageCount(dataNascimento.value)" value="<?php echo $rowResultadoBuscaPeloIdCliente ['dataNascimento']; ?>">
        </div>
        <div class="form-group row">
        <label class="col-sm-1 col-form-label " for="idadeCliente">IDADE</label>
          <input type="text" class="form-control col-sm-3 ml-3" name="idadeCliente" id="idadeCliente" readonly="readonly"
            onblur="ageCount()">
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-1 pt-0">CPF CONSULTADO</legend>
            <div class="col-sm-5">
              <div class="form-check">
                <?php
                  if( $rowResultadoBuscaPeloIdCliente ['cpfConsultado'] == 1){
                    echo"
                    <div class='form-check'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoSim' value='1'
                      onclick='changeInputDate()' checked>
                      <label class='form-check-label' for='cpfConsultadoSim'>
                        SIM
                      </label>
                    </div>
                    <div class='form-check'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoNao' value='0'
                      onclick='changeInputDate()' >
                      <label class='form-check-label' for='cpfConsultadoNao'>
                        NÃO
                      </label>
                    </div>";
                  }else {
                    echo"
                    <div class='form-check'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoSim' value='1'
                      onclick='changeInputDate()' >
                      <label class='form-check-label' for='cpfConsultadoSim'>
                        SIM
                      </label>
                    </div>
                    <div class='form-check'>  
                      <input class='form-check-input' type='radio' name='cpfConsultado' id='cpfConsultadoNao' value='0'
                      onclick='changeInputDate()' checked >
                      <label class='form-check-label' for='cpfConsultadoNao'>
                        NÃO
                      </label>
                    </div>";
                  }
                ?>
              </div>
            </div>

          </div>
        </fieldset>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="dataCpfConsultado">DATA DA CONSULTA</label>
          <input type="date" class="form-control col-sm-3 ml-3" name="dataCpfConsultado" id="dataCpfConsultado"
            placeholder="MM/DD/AAAA" onclick="setInputDate()" value="<?php echo $rowResultadoBuscaPeloIdCliente ['dataCpfConsultado']; ?>">
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="referenciaCliente">REFERÊNCIA</label>
          <textarea class="form-control col-sm-3 ml-3" name="referenciaCliente" id="referenciaCliente" cols="3" rows="1"
            placeholder="INFORMAÇÕES" onkeydown="upperCaseF(this)"><?php echo $rowResultadoBuscaPeloIdCliente ['referencia'] ?></textarea>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="telefoneContato">TELEF. CONTATO</label>
          <input class="form-control col-sm-3 ml-3" type="tel" name="telefoneContato" id="telefoneContato"
            placeholder="XX 9 XXXX-XXXX" value="<?php echo $rowResultadoBuscaPeloIdCliente ['telefoneContato']; ?>">
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="nomeContato">PESSOA CONTATO</label>
          <input class="form-control col-sm-3 ml-3" type="text" name="nomeContato" id="nomeContato"
            placeholder="QUEM CONTATAR" onkeydown="upperCaseF(this)" value="<?php echo $rowResultadoBuscaPeloIdCliente ['pessoaContato']; ?>">
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="redeSocial">REDES SOCIAIS</label>
          <textarea class="form-control col-sm-3 ml-3" name="redeSocial" id="redeSocial" cols="10" rows="5"
            placeholder="REDES SOCIAIS" onkeydown="upperCaseF(this)"><?php echo $rowResultadoBuscaPeloIdCliente ['redeSocial'] ?></textarea>
        </div>
        <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-primary btn-lg">ATUALIZAR</button>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg ml-5" data-toggle="modal" data-target="#exampleModal">
          HISTÓRICO
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PAGAMENTOS DESTE CLIENTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-hover table-dark">
                  <thead>
                    <tr>
                      <th>PASSEIO</th>
                      <th>DATA</th>
                      <th>STATUS</th>
                    </tr>
                  </thead>
                  <tbody>
                      
                <?php
                  $queryBuscaPagamentoCliente = "SELECT pp.idPasseio, pp.statusPagamento, p.nomePasseio, p.dataPasseio FROM pagamento_passeio pp, passeio p WHERE idCliente=$idClienteGet AND pp.idPasseio=p.idPasseio ORDER BY p.dataPasseio DESC ";
                  $resultadoBuscaPagamentoCliente = mysqli_query($conexao, $queryBuscaPagamentoCliente);
                  while($rowPagamentoCliente = mysqli_fetch_assoc($resultadoBuscaPagamentoCliente)){
                    $dataPasseio =  date_create($rowPagamentoCliente['dataPasseio']);
                    if ($rowPagamentoCliente['statusPagamento'] == 0){
                      $statusPagamento = "QUITADO";
                    }else{
                      $statusPagamento = "NÃO QUITADO";
                    }
                  ?> 
                  <tr>
                    <th><?php echo $rowPagamentoCliente['nomePasseio']. "</br>";?></th>
                    <td><?php echo date_format($dataPasseio, "d/m/Y"). "</br>";?></td>
                    <td><?php echo $statusPagamento. "</br>";?></td>
                  </tr>
                <?php
                  }
                ?>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>