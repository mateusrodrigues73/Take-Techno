<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Cadastrar Usuário </title>
</head>

<body>
    <header>
        <img id="logo" src="./resources/images/logo/logo.png">
    </header>

    <main class="form">
        <h1> Digite seus dados </h1>
        <form id="cadastrar-usuario" name="cadastrarUsuario" action="controllers/userController.php" method="post">
            <p> <input type="text" name="nome" id="nome" placeholder="Nome"> </p>
            <p> <input type="text" name="email" id="email" placeholder="E-mail"> </p>
            <p> <input type="password" name="senha" id="senha" placeholder="Senha"> </p>
            <p> <input type="password" name="senha2" id="senha2" placeholder="Confirme sua senha"> </p>
            <div id="msg">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <p> <button type="submit" name="cadastrar" class="botao-vermelho" id="cadastrar"> CADASTRAR USUÁRIO </button> </p>
        </form>
        <a href="./login.php" class="link-vermelho"> Voltar </a>
    </main>

    <script src="./resources/scripts/userRegisterValidation.js"> </script>
</body>

</html>