<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }
        $this->load->model('mod_atividade');
        $this->load->model('mod_usuario');
        $this->load->model('mod_categoria');
        $this->load->model('mod_modalidade');
        $this->load->model('mod_comprovante');
        $this->load->helper('calcula_horas');
        $this->load->helper('formata_data');
    }

    public function index(){
        $data['acao'] = 'listando';
        $this->load->view('atividade', $data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $data['usuarios'] = $this->mod_usuario->getAllUsuariosByNivel(1);
        $data['categorias'] = $this->mod_categoria->getAll();
        $this->load->view('formulario-atividade', $data);
    }

    public function editar($atividade_id){
        $data['acao'] = 'editando';
        $data['atividade'] = $this->mod_atividade->getById($atividade_id);
        $data['usuarios'] = $this->mod_usuario->getAllUsuariosByNivel(1);
        $data['categorias'] = $this->mod_categoria->getAll();
        $data['modalidade'] = $this->mod_modalidade->getModalidadeByAtividade($atividade_id);
        $data['comprovante'] = $this->mod_comprovante->getComprovanteByAtividade($atividade_id);
        $this->load->view('formulario-atividade', $data);
    }

    public function lista(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_atividade->lista($limit, $offset, $sort, $order, $search, true);
        $atividades = $this->mod_atividade->lista($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'atividades' => $atividades);
        echo json_encode($data);
    }

    public function getModalidadesByCategoria(){
        $categoria_id = $this->input->get('categoria_id');
        $data['modalidades'] = $this->mod_modalidade->getModalidadesByCategoria($categoria_id);
        echo json_encode($data);
    }

    public function getComprovantesByModalidade(){
        $modalidade_id = $this->input->get('modalidade_id');
        $data['comprovantes'] = $this->mod_modalidade->getComprovantesByModalidade($modalidade_id);
        echo json_encode($data);
    }

    public function salvar(){
        $config['upload_path'] = './assets/img/comprovantes/';
        $config['allowed_types'] = 'jpg|png|pdf';
        $config['max_size'] = 1024;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['remove_spaces'] = true;
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        $atividade = array(
            'acao' => $this->input->post('acao'),
            'atividade_id' => $this->input->post('atividade_id'),
            'data' => viewParaMysql($this->input->post('data_atividade')),
            'horas_inicio' => $this->input->post('horas_inicio'),
            'horas_termino' => $this->input->post('horas_termino'),
            'usuario_id' => $this->input->post('usuario_id'),
            'atividade' => $this->input->post('atividade'),
            'validacao' => $this->input->post('validacao'),
            'categoria_id' => $this->input->post('categoria_id'),
            'modalidade_id' => $this->input->post('modalidade_id'),
            'comprovante_id' => $this->input->post('comprovante_id'),
            'validacao' => $this->input->post('validacao'),
            'imagem_comprovante' => $_FILES['imagem_comprovante']['name']
        );

        if($atividade['acao'] == 'adicionando'){
            if(!$this->upload->do_upload('imagem_comprovante')){
                $data['erro'] = $this->upload->display_errors();
            }else{
                $atividade['imagem_comprovante'] = $this->upload->data('file_name');
                $data['erro'] = $this->mod_atividade->salvar($atividade);
            }
        }else{
            if(empty($atividade['imagem_comprovante'])){
                unset($atividade['imagem_comprovante']);
                $data['erro'] = $this->mod_atividade->salvar($atividade);
            }else{
                if(!$this->upload->do_upload('imagem_comprovante')){
                    $data['erro'] = $this->upload->display_errors();
                }else{
                    $imagem_comprovante = $this->mod_atividade->getImagemComprovante($atividade['atividade_id']);
                    unlink('./assets/img/comprovantes/' . $imagem_comprovante);
                    $atividade['imagem_comprovante'] = $this->upload->data('file_name');
                    $data['erro'] = $this->mod_atividade->salvar($atividade);
                }
            }
        }
        echo json_encode($data);
    }

    public function excluir(){
        $atividade_ids = $this->input->post('atividade_ids');
        $data['sucesso'] = $this->mod_atividade->excluir($atividade_ids);
        echo json_encode($data);
    }
}
