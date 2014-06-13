<?php

class Usuario_Model extends CI_Model
{

	public function Authenticate($data)
	{
		$data = (object)$data;

		if (empty($data->usuario)) {
			return false;
		} else if(!$this->Get($data, 1)) {
			return false;
		} else {
			return true;
		}
	}

	public function Get($data=null, $num=false)
	{
		if (!$num) {
			if (empty($data)) {
				return $this->db->query('SELECT * FROM tbl_usuarios')->result();
			} else {
				$qr = 'SELECT * FROM tbl_usuarios WHERE usuario = ? AND senha = ?';
				$bind = array($data->usuario, $data->senha);
				return $this->db->query($qr, $bind)->row();
			}
		} else {
			if (empty($data)) {
				return $this->db->query('SELECT * FROM tbl_usuarios')->num_rows();
			} else {
				$qr = 'SELECT * FROM tbl_usuarios WHERE usuario = ? AND senha = ?';
				$bind = array($data->usuario, $data->senha);
				return $this->db->query($qr, $bind)->num_rows();
			}
		}
	}

	public function Save($data)
	{
		$data = (object)$data;
		$qr = 'INSERT INTO tbl_usuarios VALUES(NULL, ?, ?, ?, ?)';
		$bind = array($data->usuario, md5($data->senha), $data->nome, date('Y-m-d H:i:s'));
		return $this->db->query($qr, $bind);
	}

}