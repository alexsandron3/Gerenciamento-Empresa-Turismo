<?php
    include_once("conexao.php");
    include_once("pdoCONEXAO.php");

    function verificaNivelAcesso() {

    }

    function gerarLog($tipo, $conexao, $idUser,  $nomeCliente, $nomePasseio, $dataPasseio, $valorPago, $tipoModificacao, $sinalDeFalhaNaOperacao ){
        $status = (mysqli_affected_rows($conexao) AND $sinalDeFalhaNaOperacao == 0)? "SUCESSO" : "FALHA";
        switch ($tipo){
            case "CLIENTE":
                $getDataLog = "INSERT INTO log (idUser, nomeCliente , tipoModificacao) VALUES ($idUser, '$nomeCliente', ' $status AO $tipoModificacao O USUARIO')";
                $insertData = mysqli_query($conexao, $getDataLog);
                return $getDataLog;
                break;
            case "PAGAMENTO";
                $getDataLog = "INSERT INTO log (idUser, nomeCliente, nomePasseio, dataPasseio, valorPago, tipoModificacao ) VALUES ($idUser, '$nomeCliente', '$nomePasseio','$dataPasseio',  $valorPago,  '$status AO $tipoModificacao O PAGAMENTO')";
                $insertData = mysqli_query($conexao, $getDataLog);
                return $getDataLog;
                break;                
            case "DESPESAS";
                $getDataLog = "INSERT INTO log (idUser, nomePasseio, dataPasseio, tipoModificacao ) VALUES ($idUser, '$nomePasseio', '$dataPasseio',  '$status AO $tipoModificacao A DESPESA')";
                $insertData = mysqli_query($conexao, $getDataLog);
                return $getDataLog;
                break;
            case "PASSEIO";
                $getDataLog = "INSERT INTO log (idUser, nomePasseio, dataPasseio, tipoModificacao ) VALUES ($idUser, '$nomePasseio', '$dataPasseio',  '$status AO $tipoModificacao O PASSEIO')";
                $insertData = mysqli_query($conexao, $getDataLog);
                return $getDataLog;
                break;
            case "DELETAR PAGAMENTO";
                $getDataLog = "INSERT INTO log (idUser, nomeCliente, nomePasseio, dataPasseio, valorPago, tipoModificacao ) VALUES ($idUser, '$nomeCliente', '$nomePasseio','$dataPasseio',  $valorPago, '$status AO DELETAR O PAGAMENTO')";
                $insertData = mysqli_query($conexao, $getDataLog);
                return $getDataLog;
                break;                
            case "DELETAR PASSEIO";
                $getDataLog = "INSERT INTO log (idUser, nomePasseio, dataPasseio, tipoModificacao) VALUES ($idUser, '$nomePasseio', '$dataPasseio' ,'$status AO DELETAR O PASSEIO')";
                $insertData = mysqli_query($conexao, $getDataLog);
                return $getDataLog;
                break;
            
                
            
        }
    }

    function cadastro($getData, $conexao, $tipoCadastro, $paginaRedirecionamento) {
        $getData = $getData;
        $insertData = mysqli_query($conexao, $getData);
        if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0){
            if(mysqli_insert_id($conexao)){
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'> $tipoCadastro CADASTRADO(A) com sucesso</p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php");
            }else{
                $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> $tipoCadastro NÃO foi CADASTRADO(A), alguma informação não foi inserida dentro dos padrões. </p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php");
            }
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> $tipoCadastro NÃO foi CADASTRADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php");
        }

    }

    function atualizar($getData, $conexao, $tipoAtualizacao, $paginaRedirecionamento, $id){
        $insertData = mysqli_query($conexao, $getData);
        if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0 ){
            if(mysqli_affected_rows($conexao)){
                $_SESSION['msg'] = "<p class='h5 text-center alert-success'>$tipoAtualizacao ATUALIZADO(A) com sucesso</p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
            }else{
                $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>$tipoAtualizacao não foi ATUALIZADO(A) </p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
            }
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> $tipoAtualizacao NÃO foi ATUALIZADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }
    }

    function apagar($getData, $conexao, $tipoDelete, $idPagamento, $idPasseio, $paginaRedirecionamento){
        if($_SESSION['nivelAcesso'] == 1 OR $_SESSION['nivelAcesso'] == 0){
            if(!empty($idPagamento OR $idPasseio)){
                $deleteData = mysqli_query ($conexao, $getData );
                if( mysqli_affected_rows($conexao)){
                    $_SESSION['msg'] = "<p class='h5 text-center alert-success'>$tipoDelete APAGADO(A) com sucesso</p>";
                    header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");
                }else {
                    $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>$tipoDelete NÃO foi APAGADO(A) </p>";
                    header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");

                }
            }else {
                $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um $tipoDelete</p>";
                header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");

            }
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> $tipoDelete NÃO foi APAGADO(A), VOCÊ NÃO PODE REALIZAR ALTERAÇÕES DEVIDO A FALTA DE PERMISSÃO. </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$idPasseio");

        }
    }

    function apagarRegistros ($conexao, $tabela, $condicao ){
        $getData = "DELETE FROM $tabela WHERE $condicao";
        $deletar = mysqli_query($conexao, $getData);
    }
    function calcularIdade ($idCliente, $conn, $data = ""){
        $queryBuscaDataNascimento = "SELECT dataNascimento FROM cliente WHERE idCliente =$idCliente";
        $resultadoBuscaDataNascimento = $conn->query($queryBuscaDataNascimento);
        $rowBuscaDataNascimento = $resultadoBuscaDataNascimento ->fetch_assoc();
        
        if(empty($data)){
            $dataNascimento = new DateTime ($rowBuscaDataNascimento['dataNascimento']);
        }else{
            $dataNascimento = new DateTime($data);
        }
        $hoje           = new DateTime();
        $diferenca      = $hoje->diff($dataNascimento);
        $idade          = $diferenca->y;

        return $idade;

    }

    function calculaIntervaloTempo ($conn, $coluna, $tabela, $condicao, $data = ""){
        
        
        if(empty($data)){
            $queryBuscaData = "SELECT $tabela FROM $coluna WHERE $condicao";
            $resultadoBuscaData = $conn->query($queryBuscaData);
            $rowBuscaData = $resultadoBuscaData ->fetch_assoc();
            $data = new DateTime($rowBuscaData['dataLog']);
            $dataHoje = new DateTime();

        }else{
            $data = new DateTime($data);

            $dataHoje = new DateTime();
        }

        $diferenca = $dataHoje->diff($data);
        $dias = $diferenca->d;
        return $diferenca;
    }

    function statusPagamento($valorPendenteCliente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro){

        if($valorPendenteCliente < 0 AND $valorPago == 0 AND $clienteParceiro == 0){
            $statusPagamento = 0; //NÃO PAGO/INTERESSADOS
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif( $valorPendenteCliente == 0 AND $clienteParceiro == 0){
            $statusPagamento = 1; //PAGO
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif($valorPendenteCliente < 0 AND $valorPago > 0 AND $clienteParceiro == 0){
            $statusPagamento = 2; //CONFIRMADO
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif($clienteParceiro == 1){
            $statusPagamento = 3; // PARCEIRO
            
        }elseif($idadeCliente <= $idadeIsencao){
            $statusPagamento = 4; // CRIANÇA
        }
        return $statusPagamento;
    }

    function exportarExcel(){
        
        
    }




?>