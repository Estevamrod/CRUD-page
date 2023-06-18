<?php
    include_once("config.php");    

    function delData ($Prim_key,$pdo) {
        try {
            $verify = $pdo->prepare("SELECT cpf,nome FROM usuario where cpf =:cpf");
            $verify->execute(array("cpf"=>$Prim_key));
            $fetch = $verify->fetch();
            return $fetch;
        } catch (Exception $error) {
            print($error);
        }
    }

    function Datash ($pdo) {
        try {
            $sql = "SELECT * from usuario";
            $req = $pdo->prepare($sql);
            $req->execute();
            return $req;
        } catch(Exception $error) {
            print($error);
        }
    }
?>