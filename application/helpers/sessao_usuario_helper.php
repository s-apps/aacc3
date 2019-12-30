<?php

    function getUsuarioNivel(){
        $ci = get_instance();
        return $ci->session->userdata('nivel_usuario');
    }

    function getUsuarioNome(){
        $ci = get_instance();
        return $ci->session->userdata('nome_usuario');
    }

    function getUsuarioId(){
      $ci = get_instance();
      return $ci->session->userdata('usuario_id');
    }

    function usuarioLogado(){
        $ci = get_instance();
        return $ci->session->userdata('usuario_logado');
    }

    function setSessao($sessao){
        $ci = get_instance();
        $ci->session->set_userdata($sessao);
    }
