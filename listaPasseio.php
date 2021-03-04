<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
/* -----------------------------------------------------------------------------------------------------  */
  $idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
  $ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
  if(empty($ordemPesquisa)){
    $ordemPesquisa = 'nomeCliente';
  }
/* -----------------------------------------------------------------------------------------------------  */

  $queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.rgCliente, c.dataCpfConsultado, c.telefoneCliente, c.orgaoEmissor, c.idadeCliente, c.referencia,
                              pp.statusPagamento, pp.idPagamento, pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro, pp.dataPagamento 
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente ORDER BY $ordemPesquisa ";
                          $resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
/* -----------------------------------------------------------------------------------------------------  */
 
  $pegarNomePasseio = "SELECT nomePasseio, lotacao, dataPasseio FROM passeio WHERE idPasseio='$idPasseioGet'";
                        $resultadopegarNomePasseio = mysqli_query($conexao, $pegarNomePasseio);
                        $rowpegarNomePasseio = mysqli_fetch_assoc($resultadopegarNomePasseio);
                        $nomePasseioTitulo = $rowpegarNomePasseio ['nomePasseio'];
                        $dataPasseio = date_create($rowpegarNomePasseio ['dataPasseio']);
                        $lotacao = $rowpegarNomePasseio ['lotacao'];
/* -----------------------------------------------------------------------------------------------------  */
?>



