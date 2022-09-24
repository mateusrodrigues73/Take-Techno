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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Editar Produto </title>
</head>

<body>
    <header>
        <img id="logo" src="./resources/images/logo/logo.png">
    </header>

    <?php 
        $idproduto = $_GET['id'];
        $_SESSION['idproduto'] = $idproduto;
        $query = "SELECT * FROM produtos WHERE idProdutos = ?";
        $array = array($idproduto);
        $produto = selectProduct ($connect, $array, $query);
        $query = "SELECT * FROM imagensprodutos WHERE idProdutos = ?";
        $imagens = selectProduct ($connect, $array, $query);
        $_SESSION['imagem1'] = $imagens['imagem1'];
        $_SESSION['imagem2'] = $imagens['imagem2'];
        $_SESSION['imagem3'] = $imagens['imagem3'];
        $_SESSION['imagem4'] = $imagens['imagem4'];
    ?>

    <main class="form" id="form-editar-produto">
        <h1>Editar Produto</h1>
        <form id="editar-produto" name="editarProduto" action="controllers/productController.php" method="post" enctype="multipart/form-data">
            <p> <input type="text" name="modelo" id="modelo" placeholder="Modelo do produto" value="<?php echo $produto['modelo'] ?>"> </p>
            <p> <input type="text" name="marca" id="marca" placeholder="Marca" value="<?php echo $produto['marca'] ?>"> </p>
            <p> <input type="text" name="preco" id="preco" placeholder="Preço" value="<?php echo $produto['preco'] ?>"> </p>
            <p>
                <select name="categorias" class="select" id="produtos-select">
                <option id="select-default" selected value="<?php echo $produto['categoria'] ?>"> <?php echo $produto['categoria'] ?> </option>
                    <optgroup label="Hadware">
                        <option value="placa mae"> Placa mãe </option>
                        <option value="ram"> RAM </option>
                        <option value="ssd"> SSD </option>
                        <option value="hd"> HD </option>
                        <option value="placa de video"> Placa de video </option>
                        <option value="gabinete"> Gabinete </option>
                        <option value="fonte"> Fonte </option>
                        <option value="coolers"> Coolers </option>
                        <option value="ventoinhas"> Ventoinhas </option>
                        <option value="hardware outros"> Outros </option>
                    </optgroup>
                    <optgroup label="Periféricos">
                        <option value="teclado"> Teclado </option>
                        <option value="mouse"> Mouse </option>
                        <option value="headphone"> Headphone </option>
                        <option value="mouse pad"> Mouse pad </option>
                        <option value="caixa de som"> Caixa de som </option>
                        <option value="acessorios"> Acessórios </option>
                        <option value="perifericos outros"> Outros </option>
                    </optgroup>
                </select>
            </p>
            <h3> Imagens </h3>
            <div class=editar-imagem>
                <img class="imagem-editar" src='./resources/images/products/<?php echo $imagens['imagem1']?>' width='100px' height='100px'/>
                <label for="imagem1" class="imagem-label">ESCOLHER IMAGEM</label>
                <p> <input type="file" class="imagem-file" name="imagem1" id="imagem1"> </p>
            </div>

            <div class=editar-imagem>
                <?php
                    if (isset($_SESSION['imagem2'])) { ?>
                        <div class="imagem-produto-editar">
                            <img class="imagem-editar" src='./resources/images/products/<?php echo $imagens['imagem2']?>' width='100px' height='100px'/>    
                        </div> <?php
                    } 
                ?>
                <label for="imagem2" class="imagem-label">ESCOLHER IMAGEM</label>
                <p> <input type="file" class="imagem-file" name="imagem2" id="imagem2"> </p>
            </div>      

            <div class=editar-imagem>
                <?php
                    if (isset($_SESSION['imagem3'])) { ?>
                        <div class="imagem-produto-editar">
                            <img class="imagem-editar" src='./resources/images/products/<?php echo $imagens['imagem3']?>' width='100px' height='100px'/>    
                        </div> <?php
                    } 
                ?>
                <label for="imagem3" class="imagem-label">ESCOLHER IMAGEM</label>
                <p> <input type="file" class="imagem-file" name="imagem3" id="imagem3"> </p>
            </div> 

            <div class=editar-imagem>
                <?php
                    if (isset($_SESSION['imagem4'])) { ?>
                        <div class="imagem-produto-editar">
                            <img class="imagem-editar" src='./resources/images/products/<?php echo $imagens['imagem4']?>' width='100px' height='100px'/>    
                        </div> <?php
                    } 
                ?>
                <label for="imagem4" class="imagem-label">ESCOLHER IMAGEM</label>
                <p> <input type="file" class="imagem-file" name="imagem4" id="imagem4"> </p>
            </div> 

            <div id="msg">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <p> <button type="submit" name="editar-produto" class="botao-vermelho" id="editar-produto"> EDITAR PRODUTO </button> </p>
        </form>
        <a href="./anuncios.php" class="link-vermelho"> Voltar </a>
    </main>

    <script src="./resources/scripts/productEditValidation.js"> </script>
</body>
</html>