<?php $conn = new mysqli("localhost", "root", "", "fabiosistema2");
        if($conn->connect_errno){
            echo"FALHA AO SE CONECTAR COM O MYSQL: " . $conn->connect_error;
            exit();
        }

?>

