var btnEntrarLoading = document.querySelector('.btn-login-loading');
var frmLogin = document.querySelector('#frmLogin');
var alerta = document.querySelector('.alert');
var btnButton = document.querySelector('button[type=button]');
var btnSubmit = document.querySelector('button[type=submit]');

window.addEventListener('load', function(){
    desligarLoading();
    limparErros();
});

btnButton.addEventListener('click', function(event){
    event.preventDefault();
    var acao = this.getAttribute('data-acao');
    if(acao == 'recuperar'){
        this.textContent = 'Cancelar';
        frmLogin.children[1].style.display = 'none';
        this.setAttribute('data-acao', 'cancelar');
        btnSubmit.textContent = 'Enviar nova senha';
        var small = document.createElement('small');
        small.classList.add('form-text', 'text-muted');
        small.textContent = 'Informe o Email cadastrado no sistema.';
        frmLogin.children[0].firstElementChild.insertAdjacentElement('afterend', small);
    }else{
        this.textContent = 'Esqueceu a senha?';
        frmLogin.children[1].style.display = 'block';
        this.setAttribute('data-acao', 'recuperar');
        btnSubmit.textContent = 'Entrar';
        frmLogin.children[0].firstElementChild.nextElementSibling.remove();
    }
    frmLogin.children[0].firstElementChild.focus();
});

frmLogin.addEventListener('submit', function(event){
    event.preventDefault();
    ligarLoading();
    limparErros();
    var usuario = {
        email: this.email.value,
        senha: this.senha.value
    }
    if(camposValidos(usuario)){
        enviarDados(usuario);
    }else{
        exibirErro();
    }
});

function limparErros(){
    alerta.style.display = 'none';
}

function camposValidos(usuario){
    var regexEmail = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/;
    return (usuario.email.length > 0 && usuario.senha.length > 0 && regexEmail.test(usuario.email));
}

function exibirErro(){
    alerta.textContent = 'Email ou Senha inválidos';
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
    FD.append('senha', usuario.senha);
    // Define what happens on successful data submission
    XHR.addEventListener('load', function(event) {
    //   alert('Yeah! Data sent and response loaded.');
      var resposta = JSON.parse(XHR.responseText);
      console.log(resposta);
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
    XHR.open('POST', base_url + 'login/entrar');
    // Send our FormData object; HTTP headers are set automatically
    XHR.send(FD);
}
