<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprovante extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }else{
            if(! USUARIO_NIVEL == 0){
                redirect('dashboard');
            }
        }
        $this->load->model('mod_comprovante');
    }

    public function index(){
        $this->load->view('admin/comprovante');
    }

    public function lista(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_comprovante->lista($limit, $offset, $sort, $order, $search, true);
        $comprovantes = $this->mod_comprovante->lista($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'comprovantes' => $comprovantes);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $this->load->view('admin/formulario-comprovante', $data);
    }

    public function salvar(){
        $acao = $this->input->post('acao');
        $comprovante = $this->input->post('comprovante');
        $comprovante_id = $this->input->post('comprovante_id');
        $data['erro'] = $this->mod_comprovante->salvar($acao, $comprovante, $comprovante_id);
        echo json_encode($data);
    }

    public function editar($comprovante_id){
        $data['acao'] = 'editando';
        $data['comprovante'] = $this->mod_comprovante->getById($comprovante_id);
        $this->load->view('admin/formulario-comprovante', $data);
    }

    public function excluir(){
        $comprovante_ids = $this->input->post('comprovante_ids');
        $data['sucesso'] = $this->mod_comprovante->excluir($comprovante_ids);
        echo json_encode($data);
    }


}