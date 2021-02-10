

<?php
    session_start();
    include_once("../PHP/functions.php");

    $idPasseio   = filter_input(INPUT_GET, 'idPasseio',   FILTER_SANITIZE_NUMBER_INT);
    $idPagamento = filter_input(INPUT_GET, 'idPagamento', FILTER_SANITIZE_NUMBER_INT);
    $opcao       = filter_input(INPUT_GET, 'opcao',       FILTER_SANITIZE_STRING);
    $confirmar   = filter_input(INPUT_GET, 'confirmar',       FILTER_SANITIZE_NUMBER_INT);
    if(empty($confirmar)){
        $confirmar = 0;
    }
    /* -----------------------------------------------------------------------------------------------------  */
    $getData = "DELETE FROM pagamento_passeio WHERE idPagamento ='$idPagamento' AND idPasseio='$idPasseio'";
    if($opcao == "DELETAR" AND $confirmar==0){
        echo"
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
            <script type='text/javascript' src='https://code.jquery.com/jquery-3.4.1.slim.min.js'></script>
<script type='text/javascript'>
function doSomething() {
    window.location.href='apagarPagamento.php?idPagamento=$idPagamento&idPasseio=$idPasseio&opcao=$opcao&confirmar=1';
    return false;
}
</script>
            
        </head>
        <body>";
            
            echo"<a href='javascript:doSomething()' onclick=''> CONFIRMAR </a>";
        echo"</body>
        </html>";
        
    }elseif($opcao == "DELETAR" AND $confirmar==1){
        apagar($getData, $conexao, "PAGAMENTO", $idPagamento, $idPasseio, "index");

    }else{
        header("refresh:0.5; url=../transferirPagamento.php?idPasseioAntigo=$idPasseio&idPagamentoAntigo=$idPagamento");
    }

?>