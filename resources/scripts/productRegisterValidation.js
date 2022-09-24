window.onload = function () {
    document.cadastrarProduto.modelo.focus();
    const form = document.getElementById("cadastrar-produto");
    form.addEventListener("submit", validarProduto);
}

function validarProduto (event) {
    const modelo = document.getElementById("modelo").value;
    const marca = document.getElementById("marca").value;
    const preco = document.getElementById("preco").value;
    const categoria = document.getElementById("produtos-select").value;
    const imagem1 = document.getElementById("imagem1").value;

    if (modelo == "") {
        document.getElementById('errorModel').innerHTML = "Preencha o campo Modelo";
        setTimeout (() => {
            document.getElementById('errorModel').innerHTML = "";
        }, 1500)
        event.preventDefault();
        document.cadastrarProduto.modelo.focus();
        exit();
    }

    if (marca == "") {
        document.getElementById('errorBrand').innerHTML = "Preencha o campo Modelo";
        setTimeout (() => {
            document.getElementById('errorBrand').innerHTML = "";
        }, 1500)
        event.preventDefault();
        document.cadastrarProduto.marca.focus();
        exit();
    }

    if (preco == "") {
        document.getElementById('errorPrice').innerHTML = "Preencha o campo Preço";
        setTimeout (() => {
            document.getElementById('errorPrice').innerHTML = "";
        }, 1500)
        event.preventDefault();
        document.cadastrarProduto.preco.focus();
        exit();
    }

    if (categoria == "Categoria") {
        document.getElementById('msg').innerHTML = "Escolha uma categoria";
        setTimeout (() => {
            document.getElementById('msg').innerHTML = "";
        }, 1500)
        event.preventDefault();
        exit();
    }

    if (imagem1 == "") {
        document.getElementById('msg').innerHTML = "Primeira imagem é obrigatória";
        setTimeout (() => {
            document.getElementById('msg').innerHTML = "";
        }, 1500)
        event.preventDefault();
    }
}