<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0px;
        }
        form {
            display:flex;
            justify-content:center;
        }
        .container {
            width: 100vw;
            height: 100vh;
            background: #EBEBEB;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
        .EditScreen {
            display: flex;
            flex-direction: column;
            background-color:#FFF;
            box-shadow: 9px 9px 41px -3px rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 20px;
        }
        .EditScreen input, select {
            outline: none;
            border:1px solid #000;
            border-radius:10px;
            padding:5px;
        }
        .EditScreen span {
            font-size:14px;
            margin-top:5px;
        }
        .EditScreen h2 {
            font-family: 'verdana';
        }
        .EditScreen input, span {
            margin-bottom: 5px;
            font-family: 'Roboto', sans-serif;
        }
        .EditScreen input {
            padding-left:11px;
        }
        .EditScreen button {
            margin-top:5px;
            padding:8px;
            border:none;
            font-family: 'Roboto', sans-serif;
            font-size:12px;
            background-color:#32A82C;
            color:#FAFAFA;
            border-radius:10px;
        }
        .EditScreen button:hover {
            background-color:#36B52F;
            cursor: pointer;
        }
        .spinner {
            border:6px solid rgba(0,0,0, 0.1);
            border-left-color: rgba(235, 0, 0, 92);
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
    <form method="POST" action="saveEdit.php">
        <div class="container">
            <?php
                include_once("config.php");
                if (!isset($_GET['cpf'])) {
                    if ($_GET == null) {
                        echo "
                            <script>
                                let div = document.querySelector(\".EditScreen\");
                                div.style.display = \"none\";
                            </script>
                        ";      // script em js que faz a div sumir
                        echo "
                            <div style=\"display:flex; align-items:center; flex-direction:column;\">
                                <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Acesso negado, voce nao selecionou ninguem❌</h1>
                                <div class=\"spinner\"></div>
                            </div>
                        ";
                        header("Refresh:2; Url=./../index.php");
                    }
                } else {
                    try {
                        $fetching = $pdo->prepare("SELECT nome, email, cpf, senha, sexo from usuario where cpf=:cpf");
                        $fetching->execute(array("cpf"=>$_GET['cpf']));
                        $fetchData = $fetching->fetch();
                    } catch (Exception $error) {
                        print($error);
                    }
                    if ($fetchData != null) {
                        echo "
                            <div class=\"EditScreen\">
                                <h2>ALTERAR DADOS</h2>
                                <span>Nome</span>
                                <input value=\"".$fetchData['nome']."\" name=\"nome\" maxlenght=\"100\">
                                <span>CPF</span>
                                <input value=\"".$fetchData['cpf']."\" name=\"cpf\" placeholder=\"000.000.000-00\" pattern=\"\d{3}\.?\d{3}\.?\d{3}-?\d{2}\">
                                <span>Email</span>
                                <input value=\"".$fetchData['email']."\" name=\"email\" type=\"email\">
                                <span>Senha</span>
                                <input value=\"".$fetchData['senha']."\" name=\"senha\" type=\"password\">
                                <span>sexo</span>";
                        if ($fetchData['sexo'] == "M") {
                            echo "<select name=\"sexo\">
                                        <option selected>Male</option>
                                        <option>Female</option>
                                    </select>";
                        } else {
                            echo "<select name=\"sexo\">
                                        <option>Male</option>
                                        <option selected>Female</option>
                                    </select>";
                        }
                        echo "
                                <input type=\"hidden\" value=".$_GET['cpf']." name=\"cpf_origin\">
                                <button type=\"submit\">ALTERAR</button>
                            </div>";
                    }
                }
            ?>  
        </div>
    </form>
</body>
</html>