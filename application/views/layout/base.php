{% if constant('BASEPATH') is defined %}
<!doctype html>
<html lang="pt-br" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Language" content="pt-br">
    <title>AACC {% block title %}{% endblock %}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ constant('BASE_URL') }}assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ constant('BASE_URL') }}assets/img/favicon-16x16.png">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/js/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/css/fontawesome/all.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/js/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/js/select2/css/select2-bootstrap.min.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/js/tempusdominus/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/js/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="{{ constant('BASE_URL') }}assets/css/custom.css">
  </head>
  <body class="d-flex flex-column h-100">
    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        {% if not constant('USUARIO_LOGADO') == true %}
        <div class="container d-flex justify-content-center"> 
          <span class="navbar-text">AACC - Atividades Acadêmico-Científico-Culturais</span>
        </div>
        {% else %}
        <div class="container">
            {% include 'layout/navbar.php' %}
        </div>
        {% endif %}
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="flex-shrink-0">
      <div class="container">
        {% block content %}{% endblock %}
      </div>
    </main>

    <footer class="footer mt-auto py-3">
      <div class="container d-flex justify-content-center">
        <span class="text-muted">AACC</span>
      </div>
    </footer>
    
    {% block scripts %}
      <script src="{{ constant('BASE_URL') }}assets/js/jquery-3.4.1.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/bootstrap/popper.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/bootstrap/bootstrap.min.js"></script>   
      <script src="{{ constant('BASE_URL') }}assets/js/select2/js/select2.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/bootstrap-table/bootstrap-table.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/bootstrap-table/locale/bootstrap-table-pt-BR.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/table-export/tableExport.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/moment/moment.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/moment/locale/pt-br.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/izitoast/js/iziToast.min.js"></script>
      <script src="{{ constant('BASE_URL') }}assets/js/aacc/comum.js"></script>	
    {% endblock %}

  </body>
</html>
{% endif %}
