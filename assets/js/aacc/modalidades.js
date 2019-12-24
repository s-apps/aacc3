var $table  = $("#lista-modalidades");

$(document).ready(function(){
    $table.bootstrapTable({
        url: base_url + "admin/modalidade/lista",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,
        search: true,
        showRefresh: true,
        sortName: "modalidade",
        sortOrder: "asc",
        exportDataType: "all",
        showExport: true,
        exportOptions: {
            fileName: function () {
               return "Modalidades"
            }
         },
        exportTypes: ["excel"],
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "modalidade", title: "Modalidade", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.modalidades
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
});//document ready

$("#btn-editar").on("click", function(){
    var modalidade_id = getSelections();
    window.location.href = base_url + "admin/modalidade/editar/" + modalidade_id[0];
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

function getSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.modalidade_id;
    });
}

function excluir(){
    var modalidade_ids = getSelections();
    $.post({
        url: base_url + "admin/modalidade/excluir",
        dataType: "JSON",
        data: { modalidade_ids: modalidade_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "modalidade_id",
                values: modalidade_ids
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