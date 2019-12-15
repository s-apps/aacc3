{% extends 'layout/base.php' %}
{% block title %}Comprovantes{% endblock %}

{% block content %}
<div class="card">
    <form id="frmComprovante" name="frmComprovante" method="POST">
    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
    <input type="hidden" id="comprovante_id" name="comprovante_id" value="{% if comprovante.comprovante_id is defined %}{{ comprovante.comprovante_id }}{% endif %}">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-certificate"></i> Comprovantes <small>{{ acao }}</small></h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="comprovante">Comprovante</label>
                    <input type="text" class="form-control form-control-sm" id="comprovante" name="comprovante" autofocus value="{% if acao == 'editando' and comprovante.comprovante is defined %}{{ comprovante.comprovante }}{% endif %}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar</button>
            <a href="{{ constant('BASE_URL') }}admin/comprovante" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Cancelar</a>
        </div>
    </form>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-comprovante.js"></script>
{% endblock %}