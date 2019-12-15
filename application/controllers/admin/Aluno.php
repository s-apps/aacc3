<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends CI_Controller {

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
        $this->load->view('admin/aluno');
    }

    public function lista(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_usuario->lista(1, $limit, $offset, $sort, $order, $search, true);
        $usuarios = $this->mod_usuario->lista(1, $limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'usuarios' => $usuarios);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionando';
        $data['cursos'] = $this->mod_curso->getAll();
        $this->load->view('admin/formulario-aluno', $data);
    }

    public function editar($usuario_id){
        $data['acao'] = 'editando';
        $data['cursos'] = $this->mod_curso->getAll();
        $data['usuario'] = $this->mod_usuario->getUsuarioById($usuario_id);
        $this->load->view('admin/formulario-aluno', $data);
    }

    public function excluir(){
        $usuario_ids = $this->input->post('usuario_ids');
        $data['sucesso'] = $this->mod_usuario->excluir($usuario_ids);
        echo json_encode($data);
    }

    public function salvar(){
        $usuario = array(
            'acao' => $this->input->post('acao'),
            'nome' => $this->input->post('nome'),
            'usuario_id' => $this->input->post('usuario_id'),
            'usuario_ra' => $this->input->post('usuario_ra'),
            'email' => $this->input->post('email'),
            'senha' => $this->input->post('senha'),
            'curso_id' => $this->input->post('curso_id'),
            'nivel' => 1
        );
        $data['erro'] = $this->mod_usuario->salvar($usuario);
        echo json_encode($data);
    }

    public function horasRealizadas(){
        $data['usuarios'] = $this->mod_usuario->getAllUsuariosByNivel(1);
        $this->load->view('admin/horas-realizadas-aluno', $data);
    }

}