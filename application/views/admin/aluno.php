{% extends 'layout/base.php' %}
{% block title %}Alunos{% endblock %}

{% block content %}
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><i class="fas fa-graduation-cap"></i> Alunos <small>{{ acao }}</small></h5>
    <hr>
    <div id="toolbar">
	    <button class="btn btn-secondary btn-sm" id="btn-adicionar"><i class="fas fa-plus-circle"></i> Adicionar</button>
      <button class="btn btn-secondary btn-sm" id="btn-editar"><i class="fas fa-edit"></i> Editar</button>
      <button class="btn btn-danger btn-sm" id="btn-excluir"><i class="fas fa-minus-circle"></i> Excluir</button>        
    </div>
    <table id="lista-alunos"></table>
  </div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/alunos.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
{% endblock %}