<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	 
// Check if the user is logged in, if not then redirect him to login page

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>LOGS</title>
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

      <?php 
        if($_SESSION['nivelAcesso'] != 0){
            echo "<h1 class='bg-danger text-white text-center mt-5'> ACESSO NEGADO</h1>";
        }else{

        
      ?>
    <div class="list-group" id="list-tab" role="tablist">
            <?php $buscarInformacoesLog = "SELECT * FROM log ORDER BY `log`.`dataLog` DESC";
                $resultadoInformacoesLog = mysqli_query($conexao, $buscarInformacoesLog);
                while($rowInformacoesLog = mysqli_fetch_assoc($resultadoInformacoesLog)){
                    $id = $rowInformacoesLog['idUser'];
                    $nomePasseio = $rowInformacoesLog['nomePasseio'];
                    $nomeCliente = $rowInformacoesLog['nomecliente'];
                    $dataPasseio = date_create($rowInformacoesLog['dataPasseio']);
                    $valorPago = $rowInformacoesLog['valorPago'];
                    $dataLog = $rowInformacoesLog['dataLog'];
                    $tipoModificacao = $rowInformacoesLog['tipoModificacao'];
                    $idLog = $rowInformacoesLog['idLog'];
                    $diferenca = calculaIntervaloTempo($conn, null, null, null, $dataLog);
                    $dias = $diferenca->d;
                    $meses = $diferenca->m;
                    $countdowDeletarLog = ($dias - 30) *-1;
                    if($meses >= 1){
                        $getData = "DELETE FROM log WHERE idLog=$idLog";
                        apagarRegistros($conexao, "log", "idLog=$idLog");
                    }
                
                    $dataLog = date_create($rowInformacoesLog['dataLog']);
                    $buscarInformacoesUser = "SELECT username FROM users WHERE id=$id ";
                    $resultadoInformacoesUser = mysqli_query($conexao, $buscarInformacoesUser);
                    $rowInformacoesUser = mysqli_fetch_assoc($resultadoInformacoesUser);
                    $nomeUser = $rowInformacoesUser['username'];
                    $pos = strpos($tipoModificacao, 'FALHA');
                    #var_dump($pos); 
            ?>
            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" role="tab">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 <?php   $alert = ($pos == true)? "alert-danger":"alert-success"; echo $alert;?>"><?php echo strtoupper( $nomeUser);?>  <?php echo $tipoModificacao;?> EM: <?php echo date_format($dataLog, "d/m/Y H:i:s") ?></h5>
                    <small class="text-muted"><?php echo $idLog;?></small>
                </div>
                <p class="mb-1">PASSEIO: <?php echo $nomePasseio; ?> | DATA: <?php echo date_format($dataPasseio, "d/m/Y"); ?> | CLIENTE: <?php echo $nomeCliente ?> | VALOR PAGO: <?php echo $valorPago ?></p>
                <small>ESTE REGISTRO SERÁ APAGADO EM <?php echo $countdowDeletarLog;?> Dias</small>
            </a>
    </div>
    <?php
          }    
    }
    ?>
    
</body>
</html>