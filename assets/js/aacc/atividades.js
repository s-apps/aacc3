var $table  = $("#lista-atividades");

$(document).ready(function(){
    $table.bootstrapTable({
        url: base_url + "atividade/lista",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,
        search: true,
        showRefresh: true,
        sortName: "data",
        sortOrder: "desc",
        exportDataType: "all",
        showExport: true,
        exportOptions: {
            fileName: function () {
               return "Atividades"
            }
         },
        exportTypes: ["excel"],
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "data", title: "Data", sortable: true },
            { field: "atividade", title: "Atividade", sortable: true },
            { field: "usuario_ra", title: "RA", sortable: true },
            { field: "nome", title: "Aluno", sortable: true },
            { field: "email", title: "Email", sortable: true },
            { field: "validacao", title: "Situação", sortable: true, formatter: setTextoSituacao }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.atividades
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
});

function setTextoSituacao(index, row){
    return (row.validacao == 0) ? '<span class="text-danger">Aguardado validação</span>' : '<span class="text-success">Válido</span>';
}

$("#btn-adicionar").on("click", function(){
    var $botao = $("#btn-adicionar");
    ligarLoading($botao);
    window.location.href = base_url + "atividade/adicionar";
});

$("#btn-editar").on("click", function(){
    var $botao = $("#btn-editar");
    ligarLoading($botao);
    var atividade_id = getSelections();
    window.location.href = base_url + "atividade/editar/" + atividade_id[0];
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

function excluir(){
    var atividade_ids = getSelections();
    $.post({
        url: base_url + "atividade/excluir",
        dataType: "JSON",
        data: { atividade_ids: atividade_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "atividade_id",
                values: atividade_ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

function getSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.atividade_id;
    });
}

$table.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table", function () {
    var tamanho = $table.bootstrapTable("getSelections").length;
    $("#btn-editar").prop("disabled", (tamanho == 0 || tamanho > 1) ? true : false);
    $("#btn-excluir").prop("disabled",  tamanho == 0);
});
