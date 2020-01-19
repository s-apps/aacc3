$("#frmComprovante").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var comprovante = $("#comprovante").val();
    var comprovante_id = $("#comprovante_id").val();
    if(comprovante.length === 0){
        exibirMensagem("Atenção!", " Informe o comprovante");
        $("#comprovante").focus();
    }else{
        var $botao = $("#btn-salvar");
        ligarLoading($botao);
        $.post({
            url: base_url + "admin/comprovante/salvar",
            dataType: "JSON",
            data: { acao: acao, comprovante: comprovante, comprovante_id: comprovante_id }
        })
        .done(function(data){
            if(data.erro.length === 0){
                window.location.href = base_url + "admin/comprovante"
            }else{
                desligarLoading($botao);
                exibirMensagem("Atenção!", data.erro);
            }
        });
    }
});

$("#btn-cancelar").on("click", function(){
    var $botao = $("#btn-cancelar");
    ligarLoading($botao);
    window.location.href = base_url + "admin/comprovante";
});