var url = window.location.href;
var segmentos = url.split('/');

$(document).ready(function(){
    $("#categoria_id").select2({
        placeholder: "Selecione uma categoria",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    $("#comprovante_id").select2({
        placeholder: "Selecione um comprovante",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    if(! $.isNumeric(segmentos[segmentos.length-1])){
        $("#minhoras").datetimepicker({
            format: "HH:mm",
            date: moment().hour(01).minute(00),
            allowInputToggle: true,
            // enabledHours: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });
        $("#maxhoras").datetimepicker({
            format: "HH:mm",
            date: moment().hour(02).minute(00),
            allowInputToggle: true,
            // enabledHours: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });
    }else{
        $("#minhoras").datetimepicker({
            format: "HH:mm",
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });
        $("#maxhoras").datetimepicker({
            format: "HH:mm",
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });
    }
}); //document ready

$("#frmModalidade").on("submit", function(event){
    event.preventDefault();
    var modalidade = {
        acao: $("#acao").val(),
        modalidade_id: $("#modalidade_id").val(),
        modalidade: $("#modalidade").val(),
        min_horas: $("#min_horas").val(),
        max_horas: $("#max_horas").val(),
        categoria_id: $("#categoria_id").val(),
        comprovante_id: $("#comprovante_id").val()
    };
    if(camposValidos(modalidade)){
        var data = new FormData(this);
        $.each(modalidade, function(key, campo){
            data.append(key, campo);
        });
        var $botao = $("#btn-salvar");
        ligarLoading($botao);
        $.post({
            url: base_url + "admin/modalidade/salvar",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data){
                if(data.erro.length === 0){
                    window.location.href = base_url + "admin/modalidade";
                }else{
                    desligarLoading($botao);
                    exibirMensagem("Atenção!", data.erro);
                }
            }
        });
    }
});

function camposValidos(modalidade){
    if(modalidade.modalidade.length === 0){
        exibirMensagem("Atenção!", "Informe a Modalidade");
        $("#modalidade").focus();
        return false;
    }else if(modalidade.min_horas.length === 0){
        exibirMensagem("Atenção!", "Informe o Mínimo de horas (duração)");
        $("#min_horas").focus();
        return false;
    }else if(modalidade.max_horas.length === 0){
        exibirMensagem("Atenção!", "Informe o Máximo de horas (limite)");
        $("#max_horas").focus();
        return false;
    }else if(modalidade.categoria_id.length === 0){
        exibirMensagem("Atenção!", "Informe a Categoria");
        $("#categoria_id").focus();
        return false;
    }else if(modalidade.comprovante_id.length === 0){
        exibirMensagem("Atenção!", "Informe o Comprovante");
        $("#comprovante_id").focus();
        return false;
    }else{
        return true;
    }
}

$("#btn-cancelar").on("click", function(){
    var $botao = $("#btn-cancelar");
    ligarLoading($botao);
    window.location.href = base_url + "admin/modalidade";
});
