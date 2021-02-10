<?php
    include_once("PHP/conexao.php");
    session_start();
    $inicioDataPasseio           = filter_input(INPUT_GET, 'inicioDataPasseio',       FILTER_SANITIZE_STRING);
    $fimDataPasseio              = filter_input(INPUT_GET, 'fimDataPasseio',          FILTER_SANITIZE_STRING);
    $inicioDataPasseioPadrao = '2000-01-01';
    $fimDataPasseioPadrao    = '2099-01-01';


    if(!empty($inicioDataPasseio) and !empty($fimDataPasseio)){
        $pesquisaIntervaloData ="SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM  passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseio' AND '$fimDataPasseio'";
                                    $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);



    }else{
        $pesquisaIntervaloData ="SELECT  p.idPasseio, p.nomePasseio, p.dataPasseio
                                    FROM passeio p  WHERE dataPasseio BETWEEN '$inicioDataPasseioPadrao' AND '$fimDataPasseioPadrao'";
                                    $resultadPesquisaIntervaloData = mysqli_query($conexao, $pesquisaIntervaloData);
    }
 /* -----------------------------------------------------------------------------------------------------  */



  


                        
  

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <title>PASSEIOS SELECIONADOS</title>
</head>

<body>
  
  <?php
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
      while($rowPesquisaIntervaloData      = mysqli_fetch_assoc($resultadPesquisaIntervaloData)){
        echo"
        <div class='text-center alert-info'>" .$rowPesquisaIntervaloData ['nomePasseio']. 
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