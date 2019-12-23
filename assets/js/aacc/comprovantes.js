var $table  = $("#lista-comprovantes");

$(document).ready(function(){
    $table.bootstrapTable({
        url: base_url + "admin/comprovante/lista",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,
        search: true,
        showRefresh: true,
        sortName: "comprovante",
        sortOrder: "asc",
        exportDataType: "all",
        showExport: true,
        exportOptions: {
            fileName: function () {
               return "Comprovantes"
            }
         },
        exportTypes: ["excel"],
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "comprovante", title: "Comprovante", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.comprovantes
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

$("#btn-editar").on("click", function(){
    var comprovante_id = getSelections();
    window.location.href = base_url + "admin/comprovante/editar/" + comprovante_id[0];
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

function excluir(){
    var comprovante_ids = getSelections();
    $.post({
        url: base_url + "admin/comprovante/excluir",
        dataType: "JSON",
        data: { comprovante_ids: comprovante_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "comprovante_id",
                values: comprovante_ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

$table.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table", function () {
    var tamanho = $table.bootstrapTable("getSelections").length;
    $("#btn-editar").prop("disabled", (tamanho == 0 || tamanho > 1) ? true : false);
    $("#btn-excluir").prop("disabled",  tamanho == 0);
});

function getSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.comprovante_id;
    });
}
