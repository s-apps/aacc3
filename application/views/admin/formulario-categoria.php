{% extends 'layout/base.php' %}
{% block title %}Categorias{% endblock %}

{% block content %}
<div class="card">
    <form id="frmCategoria" name="frmCategoria" method="POST">
    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
    <input type="hidden" id="categoria_id" name="categoria_id" value="{% if categoria.categoria_id is defined %}{{ categoria.categoria_id }}{% endif %}">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-th-large"></i> Categorias <small>{{ acao }}</small></h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="categoria">Categoria</label>
                    <input type="text" class="form-control form-control-sm" id="categoria" name="categoria" autofocus value="{% if acao == 'editando' and categoria.categoria is defined %}{{ categoria.categoria }}{% endif %}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar</button>
            <a href="{{ constant('BASE_URL') }}admin/categoria" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Cancelar</a>
        </div>
    </form>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-categoria.js"></script>
{% endblock %}