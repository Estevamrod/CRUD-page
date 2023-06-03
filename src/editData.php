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
            display: flex;
            justify-content: center;
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
        .EditScreen input {
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
            background-color:#5BC960;
            color:#FAFAFA;
            border-radius:10px;
        }
        .EditScreen button:hover {
            background-color:#62D967;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form method="POST" action="saveEdit.php">
        <div class="container">
            <div class="EditScreen">
                <h2>ALTERAR DADOS</h2>
                <?php
                    include_once("config.php");
                    $codigo = "";
                    if (isset($_GET['codigo'])) {
                        $codigo = $_GET['codigo'];
                    } else {
                        if ($_GET == null) {
                            print("Você precisa selecionar alguém para alterar os dados!");
                            header("Refresh:2; Url=./../index.php");
                        }
                    }
                    try {
                        $fetching = $pdo->prepare("SELECT nome, cpf, celular from clientes where codigo=".$codigo."");
                        $fetching->execute();
                        $fetchData = $fetching->fetch();

                    } catch (Exception $error) {
                        print($error);
                    }

                    if ($fetchData != null) {
                        echo "
                            <span>Nome</span>
                            <input value=\"".$fetchData['nome']."\" name=\"nome\" maxlenght=\"100\">
                            <span>Celular</span>
                            <input value=\"".$fetchData['celular']."\" name=\"celular\">
                            <span>CPF</span>
                            <input value=\"".$fetchData['cpf']."\" name=\"cpf\">
                            <input type=\"hidden\" value=\"".$_GET['codigo']."\" name=\"codigo\">
                        ";
                    }
                ?>  
                <button type="submit">ALTERAR</button>
            </div>
        </div>
    </form>
</body>
</html>