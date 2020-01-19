var base_url = "http://localhost:8000/";

$(document).ready(function(){
  $("#btn-editar, #btn-excluir").prop("disabled", true);
  $("div.search input[type=text]").addClass("form-control-sm");
});

function queryParams(params) {
    return {
        limit: params.limit,
        offset: params.offset,
        sort: params.sort,
        order: params.order,
        search: params.search
    };
}

function exibirMensagem(titulo, mensagem){
    iziToast.show({
        title: titulo,
        message: mensagem,
        position: "center",
        timeout: 0,
        animateInside: false,
        closeOnEscape: true,
        buttons: [
            ["<button><b>FECHAR (ESC)</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            }, false], // true to focus
        ]
    });
}

function exibirMensagemDeConfirmacao(titulo, mensagem){
    iziToast.show({
        title: titulo,
        message: mensagem,
        position: "center",
        timeout: 0,
        animateInside: false,
        closeOnEscape: true,
        buttons: [
            ["<button><b>Excluir</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "buttonExcluir");
            }, false], // true to focus
            ["<button><b>Cancelar (ESC)</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "buttonCancelar");
            }, false] // true to focus
        ],
        onClosing: function(instance, toast, closedBy){
            if(closedBy == "buttonExcluir"){
                excluir();
            }
        }
    });
}
