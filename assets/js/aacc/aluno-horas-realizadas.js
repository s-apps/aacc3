$(function(){
    $("#usuario_id").select2({
        placeholder: "Selecione o aluno",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
});

$("#usuario_id").on("select2:select", function (e) {
    var data = e.params.data;
    console.log(data);
    console.log(data.id);
});
