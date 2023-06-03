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

        if ($_POST != null) { //essa pagina e linkada com outra, se o post estiver vazio, significa que nao passamos pela pagina anterior a essa.
            $codigo = $_POST['codigo'];
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $celular = $_POST['celular'];
            try {
                $sql = "UPDATE clientes set nome=:nome, cpf=:cpf, celular=:celular where codigo=:codigo";
                $editing = $pdo->prepare($sql) -> execute (array(
                    "nome" => $nome,
                    "cpf" => $cpf,
                    "celular" => $celular,
                    "codigo" => $codigo
                ));
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
                header("Refresh:2; URL=./../index.php");
            } else {
                echo "
                    <div style=\"display:flex; align-items:center; flex-direction:column;\">
                        <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Nao foi possivel realizar a alteracao ❌</h1>
                        <div class=\"spinner2\"></div>
                    </div>
                ";
                header("Refresh:2; URL=editData.php");
            }
        } else {
            echo "
            <div style=\"display:flex; align-items:center; flex-direction:column;\">
                <h1 style=\"color:#191919;font-family: Roboto, sans-serif; \">Acesso negado, você não deve estar aqui ❌</h1>
                <div class=\"spinner2\"></div>
            </div>
            ";
            header("Refresh:2; URL=./../index.php");
        }
    ?>
</body>
</html>