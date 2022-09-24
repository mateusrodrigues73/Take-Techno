<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    session_start();
    if (!$_SESSION['logado']) {
        header('location:./login.php');
    }
    include_once('./models/product.php');
    include_once('./configuration/connect.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1d90577f4a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Meus Anúncios </title>
</head>

<body>
    <?php include_once('./includes/header.php') ?>

    <main class="anuncios-main">
        <h1> Meus Anúncios </h1>
        <a href="./cadastrarProduto.php" class="botao-verde"> ADICIONAR PRODUTO </a>
        <div id="msg">
            <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>
        </div>

        <div class="produtos">
            <?php 
                $idusuario = $_SESSION['idUsuario'];
                $query = "SELECT * FROM produtos WHERE IdUsuarios = ?";
                $array = array($idusuario);
                $produtos = selectProducts($connect, $array, $query);
                if ($produtos) {
                    foreach ($produtos as $produto) {
                        ?>
                        <div class="produto">
                            <?php
                            $idproduto = $produto['idProdutos'];
                            $query1 = "SELECT * FROM imagensprodutos WHERE IdProdutos = ?";
                            $array = array($idproduto);
                            $imagens = selectProduct($connect, $array, $query1);
                            ?>
                            
                            <div class="imagem-principal-produto">
                                <img class="imagem-principal" src='./resources/images/products/<?php echo $imagens['imagem1']?>'/>
                            </div>

                            <div class="produto-dados">
                                <h3> <?php  echo $produto['modelo']?> </h3>
                                <p> <?php  echo $produto['marca']?> </p>
                                <p> <?php  echo $produto['categoria']?> </p>
                                <p> <?php  echo 'R$'.$produto['preco']?> </p>
                            </div>

                            <div class="botoes-produtos">
                                <a href="editarProduto.php?id=<?php  echo $produto['idProdutos']?>" class="botao-editar-produto"> EDITAR PRODUTO </a>
                                <a href="controllers/productController.php?deletarProduto=<?php  echo $produto['idProdutos']?>" class="botao-deletar-produto"> DELETAR PRODUTO </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else {
                    ?> <div id="msg"> 
                        Você não tem produtos cadastrados
                    </div> <?php
                }
            ?>
        </div>

        <a href="./index.php" class="link-vermelho"> Voltar para home </a>
    </main>

    <?php include_once('./includes/footer.php') ?>
</body>

</html>