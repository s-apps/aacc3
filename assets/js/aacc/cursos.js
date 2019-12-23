var $table  = $("#lista-cursos");

$(document).ready(function(){
    $table.bootstrapTable({
        url: base_url + "admin/curso/lista",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,
        search: true,
        showRefresh: true,
        sortName: "curso",
        sortOrder: "asc",
        exportDataType: "all",
        showExport: true,
        exportOptions: {
            fileName: function () {
               return "Cursos"
            }
         },
        exportTypes: ["excel"],
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "curso", title: "Curso", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.cursos
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
    $("#btn-editar, #btn-excluir").prop("disabled", true);
    $("div.search input[type=text]").addClass("form-control-sm");
});//document ready

$("#btn-editar").on("click", function(){
    var curso_id = getSelections();
    window.location.href = base_url + "admin/curso/editar/" + curso_id[0];
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

function excluir(){
    var curso_ids = getSelections();
    $.post({
        url: base_url + "admin/curso/excluir",
        dataType: "JSON",
        data: { curso_ids: curso_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "curso_id",
                values: curso_ids
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
        return row.curso_id;
    });
}
