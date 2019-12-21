{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}

<div class="card">
  <div class="card-body">
    <h5 class="card-title"><i class="fas fa-home"></i> Dashboard</h5>
    <hr>
    <div class="card mt-3">
        <div class="card-header p-2">Avisos</div>
        <div class="card-body p-2">
        {% if constant('USUARIO_NIVEL') == 0 %}
                <div id="toolbar">
	                <button class="btn btn-secondary btn-sm" id="btn-adicionar-aviso"><i class="fas fa-plus-circle"></i> Adicionar</button>
                        <button class="btn btn-secondary btn-sm" id="btn-editar-aviso" data-toggle="modal"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger btn-sm" id="btn-excluir-aviso"><i class="fas fa-minus-circle"></i> Excluir</button>        
                </div>   
                {% endif %}
                <table id="lista-avisos"></table>
        </div>
    </div>     
  </div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/dashboard.js"></script>
{% endblock %}
