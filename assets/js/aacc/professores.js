var $table  = $("#lista-professores");

$(document).ready(function(){
    $table.bootstrapTable({
        url: base_url + "admin/professor/lista",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",   
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,             
        search: true,
        showRefresh: true,
        sortName: "nome",
        sortOrder: "asc",
        exportDataType: "all",
        showExport: true,
        exportOptions: {
            fileName: function () {
               return "Professores"
            }
         },
        exportTypes: ["excel"],
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "nome", title: "Nome", sortable: true },
            { field: "email", title: "Email", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.usuarios
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }         
    });
    $("#btn-editar, #btn-excluir").prop("disabled", true);
    $("div.search input[type=text]").addClass("form-control-sm");
});//document ready

function queryParams(params) {
    return {
        limit: params.limit,
        offset: params.offset,
        sort: params.sort,
        order: params.order,
        search: params.search
    };
}

$table.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table", function () {
    var tamanho = $table.bootstrapTable("getSelections").length;
    $("#btn-editar").prop("disabled", (tamanho == 0 || tamanho > 1) ? true : false);
    $("#btn-excluir").prop("disabled",  tamanho == 0);
});

$("#btn-editar").on("click", function(){
    var usuario_id = getSelections();
    window.location.href = base_url + "admin/professor/editar/" + usuario_id[0];
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

function excluir(){
    var usuario_ids = getSelections();
    $.post({
        url: base_url + "admin/aluno/excluir",
        dataType: "JSON",
        data: { usuario_ids: usuario_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "usuario_id",
                values: usuario_ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

function exibirMensagemDeConfirmacao(titulo, mensagem){
    iziToast.show({
        title: titulo,
        message: mensagem,
        position: "center",
        timeout: 0,
        animateInside: false,
        buttons: [
            ["<button><b>Excluir</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "buttonExcluir");
            }, false], // true to focus
            ["<button><b>Cancelar</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "buttonCancelar");
            }, false] // true to focus
        ],
        onClosing: function(instance, toast, closedBy){
            if(closedBy == "buttonExcluir"){
                excluir();
            }
        }       
    });        
}

function getSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.usuario_id;
    });
}
