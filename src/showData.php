<?php
    include_once("config.php");    

    function delData ($Prim_key,$pdo) {
        try {
            $sql = "SELECT codigo, nome FROM clientes where codigo =".$Prim_key."";
            $verify = $pdo->prepare($sql);
            $verify->execute();
            $fetch = $verify->fetch();
            return $fetch;
        } catch (Exception $error) {
            print($error);
        }
    }

    function Datash ($pdo) {
        try {
            $sql = "SELECT * from clientes";
            $req = $pdo->prepare($sql);
            $req->execute();
            return $req;
        } catch(Exception $error) {
            print($error);
        }
    }
?>