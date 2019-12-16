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
        exibirMensagemDeErro("Atenção!", data.erro);
      }
    });
});

function exibirMensagemDeErro(titulo, mensagem){
    iziToast.show({
        title: titulo,
        message: mensagem,
        position: "center",
        timeout: 0,
        animateInside: false,
        buttons: [
            ["<button><b>OK</b></button>", function (instance, toast, button, e, inputs) {
                instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            }, false], // true to focus
        ]
    });        
}
