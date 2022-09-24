<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Recuperar cadastro </title>
</head>

<body id="body">
    <header>
        <img id="logo" src="./resources/images/logo/logo.png">
    </header>

    <main class="form">
        <h1> Digite seus dados </h1>
        <form id="recuperar-cadastro" name="recuperarCadastro" action="controllers/userController.php" method="post">
            <p> <input type="text" name="email" id="email" placeholder="Digite seu e-mail cadastrado"> </p>
            <div id="msg"> 
                <?php 
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    else {
                        ?> <span> Um email com instruções será enviado </span> <?php
                    }
                ?>
            </div>
            <p> <button type="submit" name="recuperarSenha" class="botao-vermelho" id="recuperarSenha"> RECUPERAR SENHA </button> </p>
        </form>
        <a href="login.php" class="link-vermelho"> Voltar </a> 
    </main>

    <script src="./resources/scripts/userRecoveryPasswordValidation.js"> </script>
</body>
</html>