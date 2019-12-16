//var base_url = "http://localhost:8000/";

$(function(){
    $("#curso_id").select2({
        placeholder: "Selecione um curso",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
});

$("#frmAluno").on("submit", function(event){
    event.preventDefault();
    var usuario = {
        acao: $("#acao").val(),
        usuario_id: $("#usuario_id").val(),
        nome: $("#nome").val(),
        usuario_ra: $("#usuario_ra").val(),
        email: $("#email").val(),
        senha: $("#senha").val(),
        curso_id: $("#curso_id").val()
    }
    if(camposValidos(usuario)){
        var data = new FormData(this);
        $.each(usuario, function(key, campo){
            data.append(key, campo);
        });
        $.post({
            url: base_url + "admin/aluno/salvar",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data){
                if(data.erro.length === 0){
                    window.location.href = base_url + "admin/aluno";
                }else{
                    exibirMensagemDeErro("Atenção!", data.erro);
                }
            }
        });
    }
});

function camposValidos(usuario){
    if(usuario.nome.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe o Nome completo");
        $("#nome").focus(); 
        return false;       
    }else if(usuario.usuario_ra.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe o RA");
        $("#usuario_ra").focus(); 
        return false;       
    }else if(usuario.email.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe o Email");
        $("#email").focus(); 
        return false;       
    }else if(usuario.senha.length === 0 && usuario.acao == 'adicionando'){
        exibirMensagemDeErro("Atenção!", "Informe a Senha");
        $("#senha").focus(); 
        return false;       
    }else if(usuario.curso_id.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe o Curso");
        $("#curso_id").focus(); 
        return false;       
    }else{
        return true;
    }
}

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
