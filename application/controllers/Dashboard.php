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
	//$data['avisos'] = $this->mod_dashboard->getAvisos();
	if(USUARIO_NIVEL == 0){
		$data['limite_atividades'] = $this->mod_dashboard->getLimiteAtividades();
	}else{
	      	//get horas realizadas
		//get horas a realizar
		//get limite de horas total a cumprir
		//get quantidade de atividades aguardando validação
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
        $aviso = [
            'data' => viewParaMysql($this->input->post('data_aviso')),
            'titulo' => $this->input->post('titulo'),
            'aviso' => $this->input->post('aviso')
        ];
        $data['erro'] = $this->mod_dashboard->salvarAviso($aviso);
        echo json_encode($data);
    }

}
