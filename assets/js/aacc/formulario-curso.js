$("#frmCurso").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var curso = $("#curso").val();
    var curso_id = $("#curso_id").val();
    if(curso.length === 0){
        exibirMensagem("Atenção!", " Informe a curso");
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
                exibirMensagem("Atenção!", data.erro);
            }
        });
    }
});
