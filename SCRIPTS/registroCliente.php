<?php
    session_start();
    include_once("../PHP/functions.php");

    $nome                   = filter_input(INPUT_POST, 'nomeCliente',           FILTER_SANITIZE_STRING);
    $email                  = filter_input(INPUT_POST, 'emailCliente',          FILTER_SANITIZE_EMAIL);
    $rg                     = filter_input(INPUT_POST, 'rgCliente',             FILTER_SANITIZE_STRING);
    $emissor                = filter_input(INPUT_POST, 'orgaoEmissor',          FILTER_SANITIZE_STRING);
    $cpf                    = filter_input(INPUT_POST, 'cpfCliente',            FILTER_SANITIZE_STRING); 
    $telefoneCliente        = filter_input(INPUT_POST, 'telefoneCliente',       FILTER_SANITIZE_STRING); 
    $dataNascimento         = filter_input(INPUT_POST, 'dataNascimento',        FILTER_SANITIZE_STRING);
    $idade                  = filter_input(INPUT_POST, 'idadeCliente',          FILTER_SANITIZE_NUMBER_INT);
    $cpfConsultado          = filter_input(INPUT_POST, 'cpfConsultado',         FILTER_VALIDATE_BOOLEAN);
    $dataConsulta           = filter_input(INPUT_POST, 'dataCpfConsultado',     FILTER_SANITIZE_STRING);
    $referenciaCliente      = filter_input(INPUT_POST, 'referenciaCliente',     FILTER_SANITIZE_STRING);
    $meioTransporte         = filter_input(INPUT_POST, 'meioTransporte',        FILTER_SANITIZE_STRING);
    $telefoneContato        = filter_input(INPUT_POST, 'telefoneContato',       FILTER_SANITIZE_STRING); 
    $nomeContato            = filter_input(INPUT_POST, 'nomeContato',           FILTER_SANITIZE_STRING);
    $redeSocial             = filter_input(INPUT_POST, 'redeSocial',            FILTER_SANITIZE_STRING);
    $statusCliente          = 1;

    /* -----------------------------------------------------------------------------------------------------  */
    
    $getData = "INSERT INTO 
                cliente (nomeCliente, emailCliente, rgCliente, orgaoEmissor, cpfCliente, telefoneCliente, dataNascimento, idadeCliente, cpfConsultado, dataCpfConsultado, referencia, telefoneContato, pessoaContato,  redeSocial, statusCliente )
                VALUES  ('$nome', '$email', '$rg', '$emissor', '$cpf', '$telefoneCliente', '$dataNascimento', '$idade', '$cpfConsultado', '$dataConsulta', '$referenciaCliente', '$telefoneContato', '$nomeContato','$redeSocial', '$statusCliente')
                ";

    /* -----------------------------------------------------------------------------------------------------  */

    $verificaSeClienteExiste = "SELECT c.cpfCliente, c.nomeCliente, c.idCliente FROM cliente c WHERE c.cpfCliente='$cpf' AND c.nomeCliente='$nome'";
    $resultadoVerificaCliente = mysqli_query($conexao, $verificaSeClienteExiste);
    $rowResultadoVerificaCliente = mysqli_fetch_assoc($resultadoVerificaCliente);

    /* -----------------------------------------------------------------------------------------------------  */
    
    if(mysqli_num_rows($resultadoVerificaCliente) == 0 || $cpf == NULL){
    /* -----------------------------------------------------------------------------------------------------  */
    
    cadastro($getData, $conexao, "USUÁRIO", "cadastroCliente");
    /* -----------------------------------------------------------------------------------------------------  */


    }else{
        $idCliente = $rowResultadoVerificaCliente ['idCliente'];
        $_SESSION['msg'] = "<p class='h5 text-center alert-warning'>JÁ EXISTE UM CLIENTE CADASTRADO COM ESTE CPF </p>";
        header("refresh:0.5; url=../editarCliente.php?id=$idCliente");
    }

    
    
 ?>   
