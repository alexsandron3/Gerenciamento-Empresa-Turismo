<?php
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

        include_once("conexao.php");
        include_once("functions.php");
        header("Content-type: text/html; charset=utf-8");
        
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: login.php");
            exit;
          }



?>