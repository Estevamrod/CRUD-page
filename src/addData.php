<?php
include_once("config.php");

$nome = "";
$cpf = "";
$email = "";
$senha = "";
$sexo = "";

if (isset($_POST['name'])) {
    $nome = $_POST['name'];
}
if (isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['senha'])) {
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
}
if (isset($_POST['sexo'])){
    $sexo = $_POST['sexo'];
}

function duplicateEntry ($cpf, $pdo) {
    try {
        $sql = "SELECT cpf FROM usuario where cpf = \"$cpf\"";
        $verify = $pdo->prepare($sql);
        $verify->execute();
        return $verify;
    } catch (PDOException $error) {
        echo 'Error: '.$error->getMessage();
    }
}

if ($nome != "" && $cpf != "" && $email != "" && $senha != "" && $sexo != "") {
    $result = duplicateEntry($cpf, $pdo);
    $result = $result->fetch();

    if ($result != null) {
        echo "<div style=\"text-align:center; background-color:#C3001B;margin-bottom:10px;color:#fff;border-radius:8px;padding:10px\">
            <b>Você não pode cadastrar esse nome!</b>
        </div>";
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO usuario (Nome, email, cpf, senha, sexo) VALUES (:nome, :email, :cpf, :senha, :sexo)');
            $stmt->execute(array(
                'nome'=>$nome,
                'email'=>$email,
                'cpf'=>$cpf,
                'senha'=>$senha,
                'sexo'=>$sexo
            ));
            Header("Refresh:1");
        } catch (PDOException $error) {
            echo 'Error: '. $error->getMessage();
        }
    }
}
?>