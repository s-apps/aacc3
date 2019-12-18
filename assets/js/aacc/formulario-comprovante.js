$("#frmComprovante").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var comprovante = $("#comprovante").val();
    var comprovante_id = $("#comprovante_id").val();
    if(comprovante.length === 0){
        exibirMensagemDeErro("Atenção!", " Informe o comprovante");
        $("#comprovante").focus();
    }else{
        $.post({
            url: base_url + "admin/comprovante/salvar",
            dataType: "JSON",
            data: { acao: acao, comprovante: comprovante, comprovante_id: comprovante_id }
        })
        .done(function(data){
            if(data.erro.length === 0){
                window.location.href = base_url + "admin/comprovante"
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
