<?php
  session_start();
  include_once("PHP/conexao.php");
/* -----------------------------------------------------------------------------------------------------  */
  $idPasseioGet   = filter_input(INPUT_GET, 'id',            FILTER_SANITIZE_NUMBER_INT);
  $ordemPesquisa  = filter_input(INPUT_GET, 'ordemPesquisa', FILTER_SANITIZE_STRING);
  if(empty($ordemPesquisa)){
    $ordemPesquisa = 'nomeCliente';
  }
/* -----------------------------------------------------------------------------------------------------  */

  $queryBuscaPeloIdPasseio = "SELECT  p.nomePasseio, p.idPasseio, p.lotacao, c.nomeCliente, c.rgCliente, c.dataCpfConsultado, c.telefoneCliente, c.orgaoEmissor, c.idadeCliente, c.dataCpfConsultado, 
                              pp.statusPagamento, pp.idPagamento, pp.idCliente, pp.valorPago, pp.valorVendido, pp.clienteParceiro 
                              FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente ORDER BY $ordemPesquisa ";
                          $resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
                          //echo $queryBuscaPeloIdPasseio;
/* -----------------------------------------------------------------------------------------------------  */
 
  $pegarNomePasseio = "SELECT nomePasseio, lotacao FROM passeio WHERE idPasseio='$idPasseioGet'";
                        $resultadopegarNomePasseio = mysqli_query($conexao, $pegarNomePasseio);
                        $rowpegarNomePasseio = mysqli_fetch_assoc($resultadopegarNomePasseio);
                        $nomePasseioTitulo = $rowpegarNomePasseio ['nomePasseio'];
                        $lotacao = $rowpegarNomePasseio ['lotacao'];
/* -----------------------------------------------------------------------------------------------------  */
?>



<!DOCTYPE html>
<html lang="PT-BR">

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="PÁGINA DE CONTROLE DE CLIENTES DO ATENDIMENTO">
  <link rel="stylesheet" href="config/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
    integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
  
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
            <!-- <a class="dropdown-item" href="cadastroDespesas.php">DESPESAS</a> -->
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
  <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
    ?>
  <div class="table mt-3">
        <?php  echo"<p class='h5 text-center alert-info '>" .$nomePasseioTitulo. " 
        | <span class='h5'> LOTAÇÃO: $lotacao </span> 
        | <span class='h5' onclick='tituloListagem()' id='confirmados' >  CONFIRMADOS: </span> 
        | <span class='h5' onclick='tituloListagem()' id='interessados'>  INTERESSADOS: </span>
        | <span class='h5' onclick='tituloListagem()' id='criancas'>  CRIANÇAS: </span>
        | <span class='h5' onclick='tituloListagem()' id='parceiros'>  PARCEIROS </span>
        | <span class='h5' onclick='tituloListagem()' id='vagasDisponiveis'>  VAGAS DISPONÍVEIS </span>  </p>"; ?>
      <table class="table table-hover table-dark">
          <thead> 
            <tr>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=nomeCliente"> NOME </a></th>
                <th>  <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=rgCliente">RG </a></th>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=cpfConsultado">CPF CONSULTADO </a></th>
                <th> <a href="listaPasseio.php?id=<?php echo$idPasseioGet;?>&ordemPesquisa=statusPagamento">STATUS </a></th>
                <th>CONTATO</th>
                <th>AÇÃO</th>
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
              if(empty($rowBuscaPasseio['dataCpfConsultado'])){
                $dataCpfConsultado = "0000-00-00";
              }else{
                $dataCpfConsultado =  date_create($rowBuscaPasseio['dataCpfConsultado']);
              }
              
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
            <th><?php echo $rowBuscaPasseio ['nomeCliente']. "<BR/>";?></th>
            <th><?php echo $rowBuscaPasseio ['rgCliente']. "<BR/>";?></th>
            <th><?php if($dataCpfConsultado == "0000-00-00"){
                        echo"";
                      }else{
                        echo date_format($dataCpfConsultado, "d/m/Y"). "<BR/>";
                      } 
            ?></th>
            <th><?php echo "<a class='btn btn-link' role='button' target='_blank' rel='noopener noreferrer' href='editarPagamento.php?id=". $idPagamento . "' >" .$statusPagamento."</a><BR/>"; ?></th>
            <th> <a href="https://wa.me/55<?php echo $rowBuscaPasseio ['telefoneCliente'] ?>"> <?php echo $rowBuscaPasseio ['telefoneCliente']. "<BR/>";?> </a> </th>
            <?php
             if( $rowBuscaPasseio['valorPago'] == 0 ){
                $opcao = "DELETAR";
               }else{
                $opcao = "TRANSFERIR";
                 }
              ?>
            <th> <a target='_blank' rel='noopener noreferrer' href="SCRIPTS/apagarPagamento.php?idPagamento=<?php echo $idPagamento;?>&idPasseio= <?php echo $idPasseio; ?>&opcao=<?php echo $opcao ?>&confirmar=0"> <?php echo $opcao?> </a> </th>

            <th></th>
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
      <?php
      //echo $idPasseioGet;
        if($controleListaPasseio > 0){
          echo"<div class='text-center'>";
            #echo"<a target='_blank' rel='noopener noreferrer' href='imprimirListaPasseio.php?id=".$idPasseioGet."& nomePasseio=".$nomePasseio."'class='btn btn-primary'>Imprimir Lista de Passeio</a>";
            #echo"<button onclick='Export()' class='btn btn-primary ml-2'>SEGURO VIAGEM</button>";
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