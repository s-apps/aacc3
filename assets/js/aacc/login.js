var btnEntrarLoading = document.querySelector('.btn-login-loading');
var frmLogin = document.querySelector('#frmLogin');
var alerta = document.querySelector('.alert');

window.addEventListener('load', function(){
    frmLogin.email.focus();
    desligarLoading();
    limparErros();
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
    return (usuario.email.length > 0 && usuario.senha.length > 0);
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
          window.location.href = 'http://localhost:8000/dashboard';
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
    XHR.open('POST', 'http://localhost:8000/login/entrar');
    // Send our FormData object; HTTP headers are set automatically
    XHR.send(FD);
}

