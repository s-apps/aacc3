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
//    console.log(data);
//    console.log(data.id);
    $.post({
      url: base_url + "admin/aluno/getHorasRealizadas",
      dataType: "JSON",
      data: { usuario_id: data.id }
    })
    .done(function(data){
      if(data.erro.length === 0){
        $table.bootstrapTable({

        });
      }else{
        exibirMensagem("Atenção!", data.erro);
      }
    });
});
