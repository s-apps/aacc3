<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modalidade extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }else{
            if(! USUARIO_NIVEL == 0){
                redirect('dashboard');
            }
        }
        $this->load->model('mod_modalidade');
        $this->load->model('mod_categoria');
        $this->load->model('mod_comprovante');
    }

    public function index(){
        $this->load->view('admin/modalidade');
    }

    public function lista(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_modalidade->lista($limit, $offset, $sort, $order, $search, true);
        $modalidades = $this->mod_modalidade->lista($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'modalidades' => $modalidades);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $data['categorias'] = $this->mod_categoria->getAll();
        $data['comprovantes'] = $this->mod_comprovante->getAll();
        $this->load->view('admin/formulario-modalidade', $data);
    }

    public function editar($modalidade_id){
        $data['acao'] = 'editando';
        $data['modalidade'] = $this->mod_modalidade->getById($modalidade_id);
        $data['categorias'] = $this->mod_categoria->getAll();
        $data['comprovantes'] = $this->mod_comprovante->getAll();
        $this->load->view('admin/formulario-modalidade', $data);
    }

    public function excluir(){
        $modalidade_ids = $this->input->post('modalidade_ids');
        $data['sucesso'] = $this->mod_modalidade->excluir($modalidade_ids);
        echo json_encode($data);
    }
    

}