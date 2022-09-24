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
    <title> Histórico de compras </title>
</head>

<body>
    <?php 
    include_once('./includes/header.php');
    $idusuario = $_SESSION['idUsuario']; 
    $query = "SELECT * FROM comprasusuarios WHERE idUsuarios = ?";
    $array = array($idusuario);
    $compras = selectProducts($connect, $array, $query);
    ?>

    <main class="main">
    <h1> Minhas compras </h1>
        <a href="./perfil.php" class="botao-verde"> VOLTAR </a>

        <?php 
        If ($compras) {
            ?>
            <form id="form-deletar-compras" name="formDeletarCompras" action="controllers/userController.php" method="post">
                    <p> <button type="submit" name="deletarCompras" class="botao-vermelho" id="deletar-compras"> DELETAR HISTÓRICO </button> </p>
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
            if ($compras) {
                foreach ($compras as $compra) {
                    $idvendedor = $compra['idVendedor'];
                    $query = "SELECT * FROM usuarios WHERE idUsuarios = ?";
                    $array = array($idvendedor);
                    $vendedor = selectProduct($connect, $array, $query);
                    $query = "SELECT * FROM enderecos WHERE idUsuarios = ?";
                    
                    ?>
                    <div class="compra"> 
                        <div class="dados-compra">
                            <h3> Dados do produto </h3>
                            <p> <?php echo $compra['modelo']?> </p>
                            <p> <?php echo $compra['categoria']?> </p>
                            <p> Valor da compra: <?php echo $compra['preco']?> </p>
                            <p> Data da Compra: <?php echo $compra['dataCompra']?> </p>
                        </div>

                        <div class="dados-compra">
                            <?php 
                            if ($vendedor) {
                                ?>
                                <h3> Avaliar vendedor </h3>
                                <p> <?php echo $vendedor['nome']?> </p>
                                <form id="form-avaliar-vendedor" name="formAvaliarVendedor" action="controllers/userController.php" method="post">
                                    <p> <input type="hidden" id="idvendedor" name="idvendedor" value="<?php echo $compra['idVendedor']?>"> <p>
                                    <p> <input type="text" id="avaliacao" name="avaliacao" placeholder="1-5"> </p>
                                    <p> <button type="submit" name="avaliarVendedor" class="button-editar-usuario" id="avaliar-vendedor"> AVALIAR VENDEDOR </button> </p>
                                </form>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="deletar-compra">
                            <form id="form-deletar-compra" name="formDeletarCompra" action="controllers/userController.php" method="post">
                            <p> <input type="hidden" id="idcompra" name="idcompra" value="<?php echo $compra['idComprasUsuarios']?>"> </p>
                            <p> <button type="submit" name="deletarCompra" class="button-editar-usuario" id="deletar-compra"> DELETAR COMPRA </button> </p>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                ?> 
                <div id="msg"> 
                        Você não tem compras no seu histórico 
                </div> 
                <?php
            }
            ?>
        </div>

        <a href="./index.php" class="link-vermelho"> Voltar para home </a>

        <script src="./resources/scripts/avaliationValidation.js"> </script>
    </main>

    <?php include_once('./includes/footer.php') ?>
</body>
</html>