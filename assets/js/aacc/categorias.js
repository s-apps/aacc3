var $table  = $("#lista-categorias");
//var base_url = "http://localhost:8000/";
$(document).ready(function(){
    $table.bootstrapTable({
        url: base_url + "admin/categoria/lista",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",   
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,             
        search: true,
        showRefresh: true,
        sortName: "categoria",
        sortOrder: "asc",
        exportDataType: "all",
        showExport: true,
        exportOptions: {
            fileName: function () {
               return "Categorias"
            }
         },
        exportTypes: ["excel"],
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "categoria", title: "Categoria", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.categorias
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
    var categoria_id = getSelections();
    window.location.href = base_url + "admin/categoria/editar/" + categoria_id[0];
});

$("#btn-excluir").on("click", function(){
    exibirMensagemDeConfirmacao("Confirmação!", "Deseja realmente excluir os registros selecionados?");
});

function excluir(){
    var categoria_ids = getSelections();
    $.post({
        url: base_url + "admin/categoria/excluir",
        dataType: "JSON",
        data: { categoria_ids: categoria_ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "categoria_id",
                values: categoria_ids
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
        return row.categoria_id;
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
