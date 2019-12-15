{% extends 'layout/base.php' %}
{% block title %}Professores{% endblock %}

{% block content %}
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><i class="fas fa-users"></i> Professores <small>{{ acao }}</small></h5>
    <hr>
    <div id="toolbar">
	    <a class="btn btn-secondary btn-sm" href="{{ constant('BASE_URL') }}admin/professor/adicionar">
        <i class="fas fa-plus-circle"></i> Adicionar
      </a>
      <button class="btn btn-secondary btn-sm" id="btn-editar"><i class="fas fa-edit"></i> Editar</button>
      <button class="btn btn-danger btn-sm" id="btn-excluir"><i class="fas fa-minus-circle"></i> Excluir</button>        
    </div>
    <table id="lista-professores"></table>
  </div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/professores.js"></script>
{% endblock %}