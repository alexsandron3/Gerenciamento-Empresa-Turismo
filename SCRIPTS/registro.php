<?php
    session_start();
    include_once("../PHP/conexao.php");

   
        /* $nomeCliente            = filter_input(INPUT_POST, 'nomeCliente',           FILTER_SANITIZE_STRING);
    $emailCliente           = filter_input(INPUT_POST, 'emailCliente',          FILTER_SANITIZE_EMAIL);
    $rgCliente              = filter_input(INPUT_POST, 'rgCliente',             FILTER_SANITIZE_STRING);
    $orgaoEmissor           = filter_input(INPUT_POST, 'orgaoEmissor',          FILTER_SANITIZE_STRING);
    $cpfCliente             = filter_input(INPUT_POST, 'cpfCliente',            FILTER_SANITIZE_STRING);
    $telefoneCliente        = filter_input(INPUT_POST, 'telefoneCliente',       FILTER_SANITIZE_STRING);
    $dataNascimento         = $_POST["dataNascimento"];
    $idadeCliente           = filter_input(INPUT_POST, 'idadeCliente',          FILTER_SANITIZE_NUMBER_INT);
    $cpfConsultado          = filter_input(INPUT_POST, 'cpfConsultado',         FILTER_VALIDATE_BOOLEAN);
    $dataConsulta           = $_POST["dataConsulta"];
    $referenciaCliente      = filter_input(INPUT_POST, 'referenciaCliente',     FILTER_SANITIZE_STRING);
    $meioTransporte         = filter_input(INPUT_POST, 'meioTransporte',        FILTER_SANITIZE_STRING);
    $nomeContato            = filter_input(INPUT_POST, 'nomeContato',           FILTER_SANITIZE_STRING);
    $telefoneContato        = filter_input(INPUT_POST, 'telefoneContato',       FILTER_SANITIZE_STRING);
    $seguroViagemCliente    = filter_input(INPUT_POST, 'seguroViagemCliente',   FILTER_VALIDATE_BOOLEAN);
    
    $get_data = "INSERT INTO 
    CLIenTE (nomeCliente, emailCliente, rgCliente, orgaoEmissor, cpfCliente, telefoneCliente, dataNascimento, idadeCliente, cpfConsultado, dataConsulta, referenciaCliente, meioTransporte, nomeContato, telefoneContato, seguroViagemCliente)
    VALUES  (:nomeCliente, :emailCliente, :rgCliente, :orgaoEmissor, :cpfCliente, :telefoneCliente, :dataNascimento, :idadeCliente, :cpfConsultado, :dataConsulta, :referenciaCliente, :meioTransporte, :nomeContato, :telefoneContato, :seguroViagemCliente)
    ";
    $insert_data = $conexao->prepare($get_data);
    $insert_data->bindParam(':nomeCliente',         $nomeCliente); 
    $insert_data->bindParam(':emailCliente',        $emailCliente);
    $insert_data->bindParam(':rgCliente',           $rgCliente);
    $insert_data->bindParam(':orgaoEmissor',        $orgaoEmissor);
    $insert_data->bindParam(':cpfCliente',          $cpfCliente);
    $insert_data->bindParam(':telefoneCliente',     $telefoneCliente); 
    $insert_data->bindParam(':dataNascimento',      $dataNascimento);
    $insert_data->bindParam(':idadeCliente',        $idadeCliente);
    $insert_data->bindParam(':cpfConsultado',       $cpfConsultado);
    $insert_data->bindParam(':dataConsulta',        $dataConsulta);
    $insert_data->bindParam(':referenciaCliente',   $referenciaCliente); 
    $insert_data->bindParam(':meioTransporte',      $meioTransporte);
    $insert_data->bindParam(':nomeContato',         $nomeContato);
    $insert_data->bindParam(':telefoneContato',     $telefoneContato);
    $insert_data->bindParam(':seguroViagemCliente', $seguroViagemCliente); */
    
    //
    $nomeCliente = filter_input(INPUT_POST, 'nomeCliente', FILTER_SANITIZE_STRING);
 
    //Insere os dados no banco
    $get_data = "INSERT INTO cliente (nome) VALUES (:nomeCliente)";
 
    $insert_data = $conexao->prepare($get_data);
    $insert_data->bindParam(':nomeCliente', $nomeCliente);
    
    if($insert_data->execute()){
        header("refresh:2; url=../index.php");
    }else{
        $_SESSION['msg'] = "<p style='color:tomato;background:#fff;'>Não foi possível enviar suas informações, verifique e tente novamente.</p>";
        header("refresh:2; url=../cadastroCliente.php");
    }
    


?>