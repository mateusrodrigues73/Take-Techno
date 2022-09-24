<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php session_start(); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./resources/images/logo/favico.ico">
    <link rel="stylesheet" href="./resources/styles/index.css">
    <title> Cadastrar Produtos </title>
</head>

<body>
    <header>
        <img id="logo" src="./resources/images/logo/logo.png">
    </header>

    <main class="form" id="form-cadastro-produtos">
        <h1> Digite os dados do produto </h1>
        <form id="cadastrar-produto" name="cadastrarProduto" action="controllers/productController.php" method="post" enctype="multipart/form-data">
            <div class="msg" id="errorModel"></div>
            <p> <input type="text" name="modelo" id="modelo" placeholder="Modelo do produto"> </p>

            <div class="msg" id="errorBrand"></div>
            <p> <input type="text" name="marca" id="marca" placeholder="Marca"> </p>
            
            <div class="msg" id="errorPrice"></div>
            <p> <input type="text" name="preco" id="preco" placeholder="Preço"> </p>
            
            <select name="categorias" class="select" id="produtos-select">
                <option id="select-default" selected disabled> Categoria </option>
                <optgroup label="Hadware">
                    <option value="placa mae"> Placa mãe </option>
                    <option value="ram"> RAM </option>
                    <option value="ssd"> SSD </option>
                    <option value="hd"> HD </option>
                    <option value="placa de video"> Placa de video </option>
                    <option value="gabinete"> Gabinete </option>
                    <option value="fonte"> Fonte </option>
                    <option value="coolers"> Coolers </option>
                    <option value="ventinhas"> Ventoinhas </option>
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
            
            <h3> Imagens </h3>
            <p> Foto do produto (obrigatório) </p>
            <div class="editar-imagem">
                <label for="imagem1" class="imagem-label">ESCOLHER IMAGEM</label> 
                <p> <input type="file" class="imagem-file"name="imagem1" id="imagem1"> </p>
            </div>

            <div class="editar-imagem">
                <label for="imagem2" class="imagem-label">ESCOLHER IMAGEM</label> 
                <p> <input type="file" class="imagem-file"name="imagem2" id="imagem2"> </p>
            </div>
            
            <div class="editar-imagem">
                <label for="imagem3" class="imagem-label">ESCOLHER IMAGEM</label> 
                <p> <input type="file" class="imagem-file"name="imagem3" id="imagem3"> </p>
            </div> 

            <div class="editar-imagem">
                <label for="imagem4" class="imagem-label">ESCOLHER IMAGEM</label> 
                <p> <input type="file" class="imagem-file"name="imagem4" id="imagem4"> </p>
            </div>

            <div id="msg">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </div>
            <p> <button type="submit" name="cadastrar" class="botao-vermelho" id="cadastrar"> CADASTRAR PRODUTO </button> </p>
        </form>
        <a href="./anuncios.php" class="link-vermelho"> Voltar </a>
    </main>
    
    <script src="./resources/scripts/productRegisterValidation.js"> </script>
</body>

</html>