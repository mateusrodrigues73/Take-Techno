<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    session_start();
    if (!$_SESSION['logado']) {
        header('location:./login.php');
    }
    include_once('./models/product.php');
    include_once('./models/user.php');
    include_once('./configuration/connect.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1d90577f4a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Histórico de vendas </title>
</head>

<body>
    <?php 
    include_once('./includes/header.php');
    $idusuario = $_SESSION['idUsuario']; 
    $query = "SELECT * FROM vendasusuarios WHERE idUsuarios = ?";
    $array = array($idusuario);
    $vendas = selectProducts($connect, $array, $query); 
    ?>

    <main class="main">
    <h1> Minhas vendas </h1>
        <a href="./perfil.php" class="botao-verde"> VOLTAR </a>

        <?php 
        If ($vendas) {
            ?>
            <form id="form-deletar-vendas" name="formDeletarVendas" action="controllers/userController.php" method="post">
                    <p> <button type="submit" name="deletarVendas" class="botao-vermelho" id="deletar-vendas"> DELETAR HISTÓRICO </button> </p>
            </form>
            <?php
        }
        ?>

        <div id="msg">
            <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>
        </div>

        <div class="compras">
            <?php
            if ($vendas) {
                foreach ($vendas as $venda) {
                    ?>
                    <div class="compra"> 
                        <div class="dados-compra">
                            <h3> Dados do produto </h3>
                            <p> <?php echo $venda['modelo']?> </p>
                            <p> <?php echo $venda['categoria']?> </p>
                            <p> Valor da venda: <?php echo $venda['preco']?> </p>
                            <p> Data da venda: <?php echo $venda['dataVenda']?> </p>
                        </div>

                        <div class="deletar-compra">
                            <form id="form-deletar-venda" name="formDeletarVenda" action="controllers/userController.php" method="post">
                            <p> <input type="hidden" id="idvenda" name="idvenda" value="<?php echo $venda['idvendasUsuarios']?>"> </p>
                            <p> <button type="submit" name="deletarVenda" class="button-editar-usuario" id="deletar-venda"> DELETAR VENDA </button> </p>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                ?> 
                <div id="msg"> 
                        Você não tem vendas no seu histórico 
                </div> 
                <?php
            }
            ?>
        </div>  

        <a href="./index.php" class="link-vermelho"> Voltar para home </a>
    </main>

    <?php include_once('./includes/footer.php') ?>
</body>
</html>