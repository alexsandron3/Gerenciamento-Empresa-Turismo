<?php
    session_start();
    include_once("PHP/conexao.php");
    $pagina = (isset($_GET['pagina']))? $_GET['pagina']:1;
      


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
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="?" id="navbarDropdownMenuLink" data-toggle="dropdown"
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
                //echo $numeroPaginasTotal;
            
                $inicio = ($quantidadePagina * $pagina) - $quantidadePagina;
                $numeroPaginas = $numeroPaginasTotal;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c  ORDER BY c.nomeCliente LIMIT $inicio, $quantidadePagina";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                
              }else{
                //header("Location: pesquisarCliente.php");
                $vazio = false;
                $paginaPesquisa =1;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' OR c.cpfCliente LIKE '%$valorPesquisaCliente%' OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' ORDER BY c.nomeCliente";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                                              $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);
                                              echo $totalCliente;
                
            
               /*  $quantidadePagina = 5;
            
                echo $numeroPaginasTotal;
            
                $inicio = ($quantidadePagina * $paginaPesquisa) - $quantidadePagina;
                echo $inicio;
                $totalCliente = mysqli_num_rows($resultadoQtdClientes); */
                $numeroPaginasTotal = 1;

                $quantidadePagina = 500;
                $queryPesquisaCliente = "     SELECT c.nomeCliente, c.dataNascimento, c.idadeCliente, c.referencia, c.telefoneCliente, c.emailCliente, c.emailCliente, c.redeSocial, c.cpfCliente, c.idCliente, c.statusCliente 
                                              FROM cliente c WHERE upper(c.nomeCliente) LIKE '%$valorPesquisaCliente%' OR c.cpfCliente LIKE '%$valorPesquisaCliente%' OR c.telefoneCliente LIKE '%$valorPesquisaCliente%' ORDER BY c.nomeCliente LIMIT 0, $quantidadePagina";
                                              $resultadoPesquisaCliente = mysqli_query($conexao, $queryPesquisaCliente);
                                              $totalCliente = mysqli_num_rows($resultadoPesquisaCliente);

              }

              
              
              //echo $totalCliente;
              while($valorPesquisaCliente = mysqli_fetch_assoc($resultadoPesquisaCliente)){
                $dataNascimento =  date_create($valorPesquisaCliente['dataNascimento']);
                $idCliente =  $valorPesquisaCliente['idCliente'];
        ?>
        <tr style="color:<?php if($valorPesquisaCliente['statusCliente'] == 0 ) {echo"red";}?>;">
          <th><?php echo $valorPesquisaCliente ['nomeCliente']. "<BR/>";?></th> 
          <td><?php echo date_format($dataNascimento, "d/m/Y") ."<BR/>";?></td>
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
              echo "<a class='btn btn-primary btn-sm' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarCliente.php?id="  . $idCliente . "& status=0' >ATIVAR</a><br><hr>";
            }else{
              echo "<a class='btn btn-primary btn-sm' onclick='javascript:confirmationDelete($(this));return false;' target='_blank' rel='noopener noreferrer' href='SCRIPTS/apagarCliente.php?id="  . $idCliente . "& status=1' >DESATIVAR</a><br><hr>";
            } 
          ?>
          </td>
        </tr>
        <?php
              }
          
        ?>
          
      </tbody>
    </table>
    
  </div>
  <nav aria-label="Navegação de página">
      <ul class="pagination justify-content-center">
          <?php
          if($vazio = false){
            $pagina =1;
          }
          if($pagina == 1){
            $status = "disabled";
          }else{
            $status = "";
          }
            echo"<li class='page-item $status'><a class='page-link' onclick='cliquePrimeirPagina()' id='clickPaginaPrimeira' href='#'>PRIMEIRA</a></li>";

          ?>

        
        
          <?php
          $maxLinks = 1;
            for($paginaAnterior = $pagina - $maxLinks; $paginaAnterior <= $pagina -1; $paginaAnterior++ ){
              if($paginaAnterior >=1 AND $vazio = true){
                $mudarPaginaAnterior = $paginaAnterior;
                
                echo"<li class='page-item'><a class='page-link' onclick='cliquePaginaAnterior()' id='clickPaginaAnterior' href='#'>$paginaAnterior</a></li>";
              }
              
            }
            echo"<li class='page-item active'><a class='page-link' onclick='trocarPaginaPesquisa()' href='#'>$pagina</a></li>";
            for($paginaDepois = $pagina +1; $paginaDepois<= $pagina + $maxLinks; $paginaDepois++){
              $mudarPaginaDepois = $pagina +1;
              if($paginaDepois <= $numeroPaginasTotal AND $vazio = true){
               
                echo"<li class='page-item'><a class='page-link' onclick='cliquePaginaDepois()' id='clickPaginaDepois' href='#' '>$paginaDepois</a></li>";
              }
            }
            if($pagina == $numeroPaginasTotal AND $vazio = true){
              $statusUltimaPagina = "disabled";
              $mudarPaginaDepois = $numeroPaginasTotal;  
              echo"<li class='page-item $statusUltimaPagina'><a class='page-link' onclick='cliquePaginaUltima()' id='clickPaginaUltima' href='#'>ÚLTIMA</a></li>";
            }else{
              $statusUltimaPagina= "";
              $mudarUltimaPagina = $numeroPaginasTotal;
              echo"<li class='page-item $statusUltimaPagina'><a class='page-link' onclick='cliquePaginaUltima()' id='clickPaginaUltima' href='#'>ÚLTIMA</a></li>";
            }
          }?>
          <input type="hidden" name="" id="paginaPrimeira" onclick="trocarPaginaPesquisa()" value="<?php echo 1?>"> 
          <input type="hidden" name="" id="paginaAnterior" onclick="trocarPaginaPesquisa()" value="<?php echo $mudarPaginaAnterior?>"> 
          <input type="hidden" name="" id="paginaAtual" onclick="trocarPaginaPesquisa()" value="<?php echo $pagina?>"> 
          <input type="hidden" name="" id="paginaDepois" onclick="trocarPaginaPesquisa()" value="<?php echo $mudarPaginaDepois?>"> 
          <input type="hidden" name="" id="paginaUltima" onclick="trocarPaginaPesquisa()" value="<?php echo $mudarUltimaPagina?>"> 
      </ul>
  </nav>
  
  <script src="config/script.php"></script>
  
</body>

</html>