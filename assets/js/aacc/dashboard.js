var $table = $("#lista-avisos");

$(document).ready(function(){
    var nivel = $(".dashboard").data("nivel");
    $table.bootstrapTable({
        url: base_url + "dashboard/getAvisos",
        queryParamsType: "limit",
        queryParams : queryParams,
        sidePagination: "server",
        showRefresh: false,
        showColumns: false,
        showToggle: false,
        pagination: true,
        clickToSelect: true,
        search: false,
        sortName: "data",
        sortOrder: "desc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true, align: "center", visible: (parseInt(nivel) == 0) ? true : false },
            { field: "data", title: "Data", sortable: true },
            { field: "titulo", title: "Título", sortable: true },
            { field: "aviso", title: "Aviso", sortable: true }
        ],
        responseHandler: function(data){
            return {
                total: data.total,
                rows: data.avisos
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
    $("#datetimepicker-data_aviso").datetimepicker({
        format: "L",
        date: moment(),
        allowInputToggle: true
    });
});

$("#btn-adicionar").on("click", function(){
    $("#acao").val("adicionar");
    $("#formulario-avisos").modal("show");
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

$("#btn-editar").on("click", function(){
    var ids = getSelections();
    $.get({
        url: base_url + "dashboard/getAvisoById/" + ids[0],
        dataType: "JSON"
    })
    .done(function(data){
        $("#acao").val("editar");
        $("#aviso_id").val(data.aviso.aviso_id);
        $("#data_aviso").val(data.aviso.data);
        $("#titulo").val(data.aviso.titulo);
        $("#aviso").val(data.aviso.aviso);
        $("#titulo").focus();
        $("#formulario-avisos").modal("show");
    });
});

function excluir(){
    var aviso_ids = getSelections();
    $.post({
        url: base_url + "dashboard/excluirAviso",
        dataType: "JSON",
        data: { aviso_ids: aviso_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "aviso_id",
                values: aviso_ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar-aviso, #btn-excluir-aviso").prop("disabled", true);
        }
    });
}

function getSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
      return row.aviso_id
    });
}

$("#formulario-avisos").on("shown.bs.modal", function(e){
    $("#titulo").focus();
});

$("#formulario-avisos").on("hidden.bs.modal", function (e) {
    $("#titulo").val("");
    $("#aviso").val("");
});

$("#frmLimite").on("submit", function(event){
    event.preventDefault();
    var limite_atividades = $("#limite_atividades").val();
    if(limite_atividades.length === 0 || !$.isNumeric(limite_atividades) || parseInt(limite_atividades) <= 0){
        exibirMensagem("Atenção!", "Informe Limite de horas das atividades corretamente");
        $("#limite_atividades").focus();
        return false;
    }else{
        $.post({
            url: base_url + "dashboard/atualizarLimiteAtividades",
            dataType: "JSON",
            data: { limite_atividades: limite_atividades}
        })
        .done(function(data){
            if(data.erro.length == 0){
                exibirMensagem("Sucesso!", "Atualizado com sucesso!");
            }else{
                exibirMensagem("Atenção!", data.erro);
            }
        });
    }
});

$("#formulario-avisos").on("submit", function(event){
    event.preventDefault();
    var aviso = {
        aviso_id: $("#aviso_id").val(),
        data_aviso: $("#data_aviso").val(),
        titulo: $("#titulo").val(),
        aviso: $("#aviso").val(),
        acao: $("#acao").val()
    };
    if(camposValidos(aviso)){
        var data = new FormData();
        $.each(aviso, function(key, item){
            data.append(key, item);
        });
        $.post({
            url: base_url + "dashboard/salvarAviso",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data){
                if(data.erro.length === 0){
                    window.location.href = base_url + "dashboard";
                }else{
                    exibirMensagem("Atenção!", data.erro);
                }
            }
        });
    }else{

    }
});

function camposValidos(aviso){
    var dataAvisoValida = moment(aviso.data_aviso, "DD/MM/YYYY", true).isValid();
    if(aviso.data_aviso.length === 0 || ! dataAvisoValida){
        exibirMensagem("Atenção!", "Informe a Data corretamente");
        $("#data_aviso").focus();
        return false;
    }else if(aviso.titulo.length === 0){
        exibirMensagem("Atenção!", "Informe o Título");
        $("#titulo").focus();
        return false;
    }else if(aviso.aviso.length === 0){
        exibirMensagem("Atenção!", "Informe o Aviso");
        $("#aviso").focus();
        return false;
    }else{
        return true;
    }
}
