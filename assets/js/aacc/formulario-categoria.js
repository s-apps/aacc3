$("#frmCategoria").on("submit", function(event){
    event.preventDefault();
    var acao = $("#acao").val()
    var categoria = $("#categoria").val();
    var categoria_id = $("#categoria_id").val();
    if(categoria.length === 0){
        exibirMensagem("Atenção!", " Informe a categoria");
        $("#categoria").focus();
    }else{
        var $botao = $("#btn-salvar");
        ligarLoading($botao);
        $.post({
            url: base_url + "admin/categoria/salvar",
            dataType: "JSON",
            data: { acao: acao, categoria: categoria, categoria_id: categoria_id }
        })
        .done(function(data){
            if(data.erro.length === 0){
                window.location.href = base_url + "admin/categoria"
            }else{
                $botao = $("#btn-salvar");
                desligarLoading($botao);
                exibirMensagem("Atenção!", data.erro);
            }
        });
    }
});

$("#btn-cancelar").on("click", function(){
    var $botao = $("#btn-cancelar");
    ligarLoading($botao);
    window.location.href = base_url + "admin/categoria";
});
