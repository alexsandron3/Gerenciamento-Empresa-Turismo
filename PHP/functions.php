<?php
    include_once("conexao.php");
    include_once("pdoCONEXAO.php");

    

    function cadastro($getData, $conexao, $tipoCadastro, $paginaRedirecionamento) {
        $getData = $getData;
        $insertData = mysqli_query($conexao, $getData);
        if(mysqli_insert_id($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'> $tipoCadastro CADASTRADO(A) com sucesso</p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'> $tipoCadastro NÃO foi CADASTRADO(A), alguma informação não foi inserida dentro dos padrões. </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php");
        }
    }

    function atualizar($getData, $conexao, $tipoAtualizacao, $paginaRedirecionamento, $id){
        $insertData = mysqli_query($conexao, $getData);
        
        if(mysqli_affected_rows($conexao)){
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>$tipoAtualizacao ATUALIZADO(A) com sucesso</p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }else{
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>$tipoAtualizacao não foi ATUALIZADO(A) </p>";
            header("refresh:0.5; url=../$paginaRedirecionamento.php?id=$id");
        }
    }

    function apagar($getData, $conexao, $tipoDelete, $idPagamento, $idPasseio, $paginaRedirecionamento){
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
    }

    function calcularIdade ($idCliente, $conn, $data){
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

    function statusPagamento($valorPendenteCliente, $valorPago, $idadeCliente, $idadeIsencao, $clienteParceiro){

        if($valorPendenteCliente < 0 AND $valorPago == 0 AND $clienteParceiro == 0){
            $statusPagamento = 0; //NÃO PAGO
        }elseif( $valorPendenteCliente == 0 AND $clienteParceiro == 0){
            $statusPagamento = 1; //PAGO
            if($idadeCliente <= $idadeIsencao){
                $statusPagamento = 4; // CRIANÇA
            }
        }elseif($valorPendenteCliente < 0 AND $valorPago > 0 AND $clienteParceiro == 0){
            $statusPagamento = 2; //INTERESSADO
        }elseif($clienteParceiro == 1){
            $statusPagamento = 3; // PARCEIRO
        }elseif($idadeCliente <= $idadeIsencao){
            $statusPagamento = 4; // CRIANÇA
        }
        return $statusPagamento;
    }

    function seguroViagem(){
        
    }
    
    //Code written by purpledesign.in Jan 2014
function dateDiff($date)
{
    $mydate= date("Y-m-d H:i:s", strtotime('-4 hours'));
    $theDiff="";
    //echo $mydate;//2014-06-06 21:35:55
    $datetime1 = date_create($date);
    $datetime2 = date_create($mydate);
    $interval = date_diff($datetime1, $datetime2);
    //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
    $min=$interval->format('%i');
    $sec=$interval->format('%s');
    $hour=$interval->format('%h');
    $mon=$interval->format('%m');
    $day=$interval->format('%d');
    $year=$interval->format('%y');
/*     if($interval->format('%i%h%d%m%y')=="00000") {
        //echo $interval->format('%i%h%d%m%y')."<br>";
        return $sec." Seconds";
    } else if($interval->format('%h%d%m%y')=="0000"){
        return $min." Minutes";
    } else if($interval->format('%d%m%y')=="000"){
        return $hour." Hours";
    } else if($interval->format('%m%y')=="00"){
        return $day." Days";
    } else if($interval->format('%y')=="0"){
        return $mon." Months";
    } else{
        return $year." Years";
    }     */
    return $interval;

}



?>