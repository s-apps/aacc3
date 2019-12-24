{% extends 'layout/base.php' %}
{% block title %}Login{% endblock %}

{% block content %}
<div class="card login shadow-sm p-1 mb-5 bg-white">
    <div class="card-body">
      <div class="alert alert-danger w-100 pt-1 pb-1 text-center erro-login" role="alert"></div>
        <form id="frmLogin" name="frmLogin">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Email" autofocus>
            </div>
            <div class="form-group">
              <input type="password" class="form-control form-control-sm" id="senha" name="senha" placeholder="Senha">
            </div>
            <button type="submit" class="btn btn-dark btn-sm">Entrar
              <span class="spinner-border spinner-border-sm btn-login-loading"></span>
            </button>
            <button type="button" class="btn btn-link btn-sm" id="esqueceuSenha">Esqueceu a senha?</button>
        </form>
    </div>
</div>  
{% endblock %}

{% block scripts %}
  {{ parent() }}
    <script src="{{ constant('BASE_URL') }}assets/js/aacc/login.js"></script>
    <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
{% endblock %}