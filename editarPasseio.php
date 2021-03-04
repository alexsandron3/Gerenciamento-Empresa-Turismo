<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
/* -----------------------------------------------------------------------------------------------------  */
    $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
/* -----------------------------------------------------------------------------------------------------  */

    $queryBuscaPeloIdPasseio = "SELECT * FROM passeio p WHERE idPasseio='$idPasseioGet'";
                            $resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
                            $rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio);

                            $passeioAtivo = ($rowBuscaPasseio['statusPasseio'] == 1) ? "checked": " ";
                            $passeioInativo = ($rowBuscaPasseio['statusPasseio'] == 0) ? "checked": " ";

/* -----------------------------------------------------------------------------------------------------  */
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>EDITAR PASSEIO</title>
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
  <!-- TODO FORM -->
  <div class="container-fluid mt-4">
    <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
    
    <div class="container-fluid ">
      <form action="SCRIPTS/atualizaPasseio.php" autocomplete="off" method="POST">
        <div class="form-group row">
          <label class="col-sm-1 col-form-label latinTextBox" for="nomePasseio">NOME DO PASSEIO</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nomePasseio" id="latinTextBox" placeholder="NOME DO PASSEIO" required="required" value="<?php echo $rowBuscaPasseio ['nomePasseio'] ?>"
              onkeydown="upperCaseF(this)">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="localPasseio">LOCAL DO PASSEIO</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="localPasseio" id="LocalPasseiolatinTextBox" placeholder="LOCAL DO PASSEIO" value="<?php echo $rowBuscaPasseio ['localPasseio'] ?>"
              onkeydown="upperCaseF(this)">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="valorPasseio">VALOR DO PASSEIO</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="valorPasseio" id="currencyTextBox" placeholder="VALOR DO PASSEIO" value="<?php echo $rowBuscaPasseio ['valorPasseio'] ?>"
              onkeydown="upperCaseF(this)">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="lotacao"> LOTAÇÃO</label>
          <div class="col-sm-1">
            <input type="text" class="form-control" name="lotacao" id="intLimitTextBox" placeholder="0-200" value="<?php echo $rowBuscaPasseio ['lotacao'] ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="idadeIsencao"> ISENÇÃO</label>
          <div class="col-sm-1">
            <input type="number" class="form-control" name="idadeIsencao" id="idadeIsencao" placeholder="0-200" required="required" value="<?php echo $rowBuscaPasseio ['idadeIsencao'] ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="dataPasseio">DATA DO PASSEIO</label>
          <div class="col-sm-6">
            <input type="date" class="form-control col-sm-4" name="dataPasseio" id="dataPasseio" required="required" value="<?php echo $rowBuscaPasseio ['dataPasseio'] ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="anotacoesPasseio">ANOTAÇÕES</label>
          <textarea class="form-control col-sm-3 ml-3" name="anotacoesPasseio" id="anotacoesPasseio" cols="3" rows="1" value="<?php echo $rowBuscaPasseio ['anotacoes'] ?>"
            placeholder="ANOTAÇÕES" onkeydown="upperCaseF(this)"></textarea>
        </div>
        <div class="row">
          <legend class="col-form-label col-sm-1">STATUS DO PASSEIO</legend>
          <div class="col-sm">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="statusPasseio" id="statusPasseioAtivo" value="1" <?php echo $passeioAtivo ?>>
                <label class="form-check-label" for="statusPasseioAtivo">
                  ATIVO
                </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="statusPasseio" id="statusPasseioInativo" value="0" <?php echo $passeioInativo ?>>
              <label class="form-check-label" for="statusPasseioInativo">
                ENCERRADO
              </label>
            </div>
          </div>  
        </div>
        <input type="hidden" name="idPasseio" id="idPasseio" value="<?php echo $rowBuscaPasseio ['idPasseio'] ?>">
        <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-primary btn-lg">ATUALIZAR</button>
      </form>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>

</html>