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
        html {
            background-color:#EBEBEB;
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
    <form method="POST" class="requestScreen">
        <div class="confirmScreen">
            <h2>Voce tem certeza que deseja excluir esse dado?</h2>
            <button  name="sim" id="sim" >SIM</button>
            <button  name="nao" id="nao">NAO</button>
        </div>
    </form>
    <?php
        include("config.php");
        include("showData.php");

        if (!empty($_GET)) {
            if (isset($_POST['sim'])) { // caso o usuario escolha "sim" na tela de confirmamento
                $prim_key = $_GET['codigo']; //GET usado para pegar o valor do codigo que veio da URL
                $req = delData($prim_key, $pdo);
                if (!empty($req)) {
                    try {
                        $sql = "DELETE FROM clientes where codigo=".$req['codigo']."";
                        $del_req = $pdo->prepare($sql);
                        $sqlDel = $del_req->execute();
                    } catch(Exception $error) {
                        print($error);
                    }
                    if ($sqlDel != 0) {
                        hideConfirmScreen();
                        echo "
                            <div style=\"display:flex; align-items:center; flex-direction:column;\">
                                <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">\"".$req['nome']."\" excluido com sucesso✅</h1>
                                <div class=\"spinner\"></div>
                            </div>
                        ";
                        header("Refresh:2; URL=./../index.php");
                    } else {
                        echo "
                            <div style=\"display:flex; align-items:center; flex-direction:column;\">
                                <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Nao foi possivel excluir\"".$req['nome']."\"❌</h1>
                                <div class=\"spinner2\"></div>
                            </div>
                        ";
                        header("Refresh:2; URL=./../index.php");
                    }
                }
            } else if (isset($_POST['nao'])) { //Caso o usuario escolha "nao" como opcao na tela de confirmamento
                hideConfirmScreen();
                echo "
                    <div style=\"display:flex; align-items:center; flex-direction:column;\">
                        <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Redirecionando...</h1>
                        <div class=\"spinner3\"></div>
                    </div>
                ";
                Header("Refresh:1.2; URL=./../index.php");
            }
        } else {
            hideConfirmScreen();
            echo "
            <div style=\"display:flex; align-items:center; flex-direction:column;\">
                <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Acesso negado, voce nao selecionou ninguem❌</h1>
                <div class=\"spinner2\"></div>
            </div>
        ";
        header("Refresh:2.4; URL=./../index.php");
        }

        function hideConfirmScreen () {
            echo "
                <script>
                    let div = document.querySelector(\".requestScreen\");
                    div.style.display = \"none\";
                </script>
            ";
        }
    ?>
</body>
</html>