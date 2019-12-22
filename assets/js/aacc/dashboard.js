var $table = $("#lista-avisos");

$(document).ready(function(){
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
        pageList: [5, 10, 15, 20],
        pageSize: 5,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
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
    $("#btn-editar-aviso, #btn-excluir-aviso").prop("disabled", true);
    $("#datetimepicker-data_aviso").datetimepicker({
        format: "L",
        date: moment(),
        allowInputToggle: true
    });    
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

$("#btn-adicionar-aviso").on("click", function(){
    $("#acao").val("adicionar");
    $("#formulario-avisos").modal("show");
});

$("#btn-editar-aviso").on("click", function(){
    var ids = getIdSelections();
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

function getIdSelections() {
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
            url: base_url + "dashboard/updateLimiteAtividades",
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

$table.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table", function () {
    var tamanho = $table.bootstrapTable("getSelections").length;
    $("#btn-editar-aviso").prop("disabled", (tamanho == 0 || tamanho > 1) ? true : false);
    $("#btn-excluir-aviso").prop("disabled",  tamanho == 0);
});

function exibirMensagem(titulo, mensagem){
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