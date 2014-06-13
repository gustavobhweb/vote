<?php

class Main extends CI_Controller
{

	public function index()
	{
		$this->auth();
		$this->load->model('Funcionario_Model');
		$this->load->model('Voto_Model');
		$viewData = array();
		$viewData['funcionarios'] = $this->Funcionario_Model->Get();
		
		if (count($viewData['funcionarios'])) {
			foreach($viewData['funcionarios'] as $k => $v){
				$viewData['funcionarios'][$k]->media_votos = $this->Voto_Model->Media($viewData['funcionarios'][$k]);
			}
		}

		$this->load->view('Vote/vote', $viewData);
	}

	public function login()
	{
		$this->load->model('Usuario_Model');
		$viewData = array();
		if ($this->input->post('usuario')) {

			$data = new stdClass;
			$data->usuario = $this->input->post('usuario');
			$data->senha = md5($this->input->post('senha'));

			if ($this->Usuario_Model->Authenticate($data)) {
				$this->session->set_userdata($this->Usuario_Model->Get($data));

				redirect(base_url());
			} else {
				$viewData['error'] = 'Usuário ou senha incorretos.';
			}
		}

		$this->load->view('Vote/login', $viewData);
	}

	public function logout()
	{
		$this->session->unset_userdata(array('usuario' => '', 'senha' => ''));
		$this->session->sess_destroy();
		redirect(base_url());
	}

	private function auth()
	{
		$this->load->model('Usuario_Model');
		$usuarioLogged = $this->session->all_userdata();

		if (empty($usuarioLogged)) {
			redirect('main/login');
			exit;
		} else if(!$this->Usuario_Model->Authenticate($usuarioLogged)) {
			redirect('main/login');
			exit;
		}
	}

	public function Action_Cadastrar()
	{
		if ($this->input->post('sended')) {
			$this->load->model('Funcionario_Model');
			$this->Funcionario_Model->Save($this->input->post('nome'));
		}
	}

	public function Action_Selecionar()
	{
		header('Content-Type: application/json');
		if ($this->input->post('sended')) {
			$this->load->model('Funcionario_Model');
			echo json_encode($this->Funcionario_Model->Get($this->input->post('cod_funcionario')));
		}
	}

	public function Action_Votar()
	{
		if ($this->input->post('sended')) {
			$this->load->model('Voto_Model');

			$data = array('cod_funcionario' => $this->input->post('cod_funcionario'),
						  'voto' => $this->input->post('voto'));

			$this->Voto_Model->Votar($data);
		}
	}

	public function Action_Deletar_Funcionario()
	{
		if ($this->input->post('sended')) {
			$this->load->model('Funcionario_Model');

			$this->Funcionario_Model->Delete($this->input->post('cod_funcionario'));
		}
	}

	public function setup()
	{
		$this->load->model('Usuario_Model');

		$daniel = array('usuario' => 'daniel', 'senha' => '123456', 'nome' => 'Daniel Magalhães');
		$tiago = array('usuario' => 'fernanda', 'senha' => '123456', 'nome' => 'Fernanda Garcia');
		$fernanda = array('usuario' => 'tiago', 'senha' => '123456', 'nome' => 'Tiago Magalhães');

		$this->Usuario_Model->Save($daniel);
		$this->Usuario_Model->Save($tiago);
		$this->Usuario_Model->Save($fernanda);
	}

}