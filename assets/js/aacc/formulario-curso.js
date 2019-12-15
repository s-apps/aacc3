var base_url = "http://localhost:8000/";

$("#frmCurso").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var curso = $("#curso").val();
    var curso_id = $("#curso_id").val();
    if(curso.length === 0){
        exibirMensagemDeErro("Atenção!", " Informe a curso");
        $("#curso").focus();
    }else{
        $.post({
            url: base_url + "admin/curso/salvar",
            dataType: "JSON",
            data: { acao: acao, curso: curso, curso_id: curso_id }
        })
        .done(function(data){
            if(data.erro.length === 0){
                window.location.href = base_url + "admin/curso"
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