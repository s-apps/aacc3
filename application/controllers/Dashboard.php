<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(! USUARIO_LOGADO){
			redirect('login');
		}
		$this->load->helper('formata_data');
		$this->load->model('mod_dashboard');
	}

	public function index(){
		if(USUARIO_NIVEL == 0){
			$data['limite_atividades'] = $this->mod_dashboard->getLimiteAtividades();
		}else{
			//get horas realizadas
			//get horas a realizar
			//get limite de horas total a cumprir
			//get quantidade de atividades aguardando validação
			$data = array();
		}
		$this->load->view('dashboard', $data);
	}

	public function getAvisos(){
		$limit = $this->input->get('limit');
		$offset = $this->input->get('offset');
		$sort = $this->input->get('sort');
		$order = $this->input->get('order');
		$search = $this->input->get('search');
		$total = $this->mod_dashboard->getAvisos($limit, $offset, $sort, $order, $search, true);
		$avisos = $this->mod_dashboard->getAvisos($limit, $offset, $sort, $order, $search);
		$data = array('total' => $total, 'avisos' => $avisos);
		echo json_encode($data);
	}

	public function salvarAviso(){
		if(!USUARIO_NIVEL == 0){
			$data['erro'] = 'Acesso negado';
		}else{
			$aviso = [
				'aviso_id' => $this->input->post('aviso_id'),
				'data' => viewParaMysql($this->input->post('data_aviso')),
				'titulo' => $this->input->post('titulo'),
				'aviso' => $this->input->post('aviso'),
				'acao' => $this->input->post('acao')
			];
			$data['erro'] = $this->mod_dashboard->salvarAviso($aviso);
		}
		echo json_encode($data);
	}

	public function getAvisoById($aviso_id){
		$data['aviso'] = $this->mod_dashboard->getAvisoById($aviso_id);
		$data['aviso']['data'] = mysqlParaView($data['aviso']['data']);
		echo json_encode($data);
	}

	public function atualizarLimiteAtividades(){
		if(!USUARIO_NIVEL == 0){
			$data['erro'] = 'Acesso negado';
		}else{
			$limite_atividades = $this->input->post('limite_atividades');
			$data['erro'] = $this->mod_dashboard->atualizarLimiteAtividades($limite_atividades);
		}
		echo json_encode($data);
	}

	public function excluirAviso(){
		$aviso_ids = $this->input->post('aviso_ids');
		$data['sucesso'] = $this->mod_dashboard->excluir($aviso_ids);
		echo json_encode($data);
	}

}
