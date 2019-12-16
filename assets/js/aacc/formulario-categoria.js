//var base_url = "http://localhost:8000/";

$("#frmCategoria").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var categoria = $("#categoria").val();
    var categoria_id = $("#categoria_id").val();
    if(categoria.length === 0){
        exibirMensagemDeErro("Atenção!", " Informe a categoria");
        $("#categoria").focus();
    }else{
        $.post({
            url: base_url + "admin/categoria/salvar",
            dataType: "JSON",
            data: { acao: acao, categoria: categoria, categoria_id: categoria_id }
        })
        .done(function(data){
            if(data.erro.length === 0){
                window.location.href = base_url + "admin/categoria"
            }else{
                exibirMensagemDeErro("Atenção!", data.erro);
            }
        });
    }
});

function exibirMensagemDeErro(titulo, mensagem){
    iziToast.show({
        title: titulo,
        message: mensagem,
        position: "center",
        timeout: 0,
        animateInside: false,
        buttons: [
            ["<button><b>OK</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            }, false], // true to focus
        ]
    });        
}
