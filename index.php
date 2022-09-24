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
    <title> Home Page </title>
</head>

<body>
    <?php include_once('./includes/header.php') ?>

    <main class="index-main">
        <?php
        if (isset($_GET['categoria']) || isset($_GET['busca'])) {
            ?> 
            <h1> Resultados da busca </h1>
            <a id="voltar" href="./index.php" class="botao-verde"> HOME </a> 
            <?php
        }
        else {
            ?> <h1> Ultimos adicionados </h1> <?php
        }
        ?>
        
        <div class="produtos">
            <?php 
            $idusuario = $_SESSION['idUsuario'];
            if (isset($_GET['categoria'])) {
                $categoria = $_GET['categoria'];
                $query = "SELECT * FROM produtos WHERE categoria = ?";
                $array = array($categoria);
            }
            else {
                if (isset($_GET['busca'])) {
                    $busca = $_GET['busca'];
                    $query = "SELECT * FROM produtos WHERE modelo like ? OR marca like ?";
                    $array = array($busca."%", $busca."%");
                }
                else {
                    $query = "SELECT * FROM produtos WHERE idUsuarios <> ? ORDER BY idProdutos DESC LIMIT 0, 15";
                    $array = array($idusuario);
                }
            }
            $produtos = selectProducts($connect, $array, $query);
                if ($produtos) {
                    foreach($produtos as $produto) {
                        ?>
                        <a class="produto" href="produto.php?key=<?php echo $produto['idProdutos']?>"> 
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
                                <p class="produto-nome"> <?php  echo $produto['categoria']?> </p>
                                <p class="produto-nome"> <?php  echo $produto['marca']?> </p>
                                <h3 class="produto-nome"> <?php  echo $produto['modelo']?> </h3>
                                <p class="preco"> <?php  echo 'R$'.$produto['preco']?> </p>
                            </div>
                        </a>
                        <?php
                    }
                }
                else {
                    ?> 
                    <div id="msg"> 
                        Sem resultados
                    </div> 
                    <?php
                }
            ?>
        </div>    
    </main>

    <?php include_once('./includes/footer.php') ?>
</body>

</html>
