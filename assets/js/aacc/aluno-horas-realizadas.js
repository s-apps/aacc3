var $table = $("#horas-realizadas");

$(document).ready(function(){
  $("#usuario_id").select2({
    placeholder: "Selecione o aluno",
    theme: "bootstrap",
    language: {
      noResults: function () {
        return "Nenhum resultado encontrado";
      }
    }
  });
  $table.bootstrapTable();
});

$("#usuario_id").on("select2:select", function (e) {
  var data = e.params.data;
  //    console.log(data);
  //    console.log(data.id);
  $.post({
    url: base_url + "admin/aluno/getTotalHorasRealizadas",
    dataType: "JSON",
    data: { usuario_id: data.id }
  })
  .done(function(data){
    console.log(data.horasRealizadas);
    $.each(data, function (key, atividade) {
      $table.bootstrapTable("insertRow", {
        index: 0,
        row: {
          data: atividade.data,
          atividade: atividade.atividade,
          carga_horaria: atividade.carga_horaria
        }
     });
  });
});
});
