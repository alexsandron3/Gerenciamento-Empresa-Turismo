<?php
    session_start();
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
  <title>CADASTRAR CLIENTE</title>
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
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
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
  <div class="container-fluid mt-4" onblur="ageCount()">
    <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
    <div class="container-fluid ">
      <form action="SCRIPTS/registroCliente.php" autocomplete="off" method="POST">
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="nomeCliente">NOME</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="nomeCliente" id="nomeCliente" placeholder="NOME COMPLETO" required="required"
              onkeydown="upperCaseF(this)">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="emailCliente">EMAIL</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" name="emailCliente" id="emailCliente"
              placeholder="EMAIL DO CLIENTE">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="rgCliente">RG</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="rgCliente" id="rgCliente" placeholder="RG">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="orgaoEmissor">EMISSOR</label>
          <select class="form-control col-sm-3 ml-3" name="orgaoEmissor" id="orgaoEmissor">
            <option value="">SELECIONAR</option>
            <option value="DETRAN">DETRAN</option>
            <option value="IFP"> IFP</option>
            <option value="OAB">OAB</option>
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
          </select>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="cpfCliente">CPF</label>
          <div class="col-sm-6">
            <input type="text" class="form-control " name="cpfCliente" id="cpfCliente" placeholder="CPF DO CLIENTE">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="telefoneCliente">TELEFONE</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="telefoneCliente" id="telefoneCliente"
              placeholder="55 9 1234 5678">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="dataNascimento">NASCIMENTO</label>
          <input type="date" class="form-control col-sm-3 ml-3" name="dataNascimento" id="dataNascimento"
            onblur="ageCount(dataNascimento.value)" >

        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="idadeCliente">IDADE DO CLIENTE</label>
          <div class="col-sm-6">
          <input type="text" class="form-control col-md-1" name="idadeCliente" id="idadeCliente" readonly="readonly"
            onblur="ageCount()">
          </div>
        </div>
        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-1 pt-0">CPF CONSULTADO</legend>
            <div class="col-sm-5">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoSim" value="1"
                  onclick="changeInputDate()">
                <label class="form-check-label" for="cpfConsultadoSim">
                  SIM
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cpfConsultado" id="cpfConsultadoNao" value="0"
                  onclick="changeInputDate()">
                <label class="form-check-label" for="cpfConsultadoNao">
                  NÃO
                </label>
              </div>
            </div>

          </div>
        </fieldset>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="dataCpfConsultado">DATA DA CONSULTA</label>
          <input type="date" class="form-control col-sm-3 ml-3" name="dataCpfConsultado" id="dataCpfConsultado"
            placeholder="MM/DD/AAAA" onclick="setInputDate()">
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="referenciaCliente">REFERÊNCIA</label>
          <textarea class="form-control col-sm-3 ml-3" name="referenciaCliente" id="referenciaCliente" cols="3" rows="1"
            placeholder="INFORMAÇÕES" onkeydown="upperCaseF(this)"></textarea>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="telefoneContato">TELEF. CONTATO</label>
          <input class="form-control col-sm-3 ml-3" type="tel" name="telefoneContato" id="telefoneContato"
            placeholder="XX 9 XXXX-XXXX">
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="nomeContato">PESSOA CONTATO</label>
          <input class="form-control col-sm-3 ml-3" type="text" name="nomeContato" id="nomeContato"
            placeholder="QUEM CONTATAR" onkeydown="upperCaseF(this)">
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label" for="redeSocial">REDES SOCIAIS</label>
          <textarea class="form-control col-sm-3 ml-3" name="redeSocial" id="redeSocial" cols="3" rows="1"
            placeholder="REDES SOCIAIS" onkeydown="upperCaseF(this)"></textarea>
        </div>
        <button type="submit" name="cadastrarClienteBtn" id="submit" class="btn btn-primary btn-lg">CADASTRAR</button>
      </form>
    </div>
  </div>
  <script src="config/script.php"></script>
</body>
</html>