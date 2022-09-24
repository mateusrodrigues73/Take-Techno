window.onload = function () {
    document.editarProduto.modelo.focus();
    const form = document.getElementById("editar-produto");
    form.addEventListener("submit", validarProduto);
}

function validarProduto (event) {
    const modelo = document.getElementById("modelo").value;
    const marca = document.getElementById("marca").value;
    const preco = document.getElementById("preco").value;
    
    if (modelo == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo Modelo";
        event.preventDefault();
        document.editarProduto.modelo.focus();
        exit();
    }

    if (marca == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo Marca";
        event.preventDefault();
        document.editarProduto.marca.focus();
        exit();
    }

    if (preco == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo Preço";
        event.preventDefault();
        document.editarProduto.preco.focus();
        exit();
    }
}
