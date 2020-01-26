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
        var $botao = $("#btn-salvar");
        ligarLoading($botao);
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
                    desligarLoading($botao);
                    exibirMensagem("Atenção!", data.erro);
                }
            }
        });
    }
});

function camposValidos(usuario){
    var regexEmail = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/;
    var regexSenha = /^\S{8}$/;
    if(usuario.nome.length === 0){
        exibirMensagem("Atenção!", "Informe o Nome completo");
        $("#nome").focus();
        return false;
    }else if(usuario.email.length === 0 || ! regexEmail.test(usuario.email)){
        exibirMensagem("Atenção!", "Informe o Email");
        $("#email").focus();
        return false;
    }else if(usuario.acao == 'adicionando' && ! regexSenha.test(usuario.senha)){
        exibirMensagem("Atenção!", "Informe a Senha");
        $("#senha").focus();
        return false;
    }else if(usuario.acao == 'editando' && usuario.senha.length > 0 && ! regexSenha.test(usuario.senha)){
        exibirMensagem("Atenção!", "Informe a Senha");
        $("#senha").focus();
        return false;
    }else{
        return true;
    }
}

$("#btn-cancelar").on("click", function(){
    var $botao = $("#btn-cancelar");
    ligarLoading($botao);
    window.location.href = base_url + "admin/professor";
});

