<?PHP
  include_once("PHP/conexao.php");
  include_once("PHP/functions.php");
  echo"<pre>";
  echo"<p class='h4 text-center alert-info'> SELECIONE O INTERVALO</p>";
  echo"<form action='' method='GET' autocomplete='OFF'>";
    echo"<div class='form-group row mb-5'>";
      echo"<label class='col-sm-2 col-form-label' for='inicioDataPasseio'></label>";
      echo"<input type='date' class='form-control col-sm-2' name='inicioDataPasseio' id='inicioDataPasseio'>";

      echo"<label class='col-sm-2 col-form-label  pl-5' for='fimDataPasseio'>PERÍODO</label>";
      echo"<input type='date' class='form-control col-sm-2' name='fimDataPasseio' id='fimDataPasseio' >";
      echo"<input type='submit' class='btn btn-primary btn-sm ml-5' value='CARREGAR INFORMAÇÕES' name='buttonEviaDataPasseio'>";
    echo"</div>";
  echo"</form>";
  $listaPasseios = "SELECT idPasseio FROM passeio WHERE dataPasseio BETWEEN '2020-01-01' AND '2050-01-01'";
  $resultadoListaPasseio = mysqli_query($conexao, $listaPasseios);

  while($rowResultadoListaPasseio = mysqli_fetch_assoc($resultadoListaPasseio)){

    $idPasseio = $rowResultadoListaPasseio['idPasseio'];
    $pagamentosUltimoDia = "SELECT dataPagamento, statusPagamento FROM pagamento_passeio WHERE dataPagamento >= NOW() - INTERVAL 1 DAY AND idPasseio = $idPasseio ";
    $resultadoPagamentosUltimoDia = mysqli_query($conexao, $pagamentosUltimoDia);
    $qtdPagamento = mysqli_num_rows($resultadoPagamentosUltimoDia);
    $interessadosUltimoDia =0;
    $quitadosUltimoDia =0;
    $parciaisUltimoDia =0;
    $parceirosUltimoDia =0;
    $criancasUltimoDia =0;
    $confirmadosUltimoDia =0;
    while($rowPagamentosUltimoDia = mysqli_fetch_assoc($resultadoPagamentosUltimoDia)){
      
      if($rowPagamentosUltimoDia ['statusPagamento'] == 0){
        $interessadosUltimoDia +=1;
      }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 1){
        $quitadosUltimoDia +=1;
        $confirmadosUltimoDia +=1;
      }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 2){
        $parciaisUltimoDia +=1;
        $confirmadosUltimoDia +=1;
      }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 3){
        $parceirosUltimoDia +=1;
      }elseif($rowPagamentosUltimoDia ['statusPagamento'] == 4){
        $criancasUltimoDia +=1;
      }
    }
    


    $idPasseio = $rowResultadoListaPasseio['idPasseio'];
    $pagamentosUltimaHora = "SELECT dataPagamento, statusPagamento FROM pagamento_passeio WHERE dataPagamento >= NOW() - INTERVAL 1 HOUR AND idPasseio = $idPasseio";
    echo $pagamentosUltimaHora;
    $resultadoPagamentosUltimaHora = mysqli_query($conexao, $pagamentosUltimaHora);
    $qtdPagamentoHora = mysqli_num_rows($resultadoPagamentosUltimaHora);
    $interessadosUltimaHora =0;
    $quitadosUltimaHora =0;
    $parciaisUltimaHora =0;
    $parceirosUltimaHora =0;
    $criancasUltimaHora =0;
    $confirmadosUltimaHora =0;
    while($rowPagamentosUltimaHora = mysqli_fetch_assoc($resultadoPagamentosUltimaHora)){
      
      if($rowPagamentosUltimaHora ['statusPagamento'] == 0){
        $interessadosUltimaHora +=1;
      }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 1){
        $quitadosUltimaHora +=1;
        $confirmadosUltimaHora +=1;
      }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 2){
        $parciaisUltimaHora +=1;
        $confirmadosUltimaHora +=1;
      }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 3){
        $parceirosUltimaHora +=1;
      }elseif($rowPagamentosUltimaHora ['statusPagamento'] == 4){
        $criancasUltimaHora +=1;
      }
    }
    

    $recebeLotacaoPasseio    = "SELECT lotacao, nomePasseio, dataPasseio FROM passeio WHERE idPasseio='$idPasseio'";

    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $nomePasseio          = $rowLotacaoPasseio['nomePasseio']; 
    $dataPasseio          = date_create($rowLotacaoPasseio['dataPasseio']); 

    $getStatusPagamento       = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=$idPasseio AND statusPagamento NOT IN (0,4)";
    $resultadoStatusPagamento = mysqli_query($conexao, $getStatusPagamento);
    $qtdClientesConfirmados   = mysqli_num_rows($resultadoStatusPagamento);

    $getStatusPagamentoCliente       = "SELECT statusPagamento FROM pagamento_passeio WHERE idPasseio=$idPasseio";
    $resultadoStatusPagamentoCliente = mysqli_query($conexao, $getStatusPagamentoCliente);
    $interessado = 0;
    $quitado = 0;
    $parcial = 0;
    $parceiro = 0;
    $crianca = 0;
    $confirmados = 0;
    while($rowGetStatusPagamentoCliente = mysqli_fetch_assoc($resultadoStatusPagamentoCliente)){
      $statusCliente = $rowGetStatusPagamentoCliente['statusPagamento'];
      if($statusCliente == 0){
        $interessado +=1;
      }elseif($statusCliente == 1){
        $quitado +=1;
        $confirmados +=1;
      }elseif($statusCliente == 2){
        $parcial +=1;
        $confirmados +=1;
      }elseif($statusCliente == 3){
        $parceiro +=1;
      }elseif($statusCliente == 4){
        $crianca +=1;
      }

    }




    $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados);

  /*   echo $vagasRestantes. "\n";
    echo $lotacaoPasseio. "\n"; */
    if($qtdPagamento >=1){
      echo $qtdPagamento . " PAGAMENTOS NOVOS NAS ÚLTIMAS 24 HORAS". "\n";
    }else{
      echo "SEM PAGAMENTOS NOVOS NAS ÚLTIMAS 24 HORAS". "\n";
    }
    if($qtdPagamentoHora >=1){
      echo $qtdPagamentoHora . " PAGAMENTOS NOVOS NA ÚLTIMA HORA". "\n";
    }else{
      echo "SEM PAGAMENTOS NOVOS NA ÚLTIMA HORA". "\n";
    }
    echo "PASSEIO: ".$nomePasseio. "\n";
    echo "DATA: ".date_format($dataPasseio, "d/m/Y H:i"). "\n";
    echo "INTERESSADO: ".$interessado." | ". $interessadosUltimaHora." ÚLTIMA HORA" . "\n";
    #echo "QUITADO: ".$quitado. "\n";
    echo "RESERVADOS: ".$confirmados." | ". $confirmadosUltimaHora." ÚLTIMA HORA" . "\n";
    echo "PARCEIRO: ".$parceiro." | ". $parceirosUltimaHora." ÚLTIMA HORA" . "\n";
    echo "CRIANÇAS: ".$crianca." | ". $criancasUltimaHora." ÚLTIMA HORA" . "\n";
    echo "META DE VENDA: ".$lotacaoPasseio. "\n";
    echo "VAGAS DISPONÍVEIS: : ".$vagasRestantes."\n";
    echo "----------------------------------------------------------------------- \n";
  }


?>