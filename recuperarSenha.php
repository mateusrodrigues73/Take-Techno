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
        <form id="recuperar-senha" name="recuperarSenha" action="controllers/userController.php" method="post">
            <p> <input type="password" name="senha" id="senha" placeholder="Digite sua nova senha"> </p>
            <p> <input type="password" name="senha2" id="senha2" placeholder="Confirme sua senha"> </p>
            <div id="msg"> 
                <?php 
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
            </div>
            <p> <button type="submit" name="recuperarCadastro" class="botao-vermelho" id="recuperarCadastro"> ALTERAR SENHA </button> </p>
        </form>
    </main>

    <script src="./resources/scripts/userChangePasswordValidation.js"> </script>
</body>
</html>