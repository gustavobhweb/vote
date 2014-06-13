<?php

class Voto_Model extends CI_Model
{

    public function Media($data)
    {
        $qr = 'SELECT AVG(voto) as voto FROM tbl_votos 
               WHERE tbl_funcionarios_cod_funcionario = ? 
               AND dataIdVoto = ?';
        $bind = array($data->cod_funcionario, date('Y0m'));
        $sel = $this->db->query($qr, $bind)->row();
        $num = $this->db->query($qr, $bind)->num_rows();

        $mediavotos = ($num && !empty($sel->voto)) ? $sel->voto : 0;

        return (float)$mediavotos;
    }

    public function Votar($data)
    {
        $data = (object)$data;
        $data->cod_usuario = $this->session->userdata('cod_usuario');
        if (!$this->VerificarVoto($data)) {
            $qr = 'INSERT INTO tbl_votos(cod_voto,  
                                         tbl_usuarios_cod_usuario, 
                                         tbl_funcionarios_cod_funcionario, 
                                         voto, 
                                         dataIdVoto)
                    VALUES(NULL, ?, ?, ?, ?)';
            $bind = array($data->cod_usuario,
                          $data->cod_funcionario,
                          $data->voto,
                          date('Y0m'));

            $this->db->query($qr, $bind);
        } else {
            $qr = 'UPDATE tbl_votos SET voto = ? 
                   WHERE tbl_usuarios_cod_usuario = ? 
                   AND tbl_funcionarios_cod_funcionario = ?';
            $bind = array($data->voto,
                          $data->cod_usuario,
                          $data->cod_funcionario);

            $this->db->query($qr, $bind);
        }
    }

    public function VerificarVoto($data)
    {
        $qr = 'SELECT * FROM tbl_votos 
               WHERE tbl_usuarios_cod_usuario = ? 
               AND tbl_funcionarios_cod_funcionario = ?';
        $bind = array($data->cod_usuario, $data->cod_funcionario);

        if (!$this->db->query($qr, $bind)->num_rows()) {
            return false;
        } else if($this->db->query($qr, $bind)->row()->dataIdVoto == date('Y0m')) {
            return true;
        } else {
            return false;
        }
    }

}