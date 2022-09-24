<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Login </title>
</head>

<body id="body">
    <header>
        <img id="logo" src="./resources/images/logo/logo.png">
    </header>

    <main class="form">
        <h1> Digite seus dados </h1>
        <form id="logar-usuario" name="logarUsuario" action="controllers/userController.php" method="post">
            <p> <input type="text" name="email" id="email" placeholder="E-mail"> </p>
            <p> <input type="password" name="senha" id="senha" placeholder="Senha"> </p>
            <div id="msg">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <p> <button type="submit" name="logar" class="botao-vermelho" id="logar"> ACESSAR CONTA </button> </p>
        </form>
        <a href="recuperarCadastro.php" class="link-vermelho"> Esqueci minha senha </a>
        <a href="cadastrarUsuario.php" class="botao-verde"> CADASTRE-SE </a>
    </main>

    <script src="./resources/scripts/userLoginValidation.js"> </script>
</body>

</html>