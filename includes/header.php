<header>
    <a id="link-logo" href="index.php">
        <img id="logo" src="./resources/images/logo/logo2.png"> 
    </a>
    <div class="header-section">
        <form class="header-form" id="form-buscar-produtos" action="./controllers/productController.php" method="post">
            <p>
                <input type="busca" classe="busca" name="busca" id="busca" placeholder="Buscar produtos" autocomplete="off">
                <button type="submit" name="buscar" id="buscar"> <i class="fa-solid fa-magnifying-glass lupa"> </i> </button>
            </p>
        </form>
        <nav class="header-nav">
            <ul class="header-nav-itens">
                <li class="categorias">
                    <span id="span-categorias"> Categorias </span>
                    <ul class="categorias-drop">
                        <li class="hardware">
                            <span class="categorias-drop-spans"> Hardware </span>
                            <ul class="hardware-drop">
                                <li> <a href="index.php?categoria=placa mae"> Placa mãe </a> </li>
                                <li> <a href="index.php?categoria=ram"> RAM </a> </li>
                                <li> <a href="index.php?categoria=ssd"> SSD </a> </li>
                                <li> <a href="index.php?categoria=hd"> HD </a> </li>
                                <li> <a href="index.php?categoria=placa de video"> Placa de video </a> </li>
                                <li> <a href="index.php?categoria=gabinete"> Gabinete </a> </li>
                                <li> <a href="index.php?categoria=fonte"> Fonte </a> </li>
                                <li> <a href="index.php?categoria=cooler"> Coolers </a> </li>
                                <li> <a href="index.php?categoria=ventoinhas"> Ventoinhas </a> </li>
                                <li> <a href="index.php?categoria=hardware outros"> Outros </a> </li>
                            </ul>
                        </li>
                        <li class="perifericos">
                            <span> Periféricos </span>
                            <ul class="perifericos-drop">
                                <li> <a href="index.php?categoria=teclado"> Teclado </a> </li>
                                <li> <a href="index.php?categoria=mouse"> Mouse </a> </li>
                                <li> <a href="index.php?categoria=headphone"> Headphone </a> </li>
                                <li> <a href="index.php?categoria=mousepad"> Mousepad </a> </li>
                                <li> <a href="index.php?categoria=caixa de som"> Caixa de som </a> </li>
                                <li> <a href="index.php?categoria=acessorios"> Acessórios </a> </li>
                                <li> <a href="index.php?categoria=perifericos outros"> Outros </a> </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li id="anuncios"> <a href="./anuncios.php"> <i class="fa-solid fa-desktop header-icons"></i> Meus anúncios </a> </li>
                <li id="perfil"> <a href="./perfil.php"> <i class="fa-solid fa-user header-icons"></i> Perfil </a> </li>
            </ul>
        </nav>
    </div>

    <script src="./resources/scripts/searchValidation.js"> </script>
</header>