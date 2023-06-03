<?php
    //Arquivo para criar uma conexão com o banco mysql;
    //Usa a classe PDO para fazer a conexão;
    try {
        $pdo = new PDO ('mysql:host=localhost;dbname=dbcadastro','root','',array(PDO::ATTR_PERSISTENT => true));
        $pdo -> setAttribute
        (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $error) {
        print($error) -> getMessage();
    }
    
?>