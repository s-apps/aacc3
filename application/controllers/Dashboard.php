<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(! USUARIO_LOGADO){
            redirect('login');
        }
	$this->load->model('mod_dashboard');
    }    

    public function index(){
	$data['avisos'] = $this->mod_dashboard->getAvisos();
	if(USUARIO_NIVEL == 0){
		// get horas realizadas
		// get horas a realizar
		// get limite de horas total a cumprir
		// get quantidade de atividades aguardando validação
	}else{
	
	}
        $this->load->view('dashboard');
    }

}
