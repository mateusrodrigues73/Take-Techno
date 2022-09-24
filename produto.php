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
    <title> Comprar produto </title>
</head>

<body>
    <?php 
    include_once('./includes/header.php');

    $idproduto = $_GET['key'];
    $query = "SELECT * FROM produtos WHERE idProdutos = ?";
    $array = array($idproduto);
    $produto = selectProduct($connect, $array, $query);

    $query = "SELECT * FROM imagensprodutos WHERE idProdutos = ?";
    $imagens = selectProduct($connect, $array, $query);

    $query = "SELECT usuarios.* FROM usuarios JOIN produtos USING (idUsuarios) WHERE produtos.idProdutos = ?";
    $vendedor = selectUser($connect, $array, $query);

    $idvendedor = $vendedor['idUsuarios'];
    $query = "SELECT * FROM enderecos WHERE idUsuarios = ?";
    $array = array($idvendedor);
    $vendedorEndereco = selectUser($connect, $array, $query);

    $_SESSION['idproduto'] = $idproduto;
    $_SESSION['idvendedor'] = $idvendedor;  
    ?> 
    
    <main class="produto-main">
        <div class="imagens-compra-secundaria">      
            <?php 
            if ($imagens['imagem2']) {
                ?>
                <img class="imagem-compra-secundaria" src='./resources/images/products/<?php echo $imagens['imagem2']?>'/>
                <?php
            }
            if ($imagens['imagem3']) {
                ?>
                <img class="imagem-compra-secundaria" src='./resources/images/products/<?php echo $imagens['imagem3']?>'/>
                    <?php
            }
            if ($imagens['imagem4']) {
                ?>
                <img class="imagem-compra-secundaria" src='./resources/images/products/<?php echo $imagens['imagem4']?>'/>
                <?php
            }
            ?>
        </div>
            
        
        <div class="imagens-compra-principal">        
                <img id="imagemP" class="imagem-compra-principal" src='./resources/images/products/<?php echo $imagens['imagem1']?>'/>
        </div>

        <div class="compra-dados">
            <div class="vendedor-main">  
                <div class="vendedor">
                    <div class="vendedor-dados">
                        <img class="imagem-vendedor" src='./resources/images/users/<?php echo $vendedor['imagem']?>'/>
                    </div>

                    <div class="vendedor-vendas">
                        <h3 id="nome-vendedor"> <?php  echo $vendedor['nome']?> </h3>
                        <p id="total-vendas-vendedor"> Vendas no site: <?php  echo $vendedor['totalVendas']?> </p>
                        <p id="avaliacoes-vendedor"> Número de avaliações: <?php  echo $vendedor['avaliacoes']?> </p>
                        <p id="avaliacoes-vendedor"> Média de avaliações: <?php  echo $vendedor['mediaAvaliacoes']?> </p>
                    </div>
                </div>

                <?php 
                if ($vendedorEndereco) {
                    ?>
                    <div class="vendedor-endereco"> 
                        <p> <?php echo $vendedorEndereco['estado'].', '.$vendedorEndereco['cidade'].', '.$vendedorEndereco['logradouro']?></p>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="produto-compra-dados">
                <h3> <?php  echo $produto['modelo']?> </h3>
                <p> <?php  echo $produto['categoria']?> </p>
                <p> <?php  echo $produto['marca']?> </p>
                <p id="preco"> <?php  echo 'R$'.$produto['preco']?> </p>
            </div>

            <div class="produto-compra">
                <form id="comprar-produto" name="formComprarProduto" action="controllers/userController.php" method="post">
                    <p> <button type="submit" name="comprarProduto" class="botao-vermelho"> COMPRAR PRODUTO </button> </p>
                </form>
            </div>
        </div>    
    </main>

    <div class="index-main">
        <div id="msg">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>
        
        <a href="./index.php" class="link-vermelho"> Voltar para home </a>
    </div>
    
    <?php include_once('./includes/footer.php') ?>
</body>
</html>