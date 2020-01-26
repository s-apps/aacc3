var button = document.querySelector('button[type=button]');
var submit = document.querySelector('button[type=submit]');
var groupSenha = document.querySelector('.group-senha');
var acao = document.querySelector('#acao');
var inputEmail = document.querySelector('#email');
var small = document.createElement('small');
var erroLogin = document.querySelector('.erro-login');
var sucessoRecuperar = document.querySelector('.sucesso-recuperar');
var frmLogin = document.querySelector('#frmLogin');

button.addEventListener('click', function(){
    erroLogin.style.display = 'none';
    sucessoRecuperar.style.display = 'none';
    if(acao.value == 'entrar'){
        acao.value = 'recuperar';
        this.textContent = 'Login';
        groupSenha.style.display = 'none';
        submit.textContent = 'Enviar senha';
        small.classList.add('form-text', 'text-muted');
        small.textContent = 'Informe o Email cadastrado no sistema.';
        inputEmail.insertAdjacentElement('afterend', small);
    }else{
        acao.value = 'entrar';
        this.textContent = 'Esqueceu a senha?';
        groupSenha.style.display = 'block';
        submit.textContent = 'Entrar';
        small.remove();
    }
    inputEmail.focus();
});

frmLogin.addEventListener('submit', function(event){
    event.preventDefault();
    var usuario = {
        email: this.email.value,
        senha: this.senha.value,
        acao: this.acao.value
    }
    if(camposValidos(usuario)){
        enviarDados(usuario);
    }else{
        exibirErro(usuario.acao);
    }
});

function camposValidos(usuario){
    var regexEmail = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/;
    if(usuario.acao == 'entrar'){
        return (usuario.senha.length > 0 && regexEmail.test(usuario.email));
    }else{
        return (regexEmail.test(usuario.email));
    }
}

function exibirErro(acao){
    erroLogin.textContent = (acao == 'entrar') ? 'Email ou senha inválidos' : 'Email inválido';
    erroLogin.style.display = 'inline-block';
}

function enviarDados(usuario) {
    var XHR = new XMLHttpRequest();
    var FD  = new FormData();
    FD.append('email', usuario.email);
    if(usuario.acao == 'entrar'){
        FD.append('senha', usuario.senha);
    }

    XHR.addEventListener('load', function(event) {
      erroLogin.style.display = 'none';
      sucessoRecuperar.style.display = 'none';
      var resposta = JSON.parse(XHR.responseText);
      if(usuario.acao == 'entrar'){
        if(resposta.sucesso){
            window.location.href = base_url + 'dashboard';
        }else{
            exibirErro('entrar');
        }
      }else{
        if(resposta.sucesso){
            sucessoRecuperar.style.display = 'inline-block';
            sucessoRecuperar.textContent = 'Enviado com sucesso!';
        }else{
            exibirErro('recuperar');
        }
      }
    });

    XHR.addEventListener('error', function(event) {
    //   alert('Oops! Something went wrong.');
    });

    XHR.open('POST', base_url + 'login/' + usuario.acao);
    XHR.send(FD);
}
