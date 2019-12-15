{% extends 'layout/base.php' %}
{% block title %}Cursos{% endblock %}

{% block content %}
<div class="card">
    <form id="frmCurso" name="frmCurso" method="POST">
    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
    <input type="hidden" id="curso_id" name="curso_id" value="{% if curso.curso_id is defined %}{{ curso.curso_id }}{% endif %}">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-university"></i> Cursos <small>{{ acao }}</small></h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="curso">Curso</label>
                    <input type="text" class="form-control form-control-sm" id="curso" name="curso" autofocus value="{% if acao == 'editando' and curso.curso is defined %}{{ curso.curso }}{% endif %}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar</button>
            <a href="{{ constant('BASE_URL') }}admin/curso" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Cancelar</a>
        </div>
    </form>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-curso.js"></script>
{% endblock %}