{% extends 'layout/base.php' %}
{% block title %}Aluno - Horas realizadas{% endblock %}

{% block content %}
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><i class="fas fa-graduation-cap"></i> Aluno - Horas realizadas</h5>
    <hr>
  </div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/aluno-horas-realizadas.js"></script>
{% endblock %}