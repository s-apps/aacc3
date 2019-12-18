var $usuario_id = $("#usuario_id");
var $categoria_id = $("#categoria_id");
var $modalidade_id = $("#modalidade_id");
var $comprovante_id = $("#comprovante_id");
var $frmAtividade = $("#frmAtividade");
// var url = window.location.href;
// var segmentos = url.split('/');

$(document).ready(function(){
    $usuario_id.select2({
        placeholder: "Selecione o aluno",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    $categoria_id.select2({
        placeholder: "Selecione a categoria",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    $modalidade_id.select2({
        placeholder: "Selecione a modalidade",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    $comprovante_id.select2({
        placeholder: "Selecione o comprovante",
        theme: "bootstrap",
        language: { noResults: function () {
            return "Nenhum resultado encontrado";
          }
        }
    });
    $("#dataatividade").datetimepicker({
        format: "L",
        // date: moment(),
        allowInputToggle: true
    });
    $("#horasinicio").datetimepicker({
        format: "HH:mm",
        allowInputToggle: true
    });     
    $("#horastermino").datetimepicker({
        format: "HH:mm",
        allowInputToggle: true
    });    
});

$categoria_id.on("change", function(){
    var categoria_id = $(this).val();
    $modalidade_id.empty().trigger("change");
    $.get({
        url: base_url + "atividade/getModalidadesByCategoria",
        dataType: "JSON",
        data: { categoria_id: categoria_id }
    })
    .done(function(data){
        var modalidades = [];
        $.each(data.modalidades, function(key, modalidade){
            modalidades.push({ id: modalidade.modalidade_id, text: modalidade.modalidade });
        });
        $modalidade_id.select2({
            placeholder: "Selecione a modalidade",
            data: modalidades,
            theme: "bootstrap"
        });
        var modalidade_id = $modalidade_id.find(":selected").val();
        getComprovantesByModalidade(modalidade_id);
    });
});

$modalidade_id.on("change", function(){
    var modalidade_id = $(this).val();
    getComprovantesByModalidade(modalidade_id);
});

function getComprovantesByModalidade(modalidade_id){
    $comprovante_id.empty().trigger("change");
    $.get({
        url: base_url + "atividade/getComprovantesByModalidade",
        dataType: "JSON",
        data: { modalidade_id: modalidade_id }
    })
    .done(function(data){
        var comprovantes = [];
        $.each(data.comprovantes, function(key, comprovante){
            comprovantes.push({ id: comprovante.comprovante_id, text: comprovante.comprovante });
        });
        $comprovante_id.select2({
            placeholder: "Selecione o comprovante",
            data: comprovantes,
            theme: "bootstrap"
        });
    });
}

$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$frmAtividade.on("submit", function(event){
    event.preventDefault();
    var atividade = {
        acao: $("#acao").val(),
        atividade_id: $("#atividade_id").val(),
        data_atividade: $("#data_atividade").val(),
        horas_inicio: $("#horas_inicio").val(),
        horas_termino: $("#horas_termino").val(),
        usuario_ra: $("#usuario_ra").val(),
        atividade: $("#atividade").val(),
        categoria_id: $("#categoria_id").val(),
        modalidade_id: $("#modalidade_id").val(),
        comprovante_id: $("#comprovante_id").val(),
        validacao: $("#validacao").val(),
        imagem_comprovante: $("#imagem_comprovante").val()
    }
    if(camposValidos(atividade)){
        var data = new FormData(this);
        $.each(atividade, function(key, item){
            data.append(key, item);
        });
        $.post({
            url: base_url + "atividade/salvar",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            data: data,
            success: function(data){
                if(data.erro.length === 0){
                    window.location.href = base_url + "atividade";
                }else{
                    exibirMensagemDeErro("Atenção!", data.erro);
                }
            }
        });
    }else{

    }
});

function camposValidos(atividade){
    var dataAtividadeValida = moment(atividade.data_atividade, "DD/MM/YYYY", true).isValid();
    var horasInicioValida = moment(atividade.horas_inicio, "HH:mm", true).isValid();
    var horasTerminoValida = moment(atividade.horas_termino, "HH:mm", true).isValid();
    if(atividade.data_atividade.length === 0 || ! dataAtividadeValida){
        exibirMensagemDeErro("Atenção!", "Informe a Data corretamente");
        $("#data_atividade").focus();
        return false;
    }else if(atividade.horas_inicio.length === 0 || ! horasInicioValida){
        exibirMensagemDeErro("Atenção!", "Informe a Horas início corretamente");
        $("#horas_inicio").focus();
        return false;
    }else if(atividade.horas_termino.length === 0 || ! horasTerminoValida){
        $("#horas_termino").focus();
        exibirMensagemDeErro("Atenção!", "Informe a Horas terḿino corretamente");
        return false;
    }else if(horasInicioMaiorHorasTermino(atividade.horas_inicio, atividade.horas_termino)){
        exibirMensagemDeErro("Atenção!", "Horas de início não pode ser menor ou igual Horas término");
        return false;
    }else if(atividade.usuario_ra.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe o Aluno");
        return false;
    }else if(atividade.atividade.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe a Atividade");
        $("#atividade").focus();
        return false;
    }else if(atividade.categoria_id.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe a Categoria");
        $("#categoria_id").select2("open");
        return false;
    }else if(atividade.modalidade_id.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe a Modalidade");
        $("#modalidade_id").select2("open");
        return false;
    }else if(atividade.comprovante_id.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe o Comprovante");
        $("#comprovante_id").select2("open");
        return false;
    }else if(atividade.validacao.length === 0){
        exibirMensagemDeErro("Atenção!", "Informe a Validação");
        $("#validacao").focus();
        return false;
    }else if(atividade.imagem_comprovante.length === 0 && atividade.acao == 'adicionando'){
        exibirMensagemDeErro("Atenção!", "Informe a Imagem do comprovante");
        $("#imagem_comprovante").focus();
        return false;
    }else{
        return true;
    }
}

function horasInicioMaiorHorasTermino(horas_inicio, horas_termino){
    var split1 = horas_inicio.split(":");
    var split2 = horas_termino.split(":");
    var horasInicio = (split1[0] * 60) + parseInt(split1[1]);
    var horasTermino = (split2[0] * 60) + parseInt(split2[1]);
    return horasInicio >= horasTermino;
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
