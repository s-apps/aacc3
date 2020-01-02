$(document).ready(function(){
    $("#curso_id").select2();
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
    var regexEmail = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/;
    if(usuario.nome.length === 0){
        exibirMensagem("Atenção!", "Informe o Nome completo");
        $("#nome").focus();
        return false;
    }else if(usuario.email.length === 0 || ! regexEmail.test(usuario.email)){
        exibirMensagem("Atenção!", "Informe o Email");
        $("#email").focus();
        return false;
    }else if(usuario.senha.length < 8 && usuario.acao == 'adicionando'){
        exibirMensagem("Atenção!", "Informe a Senha com no mínimo 8 caracteres");
        $("#senha").focus();
        return false;
    }else{
        return true;
    }
}

$("#curso_id").on("select2:unselect", function (e) {
    //console.log("select2:unselect", e);
    console.log($("#curso_id").val());
});
