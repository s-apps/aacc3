var btnEntrarLoading = document.querySelector('.btn-login-loading');
var frmLogin = document.querySelector('#frmLogin');
var alerta = document.querySelector('.alert');
var btnButton = document.querySelector('button[type=button]');
var btnSubmit = document.querySelector('button[type=submit]');
var inputAcao = document.querySelector('#acao');

window.addEventListener('load', function(){
    desligarLoading();
    limparErros();
});

btnButton.addEventListener('click', function(event){
    event.preventDefault();
    limparErros();
    var acao = this.getAttribute('data-acao');
    if(acao == 'recuperar'){
        this.textContent = 'Cancelar';
        frmLogin.children[2].style.display = 'none';
        this.setAttribute('data-acao', 'cancelar');
        btnSubmit.textContent = 'Enviar senha';
        var small = document.createElement('small');
        small.classList.add('form-text', 'text-muted');
        small.textContent = 'Informe o Email cadastrado no sistema.';
        frmLogin.children[1].firstElementChild.insertAdjacentElement('afterend', small);
        inputAcao.value = 'recuperar';
    }else{
        this.textContent = 'Esqueceu a senha?';
        frmLogin.children[2].style.display = 'block';
        this.setAttribute('data-acao', 'recuperar');
        btnSubmit.textContent = 'Entrar';
        frmLogin.children[1].firstElementChild.nextElementSibling.remove();
        inputAcao.value = 'login';
    }
    frmLogin.children[1].firstElementChild.focus();
});

frmLogin.addEventListener('submit', function(event){
    event.preventDefault();
    ligarLoading();
    limparErros();
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

function limparErros(){
    alerta.style.display = 'none';
}

function camposValidos(usuario){
    var regexEmail = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/;
    if(usuario.acao == 'login'){
        return (usuario.senha.length > 0 && regexEmail.test(usuario.email));
    }else{
        return (regexEmail.test(usuario.email));
    }
}

function exibirErro(acao){
    alerta.textContent = (acao == 'login') ? 'Email ou Senha inválidos' : 'Email inválido';
    alerta.style.display = 'inline-block';
    desligarLoading();
}

function desligarLoading(){
    btnEntrarLoading.style.display = 'none';
}

function ligarLoading(){
    btnEntrarLoading.style.display = 'inline-block';
}

function enviarDados(usuario) {
    var XHR = new XMLHttpRequest();
    var FD  = new FormData();
    FD.append('email', usuario.email);
    if(usuario.acao == 'login'){
        FD.append('senha', usuario.senha);
    }
    // Define what happens on successful data submission
    XHR.addEventListener('load', function(event) {
    //   alert('Yeah! Data sent and response loaded.');
      var resposta = JSON.parse(XHR.responseText);
      if(resposta.sucesso){
          window.location.href = base_url + 'dashboard';
      }else{
          desligarLoading();
          exibirErro();
      }
    });
    // Define what happens in case of error
    XHR.addEventListener('error', function(event) {
    //   alert('Oops! Something went wrong.');
    });
    // Set up our request
    if(usuario.acao == 'login'){
        XHR.open('POST', base_url + 'login/entrar');
    }else{
        XHR.open('POST', base_url + 'login/recuperar');
    }
    // Send our FormData object; HTTP headers are set automatically
    XHR.send(FD);
}
