var $table = $("#horas-realizadas-aluno");

$(document).ready(function(){
  $table.bootstrapTable({
    showColumns: false,
    pagination: true,
    pageList: [10, 25, 50, 100],
    pageSize: 10,
    theadClasses: "thead-light",
    classes: "table table-bordered table-sm table-hover",
    columns: [
      {field: "data", title: "Data"},
      {field: "atividade", title: "Atividade"},
      {field: "horas_inicio", title: "Início"},
      {field: "horas_termino", title: "Término"},
      {field: "carga_horaria", title: "Carga horária"}
    ]
  });
  $("#usuario_id").select2({
    placeholder: "Selecione o aluno",
    theme: "bootstrap",
    language: {
      noResults: function () {
        return "Nenhum resultado encontrado";
      }
    }
  });
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
    $table.bootstrapTable("removeAll");
    $table.fadeOut("slow");

    var horas = [];
    $.each(data.horasRealizadas, function (key, atividade) {
      horas.push({carga_horaria: atividade.carga_horaria});
      $table.bootstrapTable("insertRow", {
        index: 0,
        row: {
          data: atividade.data,
          atividade: atividade.atividade,
          horas_inicio: atividade.horas_inicio,
          horas_termino: atividade.horas_termino,
          carga_horaria: atividade.carga_horaria
        }
      });
    });
    $("#totalHorasRealizadas").html("Total de horas: <strong>" + somaHoras(horas) + "</strong>");
    $table.fadeIn("slow");
  });
});

function somaHoras(horas) {
    var t1 = "00:00";
    var mins = 0;
    var hrs = 0;
    $.each(horas, function (index, row) {
        t1 = t1.split(":");
        var t2 = row.carga_horaria.split(":");
        mins = Number(t1[1]) + Number(t2[1]);
        minhrs = Math.floor(parseInt(mins / 60));
        hrs = Number(t1[0]) + Number(t2[0]) + minhrs;
        mins = mins % 60;
        t1 = hrs.padDigit() + ':' + mins.padDigit();
    });
    return t1.toString();
}

Number.prototype.padDigit = function () {
    return (this < 10) ? '0' + this : this;
}
