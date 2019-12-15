{% extends 'layout/base.php' %}
{% block title %}Professores{% endblock %}

{% block content %}
<div class="card">
    <form id="frmProfessor" name="frmProfessor" method="POST">
    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
    <input type="hidden" id="usuario_id" name="usuario_id" value="{% if usuario.usuario_id is defined %}{{ usuario.usuario_id }}{% endif %}">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-users"></i> Professores <small>{{ acao }}</small></h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome">Nome completo</label>
                    <input type="text" class="form-control form-control-sm" id="nome" name="nome" autofocus value="{% if acao == 'editando' and usuario.nome is defined %}{{ usuario.nome }}{% endif %}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="text" class="form-control form-control-sm" id="email" name="email" value="{% if acao == 'editando' and usuario.email is defined %}{{ usuario.email }}{% endif %}">
                </div>
                <div class="form-group col-md-2">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control form-control-sm" id="senha" name="senha" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="curso_id">Cursos</label>
                    <select class="custom-select custom-select-sm" id="curso_id" name="curso_ids[]" multiple="multiple">
                        <option></option>
                        {% for curso in cursos %}
                        <option value="{{ curso.curso_id }}">{{ curso.curso }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar</button>
            <a href="{{ constant('BASE_URL') }}admin/professor" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Cancelar</a>
        </div>
    </form>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-professor.js"></script>
{% endblock %}