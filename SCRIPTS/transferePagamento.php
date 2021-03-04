<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES
    $idPasseioSelecionado   = filter_input(INPUT_POST, 'idPasseioSelecionado', FILTER_SANITIZE_NUMBER_INT);
    $idPasseioAntigo        = filter_input(INPUT_POST, 'idPasseioAntigo',      FILTER_SANITIZE_NUMBER_INT);
    $idPagamentoAntigo      = filter_input(INPUT_POST, 'idPagamentoAntigo',    FILTER_SANITIZE_NUMBER_INT);
    $idUser                 = $_SESSION['id'];

	/* -----------------------------------------------------------------------------------------------------  */
    //BUSCANDO INFORMACOES NECESSÁRIAS DO PASSEIO ANTIGO    
    $getDataPagamentoAntigo = "SELECT DISTINCT pp.idPagamento, pp.idCliente, pp.idPasseio, pp.valorPago, pp.valorVendido, pp.previsaoPagamento, pp.valorPendente, pp.statusPagamento, pp.seguroViagem, pp.clienteParceiro, 
                                pp.transporte, pp.anotacoes, pp.historicoPagamento, pp.SeguroViagem, pp.taxaPagamento, pp.localEmbarque, pp.statusPagamento, p.idPasseio, p.nomePasseio, p.dataPasseio, c.idCliente, c.dataNascimento, c.nome
                                FROM pagamento_passeio pp, passeio p, cliente c 
                                WHERE pp.idPasseio=$idPasseioAntigo AND pp.idPagamento=$idPagamentoAntigo AND pp.idPasseio=p.idPasseio AND pp.idCliente=c.idCliente";
                                $resultadoPagamentoAntigo = mysqli_query($conexao, $getDataPagamentoAntigo);
                                $rowPagamentoAntigo = mysqli_fetch_assoc($resultadoPagamentoAntigo);

    $getDataIdadeIsencaoPagamentoAntigo = "SELECT idadeIsencao FROM passeio WHERE idPasseio=$idPasseioSelecionado";
                                            $resultadIdadeIsencaoPagamentoAntigo = mysqli_query($conexao, $getDataIdadeIsencaoPagamentoAntigo);
                                            $rowIdadeIsencaoPagamentoAntigo = mysqli_fetch_assoc($resultadIdadeIsencaoPagamentoAntigo);
    $idadeIsencao                = $rowIdadeIsencaoPagamentoAntigo['idadeIsencao'];
                                               
    $valorVendido                = $rowPagamentoAntigo['valorVendido'] ;
    $valorPago                   = $rowPagamentoAntigo['valorPago'];
    $previsaoPagamento           = $rowPagamentoAntigo['previsaoPagamento'];
    $anotacoes                   = $rowPagamentoAntigo['anotacoes'];
    $valorPendente               = $rowPagamentoAntigo['valorPendente'];
    $seguroViagemCliente         = $rowPagamentoAntigo['seguroViagem'];
    $transporteCliente           = $rowPagamentoAntigo['transporte'];
    $taxaPagamento               = $rowPagamentoAntigo['taxaPagamento'];
    $localEmbarque               = $rowPagamentoAntigo['localEmbarque'];
    $clienteParceiro             = $rowPagamentoAntigo['clienteParceiro'];
    $historicoPagamento          = $rowPagamentoAntigo['historicoPagamento'];
    $idCliente                   = $rowPagamentoAntigo['idCliente'];
    $data                        = $rowPagamentoAntigo['dataNascimento'];
    $nomeCliente                 = $rowPagamentoAntigo['nomeCliente'];
    $nomePasseio                 = $rowPagamentoAntigo['nomePasseio'];
    $dataPasseio                 = $rowPagamentoAntigo['dataPasseio'];

    /* -----------------------------------------------------------------------------------------------------  */


    $recebeLotacaoPasseio    = "SELECT lotacao, idadeIsencao FROM passeio WHERE idPasseio='$idPasseioSelecionado'";
    $resultadoLotacaoPasseio = mysqli_query($conexao, $recebeLotacaoPasseio);
    $rowLotacaoPasseio       = mysqli_fetch_assoc($resultadoLotacaoPasseio);
    $lotacaoPasseio          = $rowLotacaoPasseio['lotacao']; 
    $idadeIsencao            = $rowLotacaoPasseio['idadeIsencao']; 

    $idadeCliente = calcularIdade($idCliente, $conn, "");

    $statusPagamento = statusPagamento($valorPendente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro);
    
    $recebeQtdCliente        = "SELECT COUNT(idPagamento) AS qtdClientes FROM pagamento_passeio";
    $resultadoQtdCliente     = mysqli_query($conexao, $recebeQtdCliente);
    $rowQtdCliente           = mysqli_fetch_assoc($resultadoQtdCliente);
    $qtdCliente              = $rowQtdCliente ['qtdClientes'];


    $getStatusPagamento       = "SELECT statusPagamento AS qtdConfirmados FROM pagamento_passeio WHERE idPasseio=$idPasseioSelecionado AND statusPagamento NOT IN (0,4)";
    $resultadoStatusPagamento = mysqli_query($conexao, $getStatusPagamento);
    $qtdClientesConfirmados   = mysqli_num_rows($resultadoStatusPagamento);

    /* -----------------------------------------------------------------------------------------------------  */

    
    $getDataPagamentoPasseio = "INSERT INTO pagamento_passeio 
    (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, anotacoes, valorPendente, statusPagamento, transporte, seguroViagem, taxaPagamento, localEmbarque, clienteParceiro, historicoPagamento)  
    VALUES ('$idCliente', '$idPasseioSelecionado', '$valorVendido', '$valorPago', '$previsaoPagamento', '$anotacoes', '$valorPendente', '$statusPagamento', '$transporteCliente', '$seguroViagemCliente', 
    '$taxaPagamento', '$localEmbarque', '$clienteParceiro', '$historicoPagamento')
    ";

    
    /* -----------------------------------------------------------------------------------------------------  */

    
    $alerta = $lotacaoPasseio * 0.20;
    $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados) -1;
    if($lotacaoPasseio <= $qtdClientesConfirmados){
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>LIMITE DE VAGAS PARA ESTE PASSEIO ATINGIDO</p>";
        header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
        gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "TRANSFERIR" , 0);
    }elseif($lotacaoPasseio > $qtdClientesConfirmados){
        $insertDataPagamentoPasseio = mysqli_query($conexao, $getDataPagamentoPasseio);
        
        if(mysqli_insert_id($conexao)){
            if($qtdClientesConfirmados+1 >= $lotacaoPasseio){
                $getDataApaga = "DELETE FROM pagamento_passeio WHERE idPagamento ='$idPagamentoAntigo' AND idPasseio='$idPasseioAntigo'";

                apagar($getDataApaga, $conexao, "PAGAMENTO", $idPagamentoAntigo, $idPagamentoAntigo, "index");
                echo '  <script type="text/JavaScript">  
                            alert("LIMITE DE VAGAS ATINGIDO"); 
                        </script>' 
                ; 
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso.</p>";
                header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
                gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "TRANSFERIR" , 0);

            }else{
                $getDataApaga = "DELETE FROM pagamento_passeio WHERE idPagamento ='$idPagamentoAntigo' AND idPasseio='$idPasseioAntigo'";

                apagar($getDataApaga, $conexao, "PAGAMENTO", $idPagamentoAntigo, $idPagamentoAntigo, "index");
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>PAGAMENTO realizado com sucesso</p>";
                header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
                gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "TRANSFERIR" , 0);

            }

        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>PAGAMENTO NÃO REALIZADO </p>";
            header("refresh:0.5; url=../pagamentoCliente.php?id=$idCliente");
            gerarLog("PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, "TRANSFERIR" , 0);

        }
        if($vagasRestantes > 0 and $vagasRestantes <= floor($alerta)){
            if($statusPagamento == 0 OR $statusPagamento == 4){
                $vagasRestantes = ($lotacaoPasseio - $qtdClientesConfirmados);
            }
            $_SESSION['msg'] = "<p class='h5 text-center alert-warning'>EXISTEM APENAS ". $vagasRestantes ." VAGAS DISPONÍVEIS</p>";

        }
    }












/*     $getData = "INSERT INTO pagamento_passeio 
    (idCliente, idPasseio, valorVendido, valorPago, previsaoPagamento, anotacoes, valorPendente, statusPagamento, transporte, seguroViagem, taxaPagamento, localEmbarque, clienteParceiro, historicoPagamento)  
    VALUES ('$idCliente', '$idPasseioSelecionado', '$valorVendido', '$valorPago', '$previsaoPagamento', '$anotacoes', '$valorPendente', '$statusPagamento', '$transporteCliente', '$seguroViagemCliente', 
    '$taxaPagamento', '$localEmbarque', '$clienteParceiro', '$historicoPagamento')
    ";
    cadastro($getData, $conexao, "PAGAMENTO", "index");
    $getDataApaga = "DELETE FROM pagamento_passeio WHERE idPagamento ='$idPagamentoAntigo' AND idPasseio='$idPasseioAntigo'";

    apagar($getDataApaga, $conexao, "PAGAMENTO", $idPagamentoAntigo, $idPagamentoAntigo, "index"); */
    #echo $getData;



