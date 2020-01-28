{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}

<div class="card">
  <div class="card-body">
    <h5 class="card-title"><i class="fas fa-home"></i> Dashboard</h5>
    <hr>
    {% if constant('USUARIO_NIVEL') == 0 %}
    <div class="card">
        <div class="card-header p-2">Configurações</div>
        <div class="card-body p-2">
          <form class="form-inline" id="frmLimite" name="frmLimite">
            <label for="limite_atividades" class="my-1 mr-2">Limite de horas das atividades</label>
            <input type="text" class="form-control form-control-sm text-center" id="limite_atividades" name="limite_atividades" style="width:5rem;" value="{{ limite_atividades }}">
            <button type="submit" class="btn btn-secondary btn-sm ml-2"><i class="fas fa-save"></i> Salvar</button>
          </form>
        </div>
    </div>     
    {% endif %}

    {% if constant('USUARIO_NIVEL') == 1 %}
    <div class="card-deck">
  <div class="card border-dark">
    <div class="card-body bg-secondary text-white">
      <h3 class="card-title">1:30</h3>
      <p class="card-text">Total em horas das atividades válidas.</p>
    </div>
  </div>
  <div class="card border-dark">
    <div class="card-body bg-secondary text-white">
      <h3 class="card-title">2:30</h3>
      <p class="card-text">Restante de horas a cumprir</p>
    </div>
  </div>
  <div class="card border-dark">
    <div class="card-body bg-secondary text-white">
      <h3 class="card-title">6</h3>
      <p class="card-text">Total de atividades aguardando validação.</p>
    </div>
  </div>
  <div class="card border-dark">
    <div class="card-body bg-secondary text-white">
      <h3 class="card-title">40</h3>
      <p class="card-text">Limite total em horas das atividades.</p>
    </div>
  </div>
</div>    
    {% endif %}
    
    <div class="card border-dark mt-3">
        <div class="card-header p-2 bg-dark text-white">Avisos</div>
        <div class="card-body p-3">
          {% if constant('USUARIO_NIVEL') == 0 %}
          <div id="toolbar">
	          <button class="btn btn-secondary btn-sm" id="btn-adicionar"><i class="fas fa-plus-circle"></i> Adicionar</button>
            <button class="btn btn-secondary btn-sm" id="btn-editar" data-toggle="modal"><i class="fas fa-edit"></i> Editar</button>
            <button class="btn btn-danger btn-sm" id="btn-excluir"><i class="fas fa-minus-circle"></i> Excluir</button>        
          </div>   
          {% endif %}
          <table id="lista-avisos"></table>
        </div>
    </div>     
  </div>
</div>

{% if constant('USUARIO_NIVEL') == 0 %}
<!-- Modal -->
<div class="modal fade" id="formulario-avisos" tabindex="-1" role="dialog" aria-labelledby="avisosLabel" aria-hidden="true">
  <form id="formulario-avisos" name="formulario-avisos" method="POST">
    <input type="hidden" id="acao" name="acao" value="">
    <input type="hidden" id="aviso_id" name="aviso_id" value="">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="avisosLabel">Avisos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="data_aviso">Data</label>
              <div class="input-group date" id="datetimepicker-data_aviso" data-target-input="nearest">
                <input type="text" class="form-control form-control-sm datetimepicker-input" id="data_aviso" data-target="#datetimepicker-data_aviso"/>
                <div class="input-group-append" data-target="#datetimepicker-data_aviso" data-toggle="datetimepicker">
                  <div class="input-group-text bg-secondary text-white border border-secondary"><i class="far fa-calendar-alt"></i></div>
                </div>
              </div>
          </div>
          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Informe o título" value="">
          </div>
          <div class="form-group">
            <label for="aviso">Aviso</label>
            <textarea class="form-control form-control-sm" rows="3" placeholder="Informe o aviso" id="aviso" name="aviso"></textarea>
          </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-secondary btn-sm" id="btn-salvar"><i class="fas fa-save"></i> Salvar</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i> Cancelar</button>
      </div>
    </div>
  </div>
</form>
</div>
{% endif %}
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/dashboard.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
{% endblock %}
