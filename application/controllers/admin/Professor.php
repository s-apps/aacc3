<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Professor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }else{
            if(! USUARIO_NIVEL == 0){
                redirect('dashboard');
            }
        }
        $this->load->model('mod_usuario');
        $this->load->model('mod_curso');
    }

    public function index(){
        $this->load->view('admin/professor');
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $data['cursos'] = $this->mod_curso->getAll();
        $this->load->view('admin/formulario-professor', $data);
    }
}