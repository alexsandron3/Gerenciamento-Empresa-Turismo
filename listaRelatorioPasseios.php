<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
	
    $inicioDataPasseio           = filter_input(INPUT_GET, 'inicioDataPasseio',       FILTER_SANITIZE_STRING);
    $fimDataPasseio              = filter_input(INPUT_GET, 'fimDataPasseio',          FILTER_SANITIZE_STRING);
    $mostrarPasseiosExcluidos    = filter_input(INPUT_GET, 'mostrarPasseiosExcluidos',FILTER_VALIDATE_BOOLEAN);
    $inicioDataPasseioPadrao = '2000-01-01';
    $fimDataPasseioPadrao    = '2099-01-01';

    $exibePasseio = (empty($mostrarPasseiosExcluidos) OR is_null($mostrarPasseiosExcluidos)) ? false: true;
        $queryExibePasseio = ($exibePasseio == false)? 'AND statusPasseio NOT IN (0)' : ' ';


    if(!empty($inicioDataPasseio) and !empty($fimDataPasseio)){
        $pesquisaIntervaloData ="SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM  passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'  $queryExibePasseio ORDER BY  dataPasseio";

                                    $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);



    }else{
        $pesquisaIntervaloData ="SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'  $queryExibePasseio ORDER BY  dataPasseio";
                                    $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
    }
 /* -----------------------------------------------------------------------------------------------------  */
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
<?php include_once("./includes/head.php");?>

  <title>PASSEIOS SELECIONADOS</title>
</head>

<body>
  
  <?php
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
      while($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)){
        $dataPasseio = (empty($rowPesquisaIntervaloData['dataPasseio']))? "" : date_create($rowPesquisaIntervaloData ['dataPasseio']);
        $dataPasseioFromatada = (empty($dataPasseio))? "" : date_format($dataPasseio, "d/m/Y");
        echo"
        <div class='text-center alert-info'>" .$rowPesquisaIntervaloData ['nomePasseio']. " | ". $dataPasseioFromatada. 
        "<a target='_blank' href='listaPasseio.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> LISTA DE PASSAGEIROS </a> |
        <a target='_blank' href='editaDespesas.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> DESPESAS </a> | 
        <a target='_blank' href='relatoriosDoPasseio.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> RELATÓRIOS DO PASSEIO </a> | 
        <a  target='_blank' href='relatoriosPasseio.php?id=".$rowPesquisaIntervaloData ['idPasseio'] ."'> LUCROS </a>  </div>";
/* -----------------------------------------------------------------------------------------------------  */
}
  ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>