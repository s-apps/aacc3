var url = window.location.href;
var segmentos = url.split('/');

$(function(){
    $("#categoria_id").select2({
        placeholder: "Selecione uma categoria",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    $("#comprovante_id").select2({
        placeholder: "Selecione um comprovante",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    if(! $.isNumeric(segmentos[segmentos.length-1])){
        $("#minhoras").datetimepicker({
            format: "HH:mm",
            date: moment().hour(01).minute(00),
            allowInputToggle: true,
            // enabledHours: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });    
        $("#maxhoras").datetimepicker({
            format: "HH:mm",
            date: moment().hour(02).minute(00),
            allowInputToggle: true,
            // enabledHours: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });    
    }else{
        $("#minhoras").datetimepicker({
            format: "HH:mm",
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });    
        $("#maxhoras").datetimepicker({
            format: "HH:mm",
            icons: { up: "fas fa-plus", down: "fas fa-minus" }
        });    
    }
}); //document ready