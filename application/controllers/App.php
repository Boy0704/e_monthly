<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public $image = '';
	
	public function index()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function add_visit()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
		$data = array(
			'konten' => 'visit/add_outlet',
            'judul_page' => 'Add Visit',
		);
		$this->load->view('v_index', $data);
    }

    public function add_visit_form($date,$id_user)
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
		$data = array(
			'konten' => 'visit/add_visit',
            'judul_page' => 'Add Visit',
            'd_visit' => $this->db->get_where('visit', array('id_user'=>$id_user,'date'=>$date))
		);
		$this->load->view('v_index', $data);
    }

    public function add_outlet_visit()
    {
    	$id_outlet = $this->input->post('outlet');
    	$waktu = $this->input->post('waktu');
    	$user = $this->session->userdata('id_user');

    	foreach ($this->db->get('check_detail')->result() as $rw) {
    		$data = array(
	    		'id_user' => $user,
	    		'id_outlet' => $id_outlet,
	    		'date' => $waktu,
	    		'id_detail_check' => $rw->id,
	    	);
	    	$this->db->insert('visit', $data);
    	}
    	$this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil, silahkan isi form berikut ini','info'));
		redirect('app/add_visit_form','refresh');


    }



    

	
}
