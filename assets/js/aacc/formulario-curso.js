$("#frmCurso").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var curso = $("#curso").val();
    var curso_id = $("#curso_id").val();
    if(curso.length === 0){
        exibirMensagem("Atenção!", " Informe o curso");
        $("#curso").focus();
    }else{
        var $botao = $("#btn-salvar");
        ligarLoading($botao);
        $.post({
            url: base_url + "admin/curso/salvar",
            dataType: "JSON",
            data: { acao: acao, curso: curso, curso_id: curso_id }
        })
        .done(function(data){
            if(data.erro.length === 0){
                window.location.href = base_url + "admin/curso"
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
    window.location.href = base_url + "admin/curso";
});
