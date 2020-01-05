<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(USUARIO_LOGADO){
			redirect('dashboard');
		}
		$this->load->model('mod_usuario');
	}

	public function index(){
		$this->load->view('login');
	}

	public function entrar(){
		$email = $this->input->post('email');
		$senha = $this->input->post('senha');
		$usuario = $this->mod_usuario->getUsuario($email, $senha);
		$data['sucesso'] = ($usuario) ? $this->setSessao($usuario) : false;
		echo json_encode($data);
	}

	private function setSessao($usuario){
        $sessao = array(
            'usuario_id' => $usuario['usuario_id'],
            'nome_usuario' => $usuario['nome'],
            'email_usuario' => $usuario['email'],
            'nivel_usuario' => $usuario['nivel'],
            'usuario_ra' => (! $usuario['usuario_ra'] == null ) ? $usuario['usuario_ra'] : null,
            'usuario_logado' => true
        );		        
		setSessao($sessao);
		return usuarioLogado();
	}

	public function recuperar(){
		$this->load->helper('string');
		$this->load->helper('email');
		$novaSenha = strtolower(random_string('alnum', 8));
		$email = $this->input->post('email');

		$config['smtp_host'] = getenv('EMAIL_HOST');
        $config['smtp_user'] = getenv('EMAIL_USER');
        $config['smtp_pass'] = getenv('EMAIL_PASS');
        $config['smtp_port'] = getenv('EMAIL_PORT');
        $config['protocol'] = 'smtp';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
		$config['charset'] = 'utf-8';

        $this->email->initialize($config);
		$this->email->from(getenv('EMAIL_FROM'), 'AACC - Fatec');
		$this->email->to($email);
		
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');
		
		$this->email->send();		

	}
}
