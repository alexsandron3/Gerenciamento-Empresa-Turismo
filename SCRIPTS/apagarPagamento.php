

<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES
    $idPasseio                     = filter_input(INPUT_GET, 'idPasseio',   FILTER_SANITIZE_NUMBER_INT);
    $idPagamento                   = filter_input(INPUT_GET, 'idPagamento', FILTER_SANITIZE_NUMBER_INT);
    $deletarOuTransferirPagamento  = filter_input(INPUT_GET, 'opcao',       FILTER_SANITIZE_STRING);
    $nomeCliente                   = filter_input(INPUT_GET, 'nomeCliente', FILTER_SANITIZE_STRING);
    $nomePasseio                   = filter_input(INPUT_GET, 'nomePasseio', FILTER_SANITIZE_STRING);
    $dataPasseio                   = filter_input(INPUT_GET, 'dataPasseio', FILTER_SANITIZE_STRING);
    $valorPago                     = filter_input(INPUT_GET, 'valorPago', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $confirmaApagarPagamento       = filter_input(INPUT_GET, 'confirmar',   FILTER_SANITIZE_NUMBER_INT);
    $idUser                        = $_SESSION['id'];
    if(empty($confirmaApagarPagamento)){
        $confirmaApagarPagamento = 0;
    }
    /* -----------------------------------------------------------------------------------------------------  */
    $queryDeletaPagamento = "DELETE FROM pagamento_passeio WHERE idPagamento='$idPagamento' AND idPasseio='$idPasseio'";
    echo "APAGAR PAGAMENTO FEITO POR: $nomeCliente | NO PASSEIO:  $nomePasseio | NA DATA: $dataPasseio | COM VALOR PAGO DE: $valorPago ?"; 

    //VERIFICANDO NIVEL DE ACESSO E SE A CONFIRMACAO DE DELECAO FOI FEITA
    if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0 ){
        if($deletarOuTransferirPagamento == "DELETAR" AND $confirmaApagarPagamento==0){
            echo"
            <!DOCTYPE html>
            <html lang='pt-br'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>DELETAR PAGAMENTO?</title>
                    <script type='text/javascript' src='https://code.jquery.com/jquery-3.4.1.slim.min.js'></script>
                    <script type='text/javascript'>
                    function confirmaDeletarPagamento() {
                        window.location.href='apagarPagamento.php?idPagamento=$idPagamento&idPasseio=$idPasseio&opcao=$deletarOuTransferirPagamento&confirmar=1&nomeCliente=$nomeCliente&nomePasseio=$nomePasseio&dataPasseio=$dataPasseio&valorPago=$valorPago';
                        return false;
                    }
                    </script>
                    
                </head>
                <body>";
                    
                echo
                    "<a href='javascript:confirmaDeletarPagamento()' onclick=''> CONFIRMAR </a>";
                echo
                "</body>
            </html>";
            
        }elseif($deletarOuTransferirPagamento == "DELETAR" AND $confirmaApagarPagamento==1){
            apagar($queryDeletaPagamento, $conexao, "PAGAMENTO", $idPagamento, $idPasseio, "index");
            gerarLog("DELETAR PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, null , 0);


        }else{
            header("refresh:0.5; url=../transferirPagamento.php?idPasseioAntigo=$idPasseio&idPagamentoAntigo=$idPagamento");
        }
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> PAGAMENTO NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
        header("refresh:0.5; url=../listaPasseio.php?id=$idPasseio");
        gerarLog("DELETAR PAGAMENTO", $conexao, $idUser, $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, null , 0);

    }

?>