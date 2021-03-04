<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>PESQUISAR CLIENTE</title>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="?navbarNav"
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
          <a class="nav-link dropdown-toggle active" href="?" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            PESQUISAR
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item active" href="">CLIENTE</a>
            <a class="dropdown-item" href="pesquisarPasseio.php">PASSEIO</a>
          </div>
        </li>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="?" id="navbarDropdownMenuLink" data-toggle="dropdown"
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
  <!-- TODO FORM -->
  <div class="container-fluid mt-4">
    <div class="container-fluid ">
      <p class="h2 text-center">PESQUISAR CLIENTE</p>
      <form action="" autocomplete="off" method="POST" name="formularioPesquisarCliente">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="nomeCliente">INSIRA: </label>
          <div class="col-sm-6">
            <input type="text" class="form-control col-sm-6" name="valorPesquisaCliente" id="" placeholder="CPF OU NOME OU TELEFONE"
              onkeydown="upperCaseF(this)">
            <input type="hidden" class="form-control col-sm-6" name="" id="paginaSelecionada" placeholder="página"
              onkeydown="upperCaseF(this)">
          </div>


        </div>
        <input type="submit" value="PESQUISAR" name="enviarPesqCliente" id="enviarPesqCliente" class="btn btn-primary btn-lg">
      </form>

    </div>
  </div>
  <div class="table mt-5">
    <table class="table table-hover table-dark">
      <thead>
        <tr>
          <th>NOME</th>
          <th>NASCIMENTO</th>
          <th>IDADE</th>
          <th>REFERÊNCIA</th>
          <th>TEL. CLIENTE</th>
          <th>EMAIL</th>
          <th>REDE SOCIAL</th>


        </tr>
      </thead>
      <tbody>
        <?php
/* -----------------------------------------------------------------------------------------------------  */
          $enviarPesqNome = filter_input(INPUT_POST, 'enviarPesqCliente', FILTER_SANITIZE_STRING);
/* -----------------------------------------------------------------------------------------------------  */
          if($enviarPesqNome) {
              
/* -----------------------------------------------------------------------------------------------------  */
              $valorPesquisaCliente = filter_input(INPUT_POST, 'valorPesquisaCliente', FILTER_SANITIZE_STRING);
/* -----------------------------------------------------------------------------------------------------  */
              if(empty($valorPesquisaCliente)){
                $vazio = true;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c ORDER BY c.nomeCliente ";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                                              $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);
                
                
            
                $quantidadePagina = 50;
            
                $numeroPaginasTotal = ceil($totalCliente / $quantidadePagina);
            
                #$inicio = ($quantidadePagina * $pagina) - $quantidadePagina;
                $numeroPaginas = $numeroPaginasTotal;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c  ORDER BY c.nomeCliente LIMIT 1, $quantidadePagina";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                
              }else{
                $vazio = false;
                $paginaPesquisa =1;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' OR c.cpfCliente LIKE '%$valorPesquisaCliente%' OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' ORDER BY c.nomeCliente";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                                              $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);
                                              echo $totalCliente;
                

                $numeroPaginasTotal = 1;

                $quantidadePagina = 500;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' OR c.cpfCliente LIKE '%$valorPesquisaCliente%' OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' ORDER BY c.nomeCliente LIMIT 0, $quantidadePagina";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                                              $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);

              }

              
              
              while($valorPesquisaCliente = mysqli_fetch_assoc($resultadoPesquisaCliente)){
                $dataNascimento = (empty($valorPesquisaCliente ['dataNascimento']) OR $valorPesquisaCliente['dataNascimento'] == "0000-00-00")? "" : date_create($valorPesquisaCliente['dataNascimento']);
                
                $idCliente =  $valorPesquisaCliente['idCliente'];
        ?>
        <tr style="color:<?php if($valorPesquisaCliente['statusCliente'] == 0 ) {echo"red";}?>;">
          <th><?php echo $valorPesquisaCliente ['nomeCliente']. "<BR/>";?></th> 
          <td><?php 
                    $dataNascimentoFormatada = (empty($dataNascimento) OR $dataNascimento == "0000-00-00")? "" : date_format($dataNascimento, "d/m/Y") ."<BR/>";
          
          echo $dataNascimentoFormatada?></td>
          <td><?php echo $valorPesquisaCliente ['idadeCliente']. "<BR/>";?></td>
          <td><?php echo $valorPesquisaCliente ['referencia']. "<BR/>";?></td>
          <td><?php echo $valorPesquisaCliente ['telefoneCliente']. "<BR/>";?></td>
          <td><?php echo $valorPesquisaCliente ['emailCliente']. "<BR/>";?></td>
          <td><?php echo $valorPesquisaCliente ['redeSocial']. "<BR/>";?></td>
          <td></td>
          <td>
            <?php echo "<a class='btn btn-primary btn-sm' target='_blank' rel='noopener noreferrer' href='editarCliente.php?id=" . $idCliente . "'>EDITAR</a><br>"; ?>
          </td>
          <td>
            
            <?php 
              if($valorPesquisaCliente['statusCliente'] == 1){
                echo "<a class='btn btn-primary btn-sm' target='_blank' rel='noopener noreferrer' href='pagamentoCliente.php?id="  . $idCliente . "' >PAGAR</a><br><hr>";
              }
            ?>
          </td>
          <td>
          <?php
            if($valorPesquisaCliente['statusCliente'] == 0){
              echo "<a class='btn btn-primary btn-sm' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarCliente.php?id="  . $idCliente . "& status=0&nomeCliente=".$valorPesquisaCliente['nomeCliente'] ."' >ATIVAR</a><br><hr>";
            }else{
              echo "<a class='btn btn-primary btn-sm' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarCliente.php?id="  . $idCliente . "& status=1&nomeCliente=".$valorPesquisaCliente['nomeCliente'] ."' >DESATIVAR</a><br><hr>";
            } 
          ?>
          </td>
        </tr>
        <?php
              }
            }
        ?>
          
      </tbody>
    </table>
    
  </div>
  
  <script src="config/script.php"></script>
  
</body>

</html>