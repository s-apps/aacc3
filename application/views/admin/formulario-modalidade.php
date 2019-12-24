{% extends 'layout/base.php' %}
{% block title %}Modalidades{% endblock %}

{% block content %}
<div class="card">
    <form id="frmModalidade" name="frmModalidade" method="POST">
    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
    <input type="hidden" id="modalidade_id" name="modalidade_id" value="{% if modalidade.modalidade_id is defined %}{{ modalidade.modalidade_id }}{% endif %}">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-th"></i> Modalidades <small>{{ acao }}</small></h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="modalidade">Modalidade</label>
                    <textarea id="modalidade" name="modalidade" class="form-control" rows="3">{% if acao == 'editando' and modalidade.modalidade is defined %}{{ modalidade.modalidade }}{% endif %}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="min_horas">Mínimo de horas (duração)</label>
                    <div class="input-group date" id="minhoras" data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm datetimepicker-input" id="min_horas" name="min_horas" data-target="#minhoras" value="{% if acao == 'editando' and modalidade.min_horas is defined%}{{ modalidade.min_horas }}{% endif %}"/>
                        <div class="input-group-append" data-target="#minhoras" data-toggle="datetimepicker">
                            <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-clock"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="max_horas">Máximo de horas (limite)</label>
                    <div class="input-group date" id="maxhoras" data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm datetimepicker-input" id="max_horas" name="max_horas" data-target="#maxhoras" value="{% if acao == 'editando' and modalidade.max_horas is defined%}{{ modalidade.max_horas }}{% endif %}"/>
                        <div class="input-group-append" data-target="#maxhoras" data-toggle="datetimepicker">
                            <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="categoria_id">Categoria</label>
                    <select class="custom-select custom-select-sm" id="categoria_id" name="categoria_id">
                        <option></option>
                        {% for categoria in categorias %}
                        {% set selected = ''%}
                        {% if categoria.categoria_id == modalidade.categoria_id and modalidade.categoria_id is defined and acao == 'editando' %}
                        {% set selected = ' selected="selected"' %}
                        {% endif %}
                        <option value="{{ categoria.categoria_id }}"{{ selected }}>{{ categoria.categoria }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>     
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="comprovante_id">Comprovante</label>
                    <select class="custom-select custom-select-sm" id="comprovante_id" name="comprovante_id">
                        <option></option>
                        {% for comprovante in comprovantes %}
                        {% set selected = ''%}
                        {% if comprovante.comprovante_id == modalidade.comprovante_id and modalidade.comprovante_id is defined and acao == 'editando' %}
                        {% set selected = ' selected="selected"' %}
                        {% endif %}
                        <option value="{{ comprovante.comprovante_id }}"{{ selected }}>{{ comprovante.comprovante }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>     
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar</button>
            <a href="{{ constant('BASE_URL') }}admin/modalidade" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Cancelar</a>
        </div>
    </form>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-modalidade.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
{% endblock %}