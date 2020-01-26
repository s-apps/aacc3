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
                    <textarea class="form-control" id="comprovante" name="comprovante" rows="3" autofocus>{% if acao == 'editando' and comprovante.comprovante is defined %}{{ comprovante.comprovante }}{% endif %}</textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm" id="btn-salvar"><i class="fas fa-save"></i> Salvar</button>
            <button type="button" class="btn btn-secondary btn-sm" id="btn-cancelar"><i class="fas fa-undo"></i> Cancelar</button>
        </div>
    </form>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-comprovante.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
{% endblock %}