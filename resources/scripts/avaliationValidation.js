window.onload = function () {
    const form = document.getElementById("form-avaliar-vendedor");
    form.addEventListener("submit", validarAvaliacao);
    form.avaliacao.addEventListener("keypress", verificaNumero);
    form.avaliacao.addEventListener("keypress", verificaLenght);
}

function validarAvaliacao (event) {
    const avaliacao = document.getElementById("avaliacao").value;
    if (avaliacao == "") {
        event.preventDefault();
    }
}

function verificaNumero (event) {
    if (event.keyCode < 49 || event.keyCode > 53) {
        event.preventDefault();
    }
}

function verificaLenght (event) {
    if(this.value.length == 1) {
		event.preventDefault();
	}
}



