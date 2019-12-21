{% extends 'layout/base.php' %}
{% block title %}Aluno - Horas realizadas{% endblock %}

{% block content %}
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><i class="fas fa-clock"></i> Aluno - Horas realizadas</h5>
    <hr>
    <div class="row">
        <div class="col-6">
            <label for="usuario_ra">Aluno</label>
                <select id="usuario_id" name="usuario_id" class="form-control">
                    <option></option>
                    {% for usuario in usuarios %}
                    <option value="{{ usuario.usuario_id }}">{{ usuario.usuario_ra }} | {{ usuario.nome }} | {{ usuario.email }}</option>
                    {% endfor %}
                </select>    
        </div>
    </div>    
  </div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/aluno-horas-realizadas.js"></script>
{% endblock %}