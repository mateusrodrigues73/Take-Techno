window.onload = function () {
    const form = document.getElementById("form-buscar-produtos");
    form.addEventListener("submit", validarBusca);
}

function validarBusca (event) {
    const busca = document.getElementById("busca").value;
    if (busca == "") {
        event.preventDefault();
    }
}
