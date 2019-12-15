var $table  = $("#lista-professores");
var base_url = "http://localhost:8000/";
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
                rows: data.professores
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