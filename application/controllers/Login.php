<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index() 
	{
		$this->load->view('login');
	}

	public function aksi_login()
	{
			$username = $this->input->post('username');
			// $password = md5($this->input->post('password'));
			$password = $this->input->post('password');

			// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
			$cek_user = $this->db->query("SELECT * FROM user, group_user WHERE user.level=group_user.id_group and user.username='$username' and user.password='$password' ");
			// if (password_verify($password, $hashed)) {
			if ($cek_user->num_rows() > 0) {
				foreach ($cek_user->result() as $row) {
					
                    $sess_data['id_user'] = $row->id_user;
					$sess_data['nama'] = $row->nama;
					$sess_data['username'] = $row->username;
					$sess_data['outlet'] = $row->outlet;
					$sess_data['cabang'] = $row->cabang;
					$sess_data['level'] = $row->level;
					$sess_data['status_approve'] = $row->status_approve;
					$sess_data['user_approve'] = $row->approve;
					$this->session->set_userdata($sess_data);
				}

				// define('FOTO', $this->session->userdata('foto'), TRUE);
				

				// print_r($this->session->userdata());
				// exit;
				// $sess_data['username'] = $username;
				// $this->session->set_userdata($sess_data);
				if ($this->session->userdata('level') == 1) {
					redirect('app','refresh');
				} elseif ($this->session->userdata('level') > 1) {
					redirect('#','refresh');
				}

				// redirect('app/index');
			} else {
				$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n username atau password kamu salah','warning'));
				// $this->session->set_flashdata('message', alert_tunggu('Gagal Login!\n username atau password kamu salah','warning'));
				redirect('login','refresh');
			}
	}

	

	function logout()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('login','refresh');
	}
}
