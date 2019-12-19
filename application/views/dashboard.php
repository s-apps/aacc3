{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}

{% if constant('USUARIO_NIVEL') == 0 %}
	<!-- exibir,adicionar,editar,excluir avisos -->
        <!-- exibir,editar limite de horas atividades -->
{% else %}
	<!-- exibir avisos -->
	<!-- aluno desabilitar botoes adicionar, editar e excluir dos avisos -->
        <!-- exibir horas realizadas, horas a realizar, limite de horas atividade, atividades aguardando validação -->
{% endif %}	

{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/dashboard.js"></script>
{% endblock %}
