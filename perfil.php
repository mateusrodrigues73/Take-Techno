<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    session_start();
    if (!$_SESSION['logado']) {
        header('location:./login.php');
    }
    include_once('./models/user.php');
    include_once('./configuration/connect.php');
    header('Access-Control-Allow-Origin: *');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1d90577f4a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Meus Perfil </title>
</head>

<body>
    <?php include_once('./includes/header.php') ?>

    <?php
        $idusuario = $_SESSION['idUsuario'];
        $query = "SELECT * FROM usuarios WHERE idUsuarios = ?";
        $array = array($idusuario);
        $usuario = selectUser($connect, $array, $query);
        $_SESSION['imagem'] = $usuario['imagem'];
        $query = "SELECT * FROM enderecos WHERE idUsuarios = ?";
        $endereco = selectUser($connect, $array, $query);
    ?>

    <main class="form">
        <h1> Meu Perfil </h1>

        <a href="./compras.php" class="botao-verde"> HISTÓRICO DE COMPRAS </a>
        <a href="./vendas.php" class="botao-verde"> HISTÓRICO DE VENDAS </a>
        <a id="sair" href="./login.php" class="botao-vermelho"> SAIR </a>
        <form id="form-deletar-usuario" name="formDeletarUsuario" action="controllers/userController.php" method="post">
                <p> <button type="submit" name="deletarUsario" class="botao-vermelho" id="deletar-usuario"> DELETAR CONTA </button> </p>
        </form>

        <div id="msg">
            <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>
        </div>

        <form id="imagem-usuario" name="imagemUsuario" action="controllers/userController.php" method="post" enctype="multipart/form-data" onsubmit="validarImagemUsuario(event);">
            <div class="dado-usuario" id="editar-imagem-usuario">
                <img class="imagem-usuario" src='./resources/images/users/<?php echo $usuario['imagem'] ?>'/>
                <p id="p-imagem1"> <label class="label-file botao-verde" for="imagem"> TROCAR IMAGEM </label> </p>
                <p id="p-imagem2"> <input class="file" type="file" name="imagem" id="imagem"> </p>
                <p id="p-imagem3"> <button type="submit" name="editarImagemUsario" class="button-editar-usuario" id="editar-imagem-usuario"> EDITAR IMAGEM </button> </p>
                <div class="msg" id="errorImage"></div> 
            </div>
        </form>
        <?php 
            if ($usuario['imagem'] != 'user.png') {
                $_SESSION['imagemUsuario'] = $usuario['imagem'];
                ?>
                <form id="form-deletar-imagem-usuario" name="formDeletarImagemUsuario" action="controllers/userController.php" method="post">
                    <p> <button type="submit" name="deletarImagemUsario" class="button-editar-usuario" id="deletar-imagem-usuario"> DELETAR IMAGEM </button> </p>
                </form>
                <?php
            }
        ?>

        <form id="nome-usuario" name="nomeUsuario" action="controllers/userController.php" method="post" onsubmit="validarNomeUsuario(event);">    
            <div class="dado-usuario" id="editar-nome-usuario">
                <h3> Nome </h3>
                <p> <input type="text" name="nome" id="nome" value="<?php echo $usuario['nome']?>" placeholder="Digite seu nome"> </p>
                <p> <button type="submit" name="editarNomeUsario" class="button-editar-usuario" id="editar-nome-usuario"> EDITAR NOME </button> </p>
                <div class="msg" id="errorName"></div> 
            </div>
        </form>

        <form id="senha-usuario" name="senhaUsuario" action="controllers/userController.php" method="post" onsubmit="validarSenhaUsuario(event);">         
            <div class="dado-usuario" id="editar-senha-usuario">
                <h3> Trocar senha </h3>
                <p> <input type="password" name="senhaAtual" id="senha-atual" placeholder="Digite sua senha atual"> </p>
                <p> <input type="password" name="senhaNova" id="senha-nova" placeholder="Digite sua nova senha"> </p>
                <p> <input type="password" name="senhaNova2" id="senha-nova2" placeholder="Confirme sua nova senha"> </p>
                <p> <button type="submit" name="editarSenhaUsario" class="button-editar-usuario" id="editar-senha-usuario"> EDITAR SENHA </button> </p>
                <div class="msg" id="errorPassword"></div>
            </div> 
        </form>
        
            <?php 
                if (!$endereco) {
                    ?>
                    <div class="dado-usuario" id="editar-endereco-usuario">
                        <h3> Adicionar endereço </h3>
                        <p> <input type="text" name="cep" id="cep" placeholder="Digite seu CEP"> </p>
                        <p> <button type="button" name="editarCepUsario" class="button-editar-usuario" id="editar-cep-usuario" onclick="cadastrarEndereco();"> CADASTRAR CEP </button> </p>
                        <div class="msg" id="errorAddress"></div>
                    </div>   
                    <?php
                }
                else {
                    ?>
                    <form id="endereco-usuario" name="enderecoUsuario" action="controllers/userController.php" method="post" onsubmit="validarEnderecoUsuario(event);"> 
                        <div class="dado-usuario" id="editar-endereco-usuario">
                            <h3> Endereço </h3>
                            <p> <input type="text" name="estado" id="estado" value="<?php echo $endereco['estado']?>" placeholder="Digite seu estado"> </p>
                            <p> <input type="text" name="cidade" id="cidade" value="<?php echo $endereco['cidade']?>" placeholder="Digite sua cidade"> </p>
                            <p> <input type="text" name="logradouro" id="logradouro" value="<?php echo $endereco['logradouro']?>" placeholder="Digite seu logradouro"> </p>
                            <p> <button type="submit" name="editarEnderecoUsario" class="button-editar-usuario" id="button-editar-endereco-usuario"> EDITAR ENDEREÇO </button> </p>
                            <div class="msg" id="errorAddress">
                            </div>
                        </div>
                    </form>
                    <form id="form-deletar-endereco-usuario" name="formDeletarEnderecoUsuario" action="controllers/userController.php" method="post">
                    <p> <button type="submit" name="deletarEnderecoUsuario" class="button-editar-usuario" id="deletar-endereco-usuario"> DELETAR ENDEREÇO </button> </p>
                    </form>
                    <?php
                }
            ?>  
        </form>
        </div>

        <a href="./index.php" class="link-vermelho"> Voltar para home </a>

        <script src="./resources/scripts/userEditValidation.js"> </script>
        <script src="./resources/scripts/addressRegister.js"> </script>
    </main>

    <?php include_once('./includes/footer.php') ?>
</body>

</html>