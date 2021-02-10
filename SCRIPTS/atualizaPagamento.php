<?php
       session_start();
       include_once("../PHP/conexao.php");
       include_once("../PHP/functions.php");

    $idPagamento                 = filter_input(INPUT_POST, 'idPagamento',            FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $idCliente                   = filter_input(INPUT_POST, 'idCliente',              FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    $historicoPagamento          = filter_input(INPUT_POST, 'historicoPagamento',     FILTER_SANITIZE_STRING);
    #$statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_SANITIZE_NUMBER_INT);
    $clienteParceiro             = filter_input(INPUT_POST, 'clienteParceiro',        FILTER_VALIDATE_BOOLEAN);
    $statusEditaSeguroViagemCliente= filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    $localEmbarque               = filter_input(INPUT_POST, 'localEmbarque',         FILTER_SANITIZE_STRING);
    #$idadeCliente                = filter_input(INPUT_POST, 'idadeCliente',           FILTER_SANITIZE_NUMBER_INT);
    #$valorSeguroViagem           = filter_input(INPUT_POST, 'novoValorSeguroViagem',  FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPagoAtual              = filter_input(INPUT_POST, 'valorPagoAtual',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $taxaPagamento               = filter_input(INPUT_POST, 'taxaPagamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $valorPendente               = -$valorVendido + ($valorPago + $taxaPagamento);
    
    $valorPendente = round($valorPendente,2);
    if($valorPendente == -0){
        $valorPendente = 0;
    }else{
        $valorPendente = $valorPendente;
    }

    /* -----------------------------------------------------------------------------------------------------  */


    #--------------------------------------------------------------------------------------------------
    $queryStatusSeguroViagem = "SELECT seguroViagem, valorSeguroViagemCliente FROM pagamento_passeio WHERE idPagamento=$idPagamento";
    $resultadoStatusSeguroViagem = mysqli_query($conexao, $queryStatusSeguroViagem);
    $rowStatusSeguroViagem = mysqli_fetch_assoc($resultadoStatusSeguroViagem);
    $statusSeguroViagem = $rowStatusSeguroViagem ['seguroViagem'];
    $idadeCliente = calcularIdade($idCliente, $conn, "");
    /* $valorSeguroViagem = $rowStatusSeguroViagem ['valorSeguroViagemCliente'];
    
    



    if($statusEditaSeguroViagemCliente == 1 AND $statusSeguroViagem == 1){
            $valorSeguroViagem;
    }elseif($statusEditaSeguroViagemCliente == 1 AND $statusSeguroViagem == 0){
        if($idadeCliente >= 0 and $idadeCliente <=85){
            $valorSeguroViagem = + 2.47;
        }else{
            $valorSeguroViagem = + 0;

        } 
    }elseif($statusEditaSeguroViagemCliente == 0 AND $statusSeguroViagem == 1){
        $valorSeguroViagem = 0;

    }else{
        $valorSeguroViagem = + 0;

    } */
    /* -----------------------------------------------------------------------------------------------------  */

    $recebeLotacaoPasseio    = "SELECT lotacao, idadeIsencao FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $idadeIsencao            = $rowLotacaoPasseio['idadeIsencao'];
    $statusPagamento = statusPagamento($valorPendente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro);

/*     var_dump($valorPendente) . PHP_EOL;
    var_dump($valorPago) . PHP_EOL;
    var_dump($idadeCliente) . PHP_EOL;
    var_dump($idadeIsencao) . PHP_EOL;
    var_dump($clienteParceiro) . PHP_EOL; */

    
    /* -----------------------------------------------------------------------------------------------------  */

    $getData =                  "UPDATE pagamento_passeio SET    
                                valorVendido='$valorVendido', valorPago='$valorPago', previsaoPagamento='$previsaoPagamento', anotacoes='$anotacoes', historicoPagamento='$historicoPagamento', statusPagamento='$statusPagamento', clienteParceiro='$clienteParceiro' ,valorPendente='$valorPendente', seguroViagem='$statusEditaSeguroViagemCliente',
                                transporte='$transporteCliente', taxaPagamento='$taxaPagamento', localEmbarque='$localEmbarque', dataPagamento=NOW()
                                WHERE idPagamento='$idPagamento'
                                ";

    /* -----------------------------------------------------------------------------------------------------  */



    $insertData = mysqli_query($conexao, $getData);
    /* -----------------------------------------------------------------------------------------------------  */

    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "<p class='h5 text-center alert-success'>pagamento ATUALIZADO com sucesso</p>";
        header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");

    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>pagamento não foi ATUALIZADO </p>";
        header("refresh:0.5; url=../editarPagamento.php?id=$idPagamento");
    }

?>