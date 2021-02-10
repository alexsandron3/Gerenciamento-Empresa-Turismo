<?php
  session_start();
  include_once("PHP/conexao.php");
  $idPasseioGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $nomePasseioGet = filter_input(INPUT_GET, 'nomePasseio', FILTER_SANITIZE_STRING);
  $queryBuscaPeloIdPasseio = "SELECT DISTINCT c.nomeCliente, c.rgCliente, c.dataNascimento, c.idadeCliente,  pp.statusPagamento FROM passeio p, pagamento_passeio pp, cliente c WHERE pp.idPasseio='$idPasseioGet' AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
  $resultadoBuscaPasseio = mysqli_query($conexao, $queryBuscaPeloIdPasseio);
 
  
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
      <div class="text-center">
            <!-- <a href="#" class="btn btn-primary">Imprimir</a> -->
      </div> 
  </div>
<script src="config/script.php"></script>
