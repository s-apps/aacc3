<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }else{
            if(! USUARIO_NIVEL == 0){
                redirect('dashboard');
            }
        }
        $this->load->model('mod_curso');
    }

    public function index(){
        $this->load->view('admin/curso');
    }

    public function lista(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_curso->lista($limit, $offset, $sort, $order, $search, true);
        $cursos = $this->mod_curso->lista($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'cursos' => $cursos);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $this->load->view('admin/formulario-curso', $data);
    }

    public function salvar(){
        $acao = $this->input->post('acao');
        $curso = $this->input->post('curso');
        $curso_id = $this->input->post('curso_id');
        $data['erro'] = $this->mod_curso->salvar($acao, $curso, $curso_id);
        echo json_encode($data);
    }

    public function editar($curso_id){
        $data['acao'] = 'editando';
        $data['curso'] = $this->mod_curso->getById($curso_id);
        $this->load->view('admin/formulario-curso', $data);
    }

    public function excluir(){
        $curso_ids = $this->input->post('curso_ids');
        $data['sucesso'] = $this->mod_curso->excluir($curso_ids);
        echo json_encode($data);
    }


}