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
        sortOrder: "asc",
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