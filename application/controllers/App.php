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

    public function list_visit_outlet()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        $data = array(
            'konten' => 'visit/list_visit_outlet',
            'judul_page' => 'List Visit Outlet',
        );
        $this->load->view('v_index', $data);
    }

    public function list_visit_atm()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        $data = array(
            'konten' => 'visit/list_visit_atm',
            'judul_page' => 'List Visit ATM',
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
            'judul_page' => 'Add Visit Outlet',
		);
		$this->load->view('v_index', $data);
    }


    public function add_visit_atm()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        $data = array(
            'konten' => 'visit/add_outlet_atm',
            'judul_page' => 'Add Visit ATM',
        );
        $this->load->view('v_index', $data);
    }

    public function add_visit_form($date,$id_user)
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        $date = base64_decode($date);
		$data = array(
			'konten' => 'visit/add_visit',
            'judul_page' => 'Add Visit',
            'd_visit' => $this->db->get_where('visit', array('id_user'=>$id_user,'date'=>$date))
		);
		$this->load->view('v_index', $data);
    }

    public function add_visit_form_atm($date,$id_user)
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        $date = base64_decode($date);
        $data = array(
            'konten' => 'visit/add_visit_atm',
            'judul_page' => 'Add Visit ATM',
            'd_visit' => $this->db->get_where('visit_atm', array('id_user'=>$id_user,'date'=>$date))
        );
        $this->load->view('v_index', $data);
    }

    public function add_outlet_visit()
    {
    	$id_outlet = $this->input->post('outlet');
    	$waktu = $this->input->post('waktu');
    	$user = $this->session->userdata('id_user');
        $group_visit = time();
    	foreach ($this->db->get('check_detail')->result() as $rw) {
    		$data = array(
	    		'id_user' => $user,
	    		'id_outlet' => $id_outlet,
	    		'date' => $waktu,
                'id_detail_check' => $rw->id,
	    		'group_visit' => $group_visit,
	    	);
	    	$this->db->insert('visit', $data);
    	}
    	$this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil, silahkan isi form berikut ini','info'));
		redirect('app/add_visit_form/'.base64_encode($waktu).'/'.$user,'refresh');


    }

    public function add_outlet_visit_atm()
    {
        $id_atm = $this->input->post('id_atm');
        $waktu = $this->input->post('waktu');
        $user = $this->session->userdata('id_user');
        $group_visit = time();
        foreach ($this->db->get('check_detail')->result() as $rw) {
            $data = array(
                'id_user' => $user,
                'id_atm' => $id_atm,
                'date' => $waktu,
                'id_detail_check' => $rw->id,
                'group_visit' => $group_visit,
            );
            $this->db->insert('visit_atm', $data);
        }
        $this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil, silahkan isi form berikut ini','info'));
        redirect('app/add_visit_form_atm/'.base64_encode($waktu).'/'.$user,'refresh');


    }

    public function simpan_form_visit($id_visit,$date,$user)
    {
    	if ($this->input->post('pilihan') == '1') {
    		$this->db->where('id_visit', $id_visit);
    		$this->db->update('visit', array('pilihan_check'=>1));
    	} else {
    		$image = upload_gambar_biasa('visit', './image/visit/', 'jpeg|jpg|png|gif', 10000, 'foto');
    		$keterangan = $this->input->post('ket');

    		$this->db->where('id_visit', $id_visit);
    		$this->db->update('visit', array('pilihan_check'=>0,'foto'=>$image,'keterangan'=>$keterangan));
    	}

    	$waktu = base64_decode($date);

    	$this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil','success'));
		redirect('app/add_visit_form/'.base64_encode($waktu).'/'.$user,'refresh');

    }

    public function simpan_form_visit_atm($id_visit,$date,$user)
    {
        if ($this->input->post('pilihan') == '1') {
            $this->db->where('id_visit', $id_visit);
            $this->db->update('visit_atm', array('pilihan_check'=>1));
        } else {
            $image = upload_gambar_biasa('visit', './image/visit/', 'jpeg|jpg|png|gif', 10000, 'foto');
            $keterangan = $this->input->post('ket');

            $this->db->where('id_visit', $id_visit);
            $this->db->update('visit_atm', array('pilihan_check'=>0,'foto'=>$image,'keterangan'=>$keterangan));
        }

        $waktu = base64_decode($date);

        $this->session->set_flashdata('message', alert_biasa('Add Visit ATM Berhasil','success'));
        redirect('app/add_visit_form_atm/'.base64_encode($waktu).'/'.$user,'refresh');

    }

    public function selesai_visit_outlet($approve,$id_user,$group_visit,$outlet)
    {
        $this->db->insert('approve', array('group_create'=>$id_user,'group_approve'=>$approve,'group_visit'=>$group_visit,'outlet'=>$outlet));

        foreach ($this->db->get_where('visit', array('id_user'=>$this->session->userdata('id_user'),'group_visit'=>$group_visit))->result() as $rw) {
            $data = array(
                'id_user' => $this->session->userdata('user_approve'),
                'id_outlet' => $outlet,
                'date' => get_waktu(),
                'id_detail_check' => $rw->id_detail_check,
                'approve' =>0,
                'group_visit' => $group_visit,
            );
            $this->db->insert('visit', $data);
        }

        $this->session->set_flashdata('message', alert_biasa('berhasil','success'));
        redirect('app/list_visit_outlet','refresh');
    }

    public function selesai_visit_atm($approve,$id_user,$group_visit,$id_atm)
    {
        $outlet = get_data('atm','id_atm',$id_atm,'outlet');
        $this->db->insert('approve', array('group_create'=>$id_user,'group_approve'=>$approve,'group_visit'=>$group_visit,'outlet'=>$outlet));

        foreach ($this->db->get_where('visit_atm', array('id_user'=>$this->session->userdata('id_user'),'group_visit'=>$group_visit))->result() as $rw) {
            $data = array(
                'id_user' => $this->session->userdata('user_approve'),
                'id_atm' => $id_atm,
                'date' => get_waktu(),
                'id_detail_check' => $rw->id_detail_check,
                'approve' =>0,
                'group_visit' => $group_visit,
            );
            $this->db->insert('visit_atm', $data);
        }

        $this->session->set_flashdata('message', alert_biasa('berhasil','success'));
        redirect('app/list_visit_atm','refresh');
    }

    public function detail_visit_outlet($g_visit)
    {
        $data = array(
            'konten' => 'visit/detail_visit_outlet',
            'judul_page' => 'Detail Visit Outlet',
        );
        $this->load->view('v_index', $data);
    }




    

	
}
