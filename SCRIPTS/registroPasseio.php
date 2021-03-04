<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("../includes/header.php");

    //RECEBENDO E VALIDANDO VALORES
    $nomePasseio         = filter_input(INPUT_POST, 'nomePasseio',          FILTER_SANITIZE_STRING);
    $localPasseio        = filter_input(INPUT_POST, 'localPasseio',         FILTER_SANITIZE_STRING);
    $valorPasseio        = filter_input(INPUT_POST, 'valorPasseio',         FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $lotacao             = filter_input(INPUT_POST, 'lotacao',              FILTER_SANITIZE_NUMBER_INT);
    $idadeIsencao        = filter_input(INPUT_POST, 'idadeIsencao',         FILTER_SANITIZE_NUMBER_INT);
    $dataPasseio         = filter_input(INPUT_POST, 'dataPasseio',          FILTER_SANITIZE_STRING);
    $anotacoes           = filter_input(INPUT_POST, 'anotacoesPasseio',     FILTER_SANITIZE_STRING);
    $idUser              = $_SESSION['id'];


    /* -----------------------------------------------------------------------------------------------------  */

    $queryCadastraPasseio = "INSERT INTO
                            passeio (nomePasseio, localPasseio, valorPasseio, dataPasseio, anotacoes, lotacao, idadeIsencao)
                            VALUES  ('$nomePasseio', '$localPasseio', '$valorPasseio', '$dataPasseio', '$anotacoes', '$lotacao', '$idadeIsencao')
                            ";

    /* -----------------------------------------------------------------------------------------------------  */

    //VERIFICANDO SE JÁ EXISTE O PASSEIO
    $queryVerificaSeExistePasseio = "SELECT  upper(p.nomePasseio), p.dataPasseio, p.idPasseio FROM passeio p WHERE p.nomePasseio='$nomePasseio' AND p.dataPasseio='$dataPasseio' ";
    $executaQueryVerificaSeExistePasseio = mysqli_query($conexao, $queryVerificaSeExistePasseio);
    $rowPasseioVerificado = mysqli_fetch_assoc($executaQueryVerificaSeExistePasseio );
    /* -----------------------------------------------------------------------------------------------------  */
    

    if(mysqli_num_rows($executaQueryVerificaSeExistePasseio) == 0 ){
        
    /* -----------------------------------------------------------------------------------------------------  */
        cadastro($queryCadastraPasseio, $conexao, "PASSEIO", "pesquisarPasseio");
        gerarLog("PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, "CADASTRAR" , 0);

    }else{
        $idPasseio = $rowPasseioVerificado ['idPasseio']; 
        $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>JÁ EXISTE UM PASSEIO NA MESMA DATA COM O MESMO NOME </p>";
        header("refresh:0.5; url=../editarPasseio.php?id=$idPasseio");
        gerarLog("PASSEIO", $conexao, $idUser, null, $nomePasseio, $dataPasseio, null, "CADASTRAR" , 0);
        

        
    }

?>