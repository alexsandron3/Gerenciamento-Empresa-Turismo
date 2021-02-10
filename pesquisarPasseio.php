<?php
    session_start();
    include_once("PHP/conexao.php");
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
  <title>PESQUISAR PASSEIO</title>
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
            <a class="dropdown-item active" href="pesquisarPasseio.php">PASSEIO</a>
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
            <a class="dropdown-item" href="cadastroCliente.php">CLIENTE</a>
            <a class="dropdown-item" href="cadastroPasseio.php">PASSEIO</a>
            <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- TODO FORM -->
  <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
  <div class="container-fluid mt-4">
    <div class="container-fluid ">
      <p class="h2 text-center">PESQUISAR PASSEIO</p>
      <form action="" autocomplete="off" method="POST">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="nomePasseio">PESQUISAR</label>
            <input type="text" class="form-control col-sm-4" name="valorPesquisaPasseio" id="" placeholder="NOME OU LOCAL"
              onkeydown="upperCaseF(this)">
              <label class="col-sm-2 col-form-label" for="inicioDataPasseio">DATA:</label>
            <input type="date" class="form-control col-sm-3" name="dataPasseio" id="dataPasseio">
        </div>
        <input type="submit" value="PESQUISAR" name="enviaPesqNome" class="btn btn-primary btn-lg">
        <input type="submit" value="PESQUISAR" name="enviaPesqData" class="btn btn-primary btn-lg float-right">
      </form>
    </div>
  </div>
  <div class="table mt-5">
    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOME</th>
          <th>DATA</th>
          <th>LOCAL</th>
          <th>VAGAS</th>
        </tr>
      </thead>
      <tbody>
        <?php
/* -----------------------------------------------------------------------------------------------------  */
          $enviaPesqNome = filter_input(INPUT_POST, 'enviaPesqNome', FILTER_SANITIZE_STRING);
          $enviaPesqData = filter_input(INPUT_POST, 'enviaPesqData', FILTER_SANITIZE_STRING);
/* -----------------------------------------------------------------------------------------------------  */
          if($enviaPesqNome) {
/* -----------------------------------------------------------------------------------------------------  */
              $valorPesquisaPasseio     = filter_input(INPUT_POST, 'valorPesquisaPasseio', FILTER_SANITIZE_STRING);
              
/* -----------------------------------------------------------------------------------------------------  */
              $queryPesquisaPasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio, p.localPasseio, p.idPasseio, p.lotacao 
                                      FROM passeio p WHERE p.nomePasseio LIKE '%$valorPesquisaPasseio%' OR p.localPasseio LIKE '%$valorPesquisaPasseio%'  OR p.dataPasseio='$valorPesquisaPasseio' ORDER BY dataPasseio";
                                      $resultadoPesquisaPasseio = mysqli_query($conexao, $queryPesquisaPasseio);
                                      while($valorPesquisaPasseio = mysqli_fetch_assoc($resultadoPesquisaPasseio)){
                                        $dataPasseio =  date_create($valorPesquisaPasseio['dataPasseio']);
                                        $idPasseio = $valorPesquisaPasseio['idPasseio'];
        ?>
        <tr>
          <th><?php echo $valorPesquisaPasseio ['idPasseio']. "<BR/>";?></th>
          <td><?php echo $valorPesquisaPasseio ['nomePasseio']. "<BR/>";?></td>
          <td><?php echo date_format($dataPasseio, "d/m/Y") ."<BR/>";?></td>
          <td><?php echo $valorPesquisaPasseio ['localPasseio']. "<BR/>";?></td>
          <td></td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm ml-4' href='listaPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >LISTA</a><br>";?>
            <?php echo "<a class='btn btn-primary btn-sm mt-1' target='_blank' rel='noopener noreferrer' href='relatoriosPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >RELATÓRIOS</a><br>";?>
          </td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm ml-1'  target='_blank' rel='noopener noreferrer' href='editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'] . "'>EDITAR  </a><br>"; ?>
            <?php echo "<a class='btn btn-primary btn-sm mt-1' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarPasseio.php?id="  .  $valorPesquisaPasseio['idPasseio'] . "' >DELETAR</a><br><hr>";?>
          </td>
        </tr>
        <?php
              }
          }elseif ($enviaPesqData){
            $valorPesquisaPasseioData = filter_input(INPUT_POST, 'dataPasseio',          FILTER_SANITIZE_STRING);
            $queryPesquisaPasseio = "SELECT p.idPasseio, p.nomePasseio, p.dataPasseio, p.localPasseio, p.idPasseio 
                                      FROM passeio p WHERE p.dataPasseio='$valorPesquisaPasseioData' ORDER BY dataPasseio";
                                    $resultadoPesquisaPasseio = mysqli_query($conexao, $queryPesquisaPasseio);
                                    while($valorPesquisaPasseio = mysqli_fetch_assoc($resultadoPesquisaPasseio)){
                                      $dataPasseio =  date_create($valorPesquisaPasseio['dataPasseio']);
                                      $idPasseio = $valorPesquisaPasseio['idPasseio'];
      ?>
      <tr>
          <th><?php echo $valorPesquisaPasseio ['idPasseio']. "<BR/>";?></th>
          <td><?php echo $valorPesquisaPasseio ['nomePasseio']. "<BR/>";?></td>
          <td><?php echo date_format($dataPasseio, "d/m/Y") ."<BR/>";?></td>
          <td><?php echo $valorPesquisaPasseio ['localPasseio']. "<BR/>";?></td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm ml-4' href='listaPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >LISTA</a><br>";?>
            <?php echo "<a class='btn btn-primary btn-sm mt-1' target='_blank' rel='noopener noreferrer' href='relatoriosPasseio.php?id="  . $valorPesquisaPasseio['idPasseio'] . "' >RELATÓRIOS</a><br>";?>
          </td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm ml-1'  target='_blank' rel='noopener noreferrer' href='editarPasseio.php?id=" . $valorPesquisaPasseio['idPasseio'] . "'>EDITAR  </a><br>"; ?>
            <?php echo "<a class='btn btn-primary btn-sm mt-1' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarPasseio.php?id="  .  $valorPesquisaPasseio['idPasseio'] . "' >DELETAR</a><br><hr>";?>
          </td>
        </tr>
        <?php
          }

            };
        ?>
      </tbody>
    </table>
  </div>
  <script src="config/script.php"></script>
</body>

</html>