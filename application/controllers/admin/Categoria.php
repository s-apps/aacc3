<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }else{
            if(! USUARIO_NIVEL == 0){
                redirect('dashboard');
            }
        }
        $this->load->model('mod_categoria');
    }

    public function index(){
        $this->load->view('admin/categoria');
    }

    public function lista(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_categoria->lista($limit, $offset, $sort, $order, $search, true);
        $categorias = $this->mod_categoria->lista($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'categorias' => $categorias);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $this->load->view('admin/formulario-categoria', $data);
    }

    public function salvar(){
        $acao = $this->input->post('acao');
        $categoria = $this->input->post('categoria');
        $categoria_id = $this->input->post('categoria_id');
        $data['erro'] = $this->mod_categoria->salvar($acao, $categoria, $categoria_id);
        echo json_encode($data);
    }

    public function editar($categoria_id){
        $data['acao'] = 'editando';
        $data['categoria'] = $this->mod_categoria->getById($categoria_id);
        $this->load->view('admin/formulario-categoria', $data);
    }

    public function excluir(){
        $categoria_ids = $this->input->post('categoria_ids');
        $data['sucesso'] = $this->mod_categoria->excluir($categoria_ids);
        echo json_encode($data);
    }


}