<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  
  <title>LISTA CLIENTES </title>
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
  <div class="table mt-3">
        <?php  echo"<p class='h5 text-center alert-info '>" .$nomePasseioTitulo." ". date_format($dataPasseio, "d/m/Y") ." <br/>
         <span class='h5'> LOTAÇÃO: $lotacao </span> 
        | <span class='h5' onclick='tituloListagem()' id='confirmados' >  CONFIRMADOS: </span> 
        | <span class='h5' onclick='tituloListagem()' id='interessados'>  INTERESSADOS: </span>
        | <span class='h5' onclick='tituloListagem()' id='criancas'>  CRIANÇAS: </span>
        | <span class='h5' onclick='tituloListagem()' id='parceiros'>  PARCEIROS </span>
        | <span class='h5' onclick='tituloListagem()' id='vagasDisponiveis'>  VAGAS DISPONÍVEIS </span>  </p>"; ?>
        <div class="table-responsive">
      <table class="table table-hover table-dark">
          <thead> 
            <tr>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=nomeCliente"> NOME </a></th>
                <th>  <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=rgCliente">RG </a></th>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=cpfConsultado">CPF CONSULTADO </a></th>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=referencia">REFERÊNCIA </a></th>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=statusPagamento">STATUS </a></th>
                <th>CONTATO</th>
                <th>AÇÃO</th>
                <th>V. PAGO</th>
                <th>V. VENDIDO</th>
            </tr>
          </thead>
        
        <tbody>
          <?php
            $controleListaPasseio = 0;
            $interessados = 0;
            $quantidadeClienteParceiro =0;
            $confirmados = 0;
            $criancas = 0;
            while( $rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)){
              
              $idPagamento = $rowBuscaPasseio ['idPagamento'];
              $dataCpfConsultado = (empty($rowBuscaPasseio['dataCpfConsultado'])OR $rowBuscaPasseio['dataCpfConsultado'] == "0000-00-00")? "" : date_create($rowBuscaPasseio['dataCpfConsultado']);
              $dataCpfConsultadoFormatado = (empty($dataCpfConsultado) OR $dataCpfConsultado == "0000-00-00")? "" : date_format($dataCpfConsultado, "d/m/Y" );
              
              $idCliente = $rowBuscaPasseio['idCliente'];
              $idPasseio = $rowBuscaPasseio['idPasseio'];
              $idadeCliente = $rowBuscaPasseio['idadeCliente'];
              $clienteParceiro = $rowBuscaPasseio['clienteParceiro'];
              $statusCliente = $rowBuscaPasseio ['statusPagamento'];
              
              
              if($statusCliente == 0){
                $controleListaPasseio = 1;
                $interessados = $interessados +1;
                $statusPagamento = "INTERESSADO";
              }elseif($statusCliente == 1){
                $controleListaPasseio = 1;
                $confirmados = $confirmados +1;
                $statusPagamento = "QUITADO";
              }elseif($statusCliente == 2){
                $controleListaPasseio = 1;
                $confirmados = $confirmados +1;
                $statusPagamento = "PARCIAL";
              }elseif($statusCliente == 3){
                $controleListaPasseio = 1;
                $quantidadeClienteParceiro = $quantidadeClienteParceiro +1;
                $statusPagamento = "PARCEIRO";
              }elseif($statusCliente ==4){
                $controleListaPasseio = 1;
                $criancas = $criancas +1;
                $statusPagamento = "CRIANÇA";
              }else{
                $statusPagamento ="DESCONHECIDO";
              }
              $nomePasseio = $rowBuscaPasseio ['nomePasseio'];
            
            ?>
          <tr>
            <th><?php $nomeCliente = $rowBuscaPasseio ['nomeCliente']; echo $nomeCliente  . "<BR/>";?></th>
            <th><?php echo $rowBuscaPasseio ['rgCliente']. "<BR/>";?></th>
            <th><?php echo $dataCpfConsultadoFormatado;
            ?></th>
            <th><?php echo $rowBuscaPasseio ['referencia']. "<BR/>";?></th>

            <th><?php echo "<a class='btn btn-link' role='button' target='_blank' rel='noopener noreferrer' href='editarPagamento.php?id=". $idPagamento . "' >" .$statusPagamento."</a><BR/>"; ?></th>
            <th> <a target="blank" href="https://wa.me/55<?php echo $rowBuscaPasseio ['telefoneCliente'] ?>"> <?php echo $rowBuscaPasseio ['telefoneCliente']. "<BR/>";?> </a> </th>
            <?php
            $valorPago = (empty($rowBuscaPasseio ['valorPago']) ? $valorPago = 0.00 : $valorPago =  $rowBuscaPasseio ['valorPago'] ); 
            if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0 ){
              if( $rowBuscaPasseio['valorPago'] == 0 ){
                  $opcao = "DELETAR";
                }else{
                  $opcao = "TRANSFERIR";
                  }
                }else{
                $opcao = "";
              }
              ?>
            <th> <a target='_blank' rel='noopener noreferrer' 
            href="SCRIPTS/apagarPagamento.php?idPagamento=<?php echo $idPagamento;?>&idPasseio=<?php echo $idPasseio; ?>&opcao=<?php echo $opcao ?>&confirmar=0&nomeCliente=<?php echo $nomeCliente; ?>&dataPasseio=<?php echo $rowpegarNomePasseio['dataPasseio']?>&nomePasseio=<?php echo $nomePasseioTitulo;?>&valorPago=<?php echo number_format($valorPago, 2,'.',''); ?>"> 
            <?php echo $opcao?> </a> </th>

            <th><?php echo number_format($valorPago, 2,'.','') . "<BR/>"?></th>
            <th><?php echo $rowBuscaPasseio ['valorVendido']. "<BR/>";?></th>
          </tr>

          <?php
          

            }
           
          ?>
          <input type="hidden" name="" id="idPasseio" onclick="Export()" disabled="disabled" value="<?php echo $idPasseioGet;  ?>">
          <input type="hidden" name="" id="clientesConfirmados" onclick="tituloListagem()" disabled="disabled" value="<?php echo $confirmados;  ?>">
          <input type="hidden" name="" id="clientesCriancas" onclick="tituloListagem()" disabled="disabled" value="<?php echo $criancas;  ?>">
          <input type="hidden" name="" id="clientesInteressados" onclick="tituloListagem()" disabled="disabled" value="<?php echo$interessados;  ?>">
          <input type="hidden" name="" id="clientesParceiros" onclick="tituloListagem()" disabled="disabled" value="<?php echo$quantidadeClienteParceiro;  ?>">
          <input type="hidden" name="" id="totalVagasDisponiveis" onclick="tituloListagem()" disabled="disabled" value="<?php $vagasDisponiveis = $lotacao - $confirmados - $quantidadeClienteParceiro; echo $vagasDisponiveis;  ?>">
        </tbody>
      </table>
      </div>
      <?php
        if($controleListaPasseio > 0){
          echo"<div class='text-center'>";
          echo"</div>";
        }else{
          
          echo"<div class='text-center'>";
          echo"<p class='h5 text-center alert-warning'>Nenhum PAGAMENTO foi cadastrado até o momento</p>";
          echo"</div>";

        }


      ?>
       
  </div>
<script src="config/script.php"></script>
<script>

  function apagarPagamento(){
    var abrirJanela;
    var conf = confirm("APAGAR PAGAMENTO??");
      if(conf == true){
      }
  }

</script>
</body>

</html>