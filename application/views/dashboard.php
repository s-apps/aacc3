{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}
  
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/js/aacc/dashboard.js"></script>
{% endblock %}