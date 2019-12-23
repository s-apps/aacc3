$(document).ready(function(){
    $("#curso_id").select2({
        placeholder: "Selecione os cursos",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
});

$("#frmProfessor").on("submit", function(event){
    event.preventDefault();
    var usuario = {
        acao: $("#acao").val(),
        usuario_id: $("#usuario_id").val(),
        nome: $("#nome").val(),
        email: $("#email").val(),
        senha: $("#senha").val(),
        curso_ids: $("#curso_id").val()
    }
    if(camposValidos(usuario)){
        var data = new FormData(this);
        $.each(usuario, function(key, campo){
            data.append(key, campo);
        });
        $.post({
            url: base_url + "admin/professor/salvar",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data){
                if(data.erro.length === 0){
                    window.location.href = base_url + "admin/professor";
                }else{
                    exibirMensagem("Atenção!", data.erro);
                }
            }
        });
    }
});

function camposValidos(usuario){
    if(usuario.nome.length === 0){
        exibirMensagem("Atenção!", "Informe o Nome completo");
        $("#nome").focus();
        return false;
    }else if(usuario.email.length === 0){
        exibirMensagem("Atenção!", "Informe o Email");
        $("#email").focus();
        return false;
    }else if(usuario.senha.length === 0 && usuario.acao == 'adicionando'){
        exibirMensagem("Atenção!", "Informe a Senha");
        $("#senha").focus();
        return false;
    }else{
        return true;
    }
}
