{% extends 'layout/base.php' %}
{% block title %}Atividades{% endblock %}

{% block content %}
<div class="card">
    <form id="frmAtividade" name="frmAtividade" enctype="multipart/form-data" method="POST">
    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
    <input type="hidden" id="atividade_id" name="atividade_id" value="{% if atividade.atividade_id is defined %}{{ atividade.atividade_id }}{% endif %}">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-cubes"></i> Atividades <small>{{ acao }}</small></h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="data_atividade">Data</label>
                    <div class="input-group date" id="dataatividade" data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm datetimepicker-input" data-target="#dataatividade" id="data_atividade" name="data_atividade" value="{% if acao == 'editando' and atividade.data is defined %}{{ atividade.data }}{% endif %}"/>
                        <div class="input-group-append" data-target="#dataatividade" data-toggle="datetimepicker">
                            <div class="input-group-text bg-secondary text-white border border-secondary"><i class="fa fa-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="horas_inicio">Horas início</label>
                    <div class="input-group date" id="horasinicio" data-target-input="nearest">
                        <input type="text" id="horas_inicio" name="horas_inicio" class="form-control form-control-sm datetimepicker-input" data-target="#horasinicio" value="{% if acao == 'editando' and atividade.horas_inicio is defined %}{{ atividade.horas_inicio }}{% endif %}"/>
                        <div class="input-group-append" data-target="#horasinicio" data-toggle="datetimepicker">
                            <div class="input-group-text bg-secondary text-white border border-secondary"><i class="far fa-clock"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="horas_termino">Horas término</label>
                    <div class="input-group date" id="horastermino" data-target-input="nearest">
                        <input type="text" id="horas_termino" name="horas_termino" class="form-control form-control-sm datetimepicker-input" data-target="#horastermino" value="{% if acao == 'editando' and atividade.horas_termino is defined %}{{ atividade.horas_termino }}{% endif %}"/>
                        <div class="input-group-append" data-target="#horastermino" data-toggle="datetimepicker">
                            <div class="input-group-text bg-secondary text-white border border-secondary"><i class="far fa-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="usuario_id">Aluno</label>
                    <select id="usuario_id" name="usuario_id" class="form-control">
                        {% if constant('USUARIO_NIVEL') == 0 %}
                        <option></option>
                        {% for usuario in usuarios %}
                        {% set selected = ''%}
                        {% if usuario.usuario_id == atividade.usuario_id and usuario.usuario_id is defined and acao == 'editando' %}
                        {% set selected = ' selected="selected"' %}
                        {% endif %}
                        <option value="{{ usuario.usuario_id }}"{{ selected }}>{{ usuario.usuario_ra }} | {{ usuario.nome }} | {{ usuario.email }}</option>
                        {% endfor %}
                        {% else %}
                        <option value="{{ constant('USUARIO_ID') }}">{{ constant('USUARIO_NOME') }}</option>
                        {% endif %}
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="atividade">Atividade</label>
                    <textarea id="atividade" name="atividade" class="form-control" rows="3">{% if acao == 'editando' and atividade.atividade is defined %}{{ atividade.atividade }}{% endif %}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="categoria_id">Categoria</label>
                    <select id="categoria_id" name="categoria_id" class="form-control">
                        <option></option>
                        {% for categoria in categorias %}
                        {% set selected = ''%}
                        {% if categoria.categoria_id == atividade.categoria_id and atividade.categoria_id is defined and acao == 'editando' %}
                        {% set selected = ' selected="selected"' %}
                        {% endif %}
                        <option value="{{ categoria.categoria_id }}"{{ selected }}>{{ categoria.categoria }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="modalidade_id">Modalidade</label>
                    <select id="modalidade_id" name="modalidade_id" class="form-control">
                        <option></option>
                        {% if acao == 'editando' and modalidade.modalidade_id is defined %}
                        <option value="{{ modalidade.modalidade_id }}" selected="selected">{{ modalidade.modalidade }}</option>
                        {% endif %}
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="comprovante_id">Comprovante</label>
                    <select id="comprovante_id" name="comprovante_id" class="form-control">
                        <option></option>
                        {% if acao == 'editando' and comprovante.comprovante_id is defined %}
                        <option value="{{ comprovante.comprovante_id }}" selected="selected">{{ comprovante.comprovante }}</option>
                        {% endif %}
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="imagem_comprovante">Imagem do comprovante</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagem_comprovante" name="imagem_comprovante">
                            <label class="custom-file-label" for="imagem_comprovante" data-browse="{% if acao == 'editando' %}Alterar{% else %}Procurar{% endif %}">{% if acao == 'editando' and atividade.imagem_comprovante is defined %}{{ atividade.imagem_comprovante }}{% else %}Imagem do comprovante{% endif %}</label>
                        </div>
                        {% if acao == 'editando' %}
                        <div class="input-group-append">
		                    <button class="btn btn-primary btn-sm" type="button" id="btn-visualizar-imagem" data-toggle="modal" data-target="#midia">Visualizar</button>
		                </div>
                        {% endif %}
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="validacao">Validação</label>
                    <select class="custom-select custom-select-sm" id="validacao" name="validacao">
                        <option value="0"{% if atividade.validacao == 0 and acao == 'editando' %} selected="selected"{% endif %}>Aguardando validação</option>
                        <option value="1"{% if atividade.validacao == 1 and acao == 'editando' %} selected="selected"{% endif %}>Válido</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar</button>
            <a href="{{ constant('BASE_URL') }}atividade" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Cancelar</a>
        </div>
    </form>
</div>
<div class="modal" tabindex="-1" role="dialog" id="midia">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
        	    <h5 class="modal-title">Imagem do comprovante</h5>
        	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	        <span aria-hidden="true">&times;</span>
        	    </button>
	        </div>
	        <div class="modal-body">
                <!-- {{ atividade.imagem_comprovante |split('.')|last }} -->
                {% if acao == 'editando' %}
                <iframe src="{{ constant('BASE_URL') }}assets/img/comprovantes/{{ atividade.imagem_comprovante }}" style="width:100%; height:auto; border:0;"></iframe>
                {% endif %}
	        </div>
	        <div class="modal-footer">
        	    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
	        </div>
	    </div>
	</div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/formulario-atividade.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>
{% endblock %}
