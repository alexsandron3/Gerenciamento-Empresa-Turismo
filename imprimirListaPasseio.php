<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
  $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $nomePasseioGet = filter_input(INPUT_GET, 'nomePasseio', FILTER_SANITIZE_STRING);
  $queryBuscaPeloIdPasseio = "SELECT DISTINCT c.nomeCliente, c.rgCliente, c.dataNascimento, c.idadeCliente,  pp.statusPagamento FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
  $resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
 
  
?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title><?php  echo $nomePasseioGet ?></title>
</head>

<div class="table">
      <table class="table table-hover table-dark"  onclick="window.print();">
          <thead> 
            <tr>
                <th>NOME</th>
                <th>DATA NASCIMENTO</th>
                <th>RG</th>
            </tr>
          </thead>
        
        <tbody>
          <?php
            while( $rowBuscaPasseio = mysqli_fetch_assoc($resultadoBuscaPasseio)){
              $dataNascimento =  date_create($rowBuscaPasseio['dataNascimento']);
              if ($rowBuscaPasseio ['statusPagamento'] == 0){
                $statusPagamento = "NÃO QUITADO";
              }else{
                $statusPagamento = "QUITADO";
              }

            
            ?>
          <tr>
            <th><?php echo $rowBuscaPasseio ['nomeCliente']. "<BR/>";?></th>
            <th><?php echo date_format($dataNascimento, "d/m/Y"). "<BR/>";?></th>
            <th><?php echo $rowBuscaPasseio ['rgCliente']. "<BR/>";?></th>
          </tr>

          <?php
            }
          ?>
        </tbody>
      </table>
  </div>
<script src="config/script.php"></script>
