<?php
session_start();
include_once("../PHP/conexao.php");
$id= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)){

    /* -----------------------------------------------------------------------------------------------------  */
    $verificaSeExistePagamento = "SELECT * FROM pagamento_passeio WHERE idPasseio='$id'";
    $resultadoVerificaSeExistePagamento =mysqli_query($conexao, $verificaSeExistePagamento);
    /* -----------------------------------------------------------------------------------------------------  */


    if(mysqli_num_rows($resultadoVerificaSeExistePagamento) == 0){
    /* -----------------------------------------------------------------------------------------------------  */
        $getDataPasseio = "DELETE FROM passeio WHERE idPasseio ='$id'";
        $inserDataPasseio = mysqli_query ($conexao, $getDataPasseio );
    /* -----------------------------------------------------------------------------------------------------  */
        
        if(mysqli_affected_rows($conexao)){
    /* -----------------------------------------------------------------------------------------------------  */
            $getDataDespesa = "DELETE FROM despesa WHERE idPasseio ='$id'";
            $inserDataDespesa = mysqli_query ($conexao, $getDataDespesa );
    /* -----------------------------------------------------------------------------------------------------  */
            $_SESSION['msg'] = "<p class='h5 text-center alert-success'>Passeio APAGADO com sucesso</p>";
            header("refresh:0.5; url=../index.php");
            
        
        }else {
            $_SESSION['msg'] = "<p class='h5 text-center alert-danger'>Passeio NÃO foi APAGADO </p>";
            header("refresh:0.5; url= index.php");
        
        }
    }else{
        $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário remover PAGAMENTOS existentes </p>";
        header("refresh:0.5; url=../pesquisarPasseio.php");
    }
}else {
    $_SESSION['msg'] = "<p class='h5 text-center alert-warning''>Necessário selecionar um Passeio</p>";
    header("refresh:0.5; url=../pesquisarPasseio.php");

}

?>