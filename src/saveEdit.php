<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionando...</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            background:#fff;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            height:100vh;
        }
        .requestScreen {
            display:block;
        }
        .confirmScreen {
            display: flex;
            flex-direction: column;
            background-color:#FFF;
            box-shadow: 9px 9px 41px -3px rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 20px;
        }
        .confirmScreen h2 {
            padding-bottom:10px;
            margin-bottom: 5px;
            margin-top:0px;
            font-family: 'Roboto', sans-serif;
            text-align:center;
        }
        .confirmScreen button {
            margin-top:5px;
            padding:8px;
            border:none;
            font-family: 'Roboto', sans-serif;
            font-size:12px;
            color:#FAFAFA;
            border-radius:10px;
        }
        .confirmScreen #sim {
            background-color:#32A82C;
        }
        .confirmScreen #nao {
            background-color:#BA1B13;
        }
        .confirmScreen #nao:hover {
            background-color:#C91C1C;
            cursor: pointer;
        }
        .confirmScreen #sim:hover {
            background-color:#36B52F;
            cursor: pointer;
        }
        .spinner {
            border:6px solid rgba(0,0,0, 0.1);
            border-left-color: rgba(0, 189, 50, 0.6);
            height:60px;
            width:60px;
            border-radius:50%;
            animation: spin 1s linear infinite;
        }
        .spinner2 {
            border:6px solid rgba(0,0,0, 0.1);
            border-left-color: rgba(235, 0, 0, 92);
            height:60px;
            width:60px;
            border-radius:50%;
            animation: spin 1s linear infinite;
        }
        .spinner3 {
            border:6px solid rgba(0,0,0, 0.1);
            border-left-color: rgba(0, 0, 0);
            height:60px;
            width:60px;
            border-radius:50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <?php
        include_once("config.php");
        include_once("showData.php");
        if ($_POST != null) { //essa pagina e linkada com outra, se o post estiver vazio, significa que nao passamos pela pagina anterior a essa.
            if ($_POST['nome'] != "" && $_POST['senha'] != "" && $_POST['cpf'] != ""  && $_POST['email'] != "" && $_POST['sexo'] != "") {
                try {
                    $cpf = $_POST['cpf'];
                    if (delData($cpf,$pdo) == null) {
                        $editing = $pdo->prepare("UPDATE usuario set nome=:nome, cpf=:cpf, email=:email, senha=:senha, sexo=:sexo where cpf=:cpf") -> execute (array(
                            "nome" => $_POST['nome'],
                            "cpf" => $_POST['cpf'],
                            "email" => $_POST['email'],
                            "senha" => password_hash($_POST['senha'], PASSWORD_DEFAULT),
                            "sexo" => $_POST['sexo']
                        ));
                    }
                } catch(Exception $error) {
                    print($error);
                }
                if ($editing != 0) { //0 - false, 1 - true; vemos qual foi o resultado do update e colocamos em uma condicional
                    echo "
                        <div style=\"display:flex; align-items:center; flex-direction:column;\">
                            <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Alteração realizada Sucesso ✅</h1>
                            <div class=\"spinner\"></div>
                        </div>
                    ";
                    // header("Refresh:2; URL=./../index.php");
                } else {
                    echo "
                        <div style=\"display:flex; align-items:center; flex-direction:column;\">
                            <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Nao foi possivel realizar a alteracao ❌</h1>
                            <div class=\"spinner2\"></div>
                        </div>
                    ";
                    // header("Refresh:2; URL=editData.php");
                }
            } else {
                    echo "
                    <div style=\"display:flex; align-items:center; flex-direction:column;\">
                        <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Você nao pode deixar nenhum campo em branco ❌</h1>
                        <div class=\"spinner2\"></div>
                    </div>
                    ";
                    // if ($_POST['cpf'] != "") {
                    //     header("Refresh:2; URL=editData.php?cpf=".$_POST['cpf']."");
                    // } else {
                    //     header("Refresh:2; URL=./../index.php");
                    // }
            }
        } else {
            echo "
            <div style=\"display:flex; align-items:center; flex-direction:column;\">
                <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Acesso negado, você não deve estar aqui ❌</h1>
                <div class=\"spinner2\"></div>
            </div>
            ";
            // header("Refresh:2; URL=./../index.php");
        }
    ?>
</body>
</html>