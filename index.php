<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            margin:0px;
        }
        html {
            background-color:#EBEBEB;
        }
        form {
            display: grid;
            justify-items: center;
        }
        .container {
            width:100vw;
            height:100vh;
            background:#EBEBEB;
            display:flex;
            flex-direction:row;
            justify-content:center;
            align-items:center;
        }
        .mainScreen {
            display: flex;
            flex-direction: column;
            background-color:#FFF;
            box-shadow: 9px 9px 41px -3px rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 20px;
        }
        .mainScreen span, input{
            margin-bottom: 5px;
            font-family: 'Roboto', sans-serif;
        }
        .mainScreen span {
            font-size:14px;
            margin-top:5px;
        }
        .mainScreen button {
            margin-top:5px;
            padding:8px;
            border:none;
            font-family: 'Roboto', sans-serif;
            font-size:12px;
            background-color:#32A82C;
            color:#FAFAFA;
            border-radius:10px;
        }
        .mainScreen button:hover {
            background-color:#36B52F;
            cursor: pointer;
        }
        .mainScreen input, select {
            outline: none;
            border:1px solid #000;
            border-radius:10px;
            padding:5px;
        }
        .mainScreen h2 {
            font-family: 'verdana';
            text-align:center;
            padding-bottom:10px;
            margin-bottom:5px;
            margin-top:0px;
        }
        .mainScreen input::-webkit-input-placeholder {
            padding-left:1px;
        }
        .table {
            display: none;
            justify-content: center;
            flex-direction:column;
            align-items:center;
        }
        .table table{
            background-color:#fff;
            box-shadow: 9px 9px 41px -3px rgba(0,0,0,0.2);
            padding:15px;
            border-radius:20px;
            border-spacing:0;
            text-align:center;
        }
        th {
            border:1px solid #000;
            padding:7px;
        }
        td {
            border-bottom:1px solid #000;
            border-left:1px solid #000;
            padding:7px;
            border-right:1px solid #000;
        }
        .alterar:hover {
            background-color: #46D955;
        }
        .deletar:hover {
            background-color:#C91C1C;
        }
        .mainScreen button{
            width: 100%;
        }
        .mainScreen input {
            padding-left:11px;
        }
    </style>
</head>
<body>
    <div class="container">
    <form method="POST">
            <?php
                include_once('./src/addData.php'); //chamado para mostrar o output da requisicao de cadastro
                                                   //geralmente aparece quando ha algum erro.
            ?>
        <div class="mainScreen">
            <h2>CADASTRO</h2>
            <span>Nome</span>
            <input required name="name" placeholder="Nome">
            <span>Email</span>
            <input required type="email" name="email" placeholder="Email">
            <span>Senha</span>
            <input required name="senha" type="password">
            <span>CPF</span>
            <input required name="cpf" placeholder="000.000.000-00" pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}">
            <span>Sexo</span>
            <select name="sexo">
                <option>Male</option>
                <option>Female</option>
            </select>
            <button>CADASTRAR</button>
            
        </div>
    </form>
    </div>
    <div class="table">
    <?php
        include_once("./src/config.php");
        include_once("./src/showData.php");
        $check = Datash($pdo);
        if ($check->fetch() != null) {
            echo "
                <script>
                    let div_table = document.querySelector(\".table\");
                    let div_con = document.querySelector(\".container\");
                    div_table.style.display = \"flex\";
                    div_con.style.height = \"auto\";
                    div_con.style.margin = \"10px 0px 0px 0px\";
                </script>
            ";
        }
    ?>
        <h2>TABELA</h2>
        <table>
            <tr>
                <th style="border-top-left-radius:15px;">CPF</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Sexo</th>
                <th>Alterar</th>
                <th style="border-top-right-radius:15px;">Deletar</th>
            </tr>
                <?php
                    include_once("./src/showData.php"); //para pegar a funcao Datash
                    include_once("./src/config.php");
                    $verify = Datash($pdo);
                    for ($i = 0; $row = $verify->fetch(); $i++) {
                        echo "<tr>
                                    <td style=\"background-color:#3BCC47; color:#fff;\"><b>".$row['cpf']."</b></td>
                                    <td><b>".$row['Nome']."</b></td>
                                    <td><b>".$row['email']."</b></td>
                                    <td><b>".$row['senha']."</b></td>
                                    <td><b>".$row['sexo']."</b></td>
                                    <td class=\"alterar\"><a href=\"./src/editData.php?cpf=".$row['cpf']."\"><img src=\"./src/assets/alterar.svg\" width=\"20px\"></a></td>
                                    <td class=\"deletar\"><a href=\"./src/delete.php?cpf=".$row['cpf']."\"><img src=\"./src/assets/delete.svg\" width=\"20px\"></a></td>
                            </tr>";
                    }
                ?>
        </table>
    </div>

</body>
</html>