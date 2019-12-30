<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Constantes {

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('sessao_usuario');
		define('USUARIO_LOGADO', usuarioLogado());
		define('BASE_URL', base_url());
		define('USUARIO_NIVEL', getUsuarioNivel());
    define('USUARIO_ID', getUsuarioId());
        define('USUARIO_NOME', getUsuarioNome());
    }
}
