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
		$this->load->library('email');
		$senhaTemporaria = strtolower(random_string('alnum', 8));
		$linkRecuperacao =  BASE_URL . 'login/recuperar-acesso';
		$mensagem = '<p>Se você não requisitou uma recuperação de senha, ignore essa mensagem.</p>';
		$mensagem .= '<p>Senha de acesso: '. $senhaTemporaria . '</p>';
		$mensagem .= "<p>Link para recuperar seu acesso: <a href='$linkRecuperacao' target='_blank'>$linkRecuperacao</a>";
		$email = $this->input->post('email');
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => getenv('EMAIL_HOST'),
			'smtp_port' => getenv('EMAIL_PORT'),
			'smtp_user' => getenv('EMAIL_USER'),
			'smtp_pass' => getenv('EMAIL_PASS'),
			'crlf' => "\r\n",
			'newline' => "\r\n",
			'mailtype' => 'html',
			'wordwrap' => TRUE,
			'charset' => 'utf-8'
		);		
        $this->email->initialize($config);
		$this->email->from(getenv('EMAIL_FROM'), 'AACC - Fatec');
		$this->email->to($email);
		$this->email->subject('Recuperação de senha');
		$this->email->message($mensagem);
		if($this->mod_usuario->emailExiste($email)){
			if($this->mod_usuario->setSenhaTemporaria($email, $senhaTemporaria)){
				if($this->email->send()){
					$data['sucesso'] = true;
				}
			}
		}else{
			$data['sucesso'] = false;
		}
		echo json_encode($data);
	 }

	 public function recuperarAcesso(){
		 $this->load->view('login-recuperar');
	 }
}
