{% extends 'layout/base.php' %}
{% block title %}Login{% endblock %}

{% block content %}
<div class="card login shadow-sm p-1 mb-5 bg-white" id="form-login">
    <div class="card-body">
      <div class="alert alert-danger w-100 pt-1 pb-1 text-center erro-login" role="alert"></div>
        <form id="frmRecuperarSenha" name="frmRecuperarSenha">
            <div class="form-group">
              <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control form-control-sm" id="senha" name="senha" placeholder="Senha">
              <small class="form-text text-muted">Informe a senha enviada para seu Email.</small>
            </div>
            <button type="submit" class="btn btn-dark btn-sm">Recuperar</button>
            <a href="{{ constant('BASE_URL') }}login" class="btn btn-link btn-sm">Cancelar</a>
        </form>
    </div>
</div>  
{% endblock %}

{% block scripts %}
  {{ parent() }}
    <script src="{{ constant('BASE_URL') }}assets/js/aacc/login-recuperar.js"></script>
    <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
{% endblock %}