<?php
include_once("config.php");

$nome = "";
$celular = "";
$cpf = "";

if (isset($_POST['name'])) {
    $nome = $_POST['name'];
}
if (isset($_POST['celular'])) {
    $celular = $_POST['celular'];
}
if (isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
}


function duplicateEntry ($nome, $pdo) {
    try {
        $sql = "SELECT codigo FROM clientes where nome = \"$nome\"";
        $verify = $pdo->prepare($sql);
        $verify->execute();
        return $verify;
    } catch (PDOException $error) {
        echo 'Error: '.$error->getMessage();
    }
}

if ($nome != "" && $celular != "" && $cpf != "") {
    $result = duplicateEntry($nome, $pdo);
    $result = $result->fetch();

    if ($result != null) {
        echo "<div style=\"text-align:center; background-color:#C3001B;margin-bottom:10px;color:#fff;border-radius:8px;padding:10px\">
            <b>Você não pode cadastrar esse nome!</b>
        </div>";
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO clientes (nome, cpf, celular) VALUES (:nome, :cpf, :celular)');
            $stmt->execute(array(
                'nome'=>$nome,
                'cpf'=>$cpf,
                'celular'=>$celular
            ));
            Header("Refresh:1");
        } catch (PDOException $error) {
            echo 'Error: '. $error->getMessage();
        }
    }
}
?>