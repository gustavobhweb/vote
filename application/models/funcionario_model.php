<?php

class Funcionario_Model extends CI_Model
{

	public function Get($cod_funcionario=null)
	{
		if (empty($cod_funcionario)) {
			return $this->db->query('SELECT * FROM tbl_funcionarios')->result();
		} else {
			$verify = $this->db->query('SELECT * FROM tbl_votos 
							  WHERE tbl_funcionarios_cod_funcionario = ? 
							  AND tbl_usuarios_cod_usuario = ?', 
							  array($cod_funcionario, $this->session->userdata('cod_usuario')))->num_rows();
			$qr = null;
			if (!$verify) {
				$qr = 'SELECT * FROM tbl_funcionarios WHERE cod_funcionario = ?';
				$bind = array($cod_funcionario);
			} else {
				$qr = 'SELECT tbl_funcionarios.cod_funcionario as cod_funcionario,
							  tbl_funcionarios.nome as nome,
							  tbl_funcionarios.dataCad as dataCad,
							  tbl_votos.voto as voto 
							  FROM tbl_funcionarios JOIN tbl_votos
							  ON tbl_funcionarios.cod_funcionario = tbl_votos.tbl_funcionarios_cod_funcionario 
							  WHERE tbl_funcionarios.cod_funcionario = ? 
							  AND tbl_votos.tbl_usuarios_cod_usuario = ?';
				$bind = array($cod_funcionario, $this->session->userdata('cod_usuario'));
			}
			return $this->db->query($qr, $bind)->row();
		}
	}

	public function Save($nome)
	{
		$qr = 'INSERT INTO tbl_funcionarios VALUES(NULL, ?, ?, ?)';
		$bind = array($nome, 
					  date('Y-m-d H:i:s'), 
					  $this->session->userdata('cod_usuario'));
		return $this->db->query($qr, $bind);
	}

	public function Delete($cod_funcionario=null)
	{
		if (empty($cod_funcionario)) {
			$this->db->query('DELETE FROM tbl_votos');
			return $this->db->query('DELETE FROM tbl_funcionarios');
		} else {
			$qr = 'DELETE FROM tbl_funcionarios WHERE cod_funcionario = ?';
			$qr1 = 'DELETE FROM tbl_votos WHERE tbl_funcionarios_cod_funcionario = ?';
			$bind = array($cod_funcionario);
			$this->db->query($qr1, $bind);
			return $this->db->query($qr, $bind);
		}
	}
}