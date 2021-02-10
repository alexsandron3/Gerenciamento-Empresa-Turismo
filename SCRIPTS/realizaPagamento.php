<?php
    session_start();
    include_once("../PHP/conexao.php");
    include_once("../PHP/functions.php");

    $idCliente                   = filter_input(INPUT_POST, 'idClienteSelecionado',   FILTER_SANITIZE_NUMBER_INT);
    $idPasseio                   = filter_input(INPUT_POST, 'idPasseioSelecionado',   FILTER_SANITIZE_NUMBER_INT); 
    $valorVendido                = filter_input(INPUT_POST, 'valorVendido',           FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $valorPago                   = filter_input(INPUT_POST, 'valorPago',              FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $previsaoPagamento           = filter_input(INPUT_POST, 'previsaoPagamento',      FILTER_SANITIZE_STRING);
    $anotacoes                   = filter_input(INPUT_POST, 'anotacoes',              FILTER_SANITIZE_STRING);
    #$statusPagamento             = filter_input(INPUT_POST, 'statusPagamento',        FILTER_SANITIZE_NUMBER_INT);
    $seguroViagemCliente         = filter_input(INPUT_POST, 'seguroViagemCliente',    FILTER_VALIDATE_BOOLEAN);
    $transporteCliente           = filter_input(INPUT_POST, 'meioTransporte',         FILTER_SANITIZE_STRING);
    #$idadeCliente                = filter_input(INPUT_POST, 'idadeCliente',           FILTER_SANITIZE_NUMBER_INT);
    $taxaPagamento               = filter_input(INPUT_POST, 'taxaPagamento',          FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $localEmbarque               = filter_input(INPUT_POST, 'localEmbarque',          FILTER_SANITIZE_STRING);
    $clienteParceiro             = filter_input(INPUT_POST, 'clienteParceiro',    FILTER_VALIDATE_BOOLEAN);
    $historicoPagamento          = filter_input(INPUT_POST, 'historicoPagamento',     FILTER_SANITIZE_STRING);




    $valorPendente               = -$valorVendido + ($valorPago + $taxaPagamento);

    /* -----------------------------------------------------------------------------------------------------  */

    $recebeLotacaoPasseio    = "SELECT lotacao, idadeIsencao FROM passeio WHERE idPasseio='$idPasseio'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $idadeIsencao            = $rowLotacaoPasseio['idadeIsencao']; 

    $idadeCliente = calcularIdade($idCliente, $conn, "");

    $statusPagamento = statusPagamento($valorPendente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro);
    
/*     $recebeQtdCliente        = "SELECT COUNT(idPagamento) AS qtdClientes FROM pagamento_passeio";
    $resultadoQtdCliente     = mysqli_query($conexao, $recebeQtdCliente);
    $rowQtdCliente           = mysqli_fetch_assoc($resultadoQtdCliente);
    $qtdCliente              = $rowQtdCliente ['qtdClientes']; */


    $getStatusPagamento       = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=$idPasseio AND statusPagamento NOT IN (0,4)";
    $resultadoStatusPagamento = mysqli_query($conexao, $getStatusPagamento);
    $qtdClientesConfirmados   = mysqli_num_rows($resultadoStatusPagamento);
    
    /* -----------------------------------------------------------------------------------------------------  */

    

    $getDataPagamentoPasseio = "INSERT INTO pagamento_passeio 
                                (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, anotacoes, valorPendente, statusPagamento, transporte, seguroViagem, taxaPagamento, localEmbarque, clienteParceiro, historicoPagamento, dataPagamento)  
                                VALUES ('$idCliente', '$idPasseio', '$valorVendido', '$valorPago', '$previsaoPagamento', '$anotacoes', '$valorPendente', '$statusPagamento', '$transporteCliente', '$seguroViagemCliente', 
                                '$taxaPagamento', '$localEmbarque', '$clienteParceiro', '$historicoPagamento', NOW())
                                ";
 

    /* -----------------------------------------------------------------------------------------------------  */

    $alerta = $lotacaoPasseio * 0.80;
    $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados) -1;
    if($lotacaoPasseio <= $qtdClientesConfirmados){
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>LIMITE DE VAGAS PARA ESTE PASSEIO ATINGIDO</p>";
        header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
    }elseif($lotacaoPasseio > $qtdClientesConfirmados){
        $insertDataPagamentoPasseio = mysqli_query($conexao, $getDataPagamentoPasseio);

        if(mysqli_insert_id($conexao)){
            if($qtdClientesConfirmados+1 >= $lotacaoPasseio){
                echo '  <script type="text/JavaScript">  
                            alert("LIMITE DE VAGAS ATINGIDO"); 
                        </script>' 
                ; 
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso.</p>";
                header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
            }else{
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso</p>";
                header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
            }

        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>PAGAMENTO NÃO REALIZADO </p>";
            header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
        }
        if($vagasRestantes > 0 and $vagasRestantes <= floor($alerta)){
            if($statusPagamento == 0 OR $statusPagamento == 4){
                $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados);
            }
            $_SESSION['msg'] = "<p class='h5 text-center alert-warning'>EXISTEM APENAS ". $vagasRestantes ." VAGAS DISPONÍVEIS</p>";

        }
    }




?>