<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public $image = '';
	
	public function index()
	{
        //log_r($this->session->userdata());
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

    public function progress($jenis_visit, $progress)
    {
        if ($jenis_visit == 'atm') {
            if ($progress == 'on_progress') {
                // id_user admin cabang
                // $arr_user = array();
                // $this->db->select('id_user');
                // $data_user = $this->db->get_where('user', array('level'=>10))->result();
                // foreach ($data_user as $key => $value) {
                //     array_push($arr_user,$value->id_user);
                // }
                // $id_user = implode(',', $arr_user); 
                // $sql = $this->db->query("SELECT * FROM header_visit_atm as hv, visit_atm as va WHERE hv.group_visit=va.group_visit and hv.id_user IN ($id_user) ");
                // log_r($this->db->last_query());
                $this->db->group_by('group_visit');
                $this->db->order_by('id_visit_atm', 'desc');
                $sql = $this->db->get_where('header_visit_atm', array('progress'=>0));
            } else {
                $this->db->group_by('group_visit');
                $this->db->order_by('id_visit_atm', 'desc');
                $sql = $this->db->get_where('header_visit_atm', array('progress'=>1));
            }
            $data = array(
                'konten' => 'visit/monitor_progress_atm',
                'judul_page' => 'Monitoring Progress ATM',
                'data'=>$sql
            );
            $this->load->view('v_index', $data);
        } else {
            if ($progress == 'on_progress') {
                // id_user admin cabang
                // $arr_user = array();
                // $this->db->select('id_user');
                // $data_user = $this->db->get_where('user', array('level'=>10))->result();
                // foreach ($data_user as $key => $value) {
                //     array_push($arr_user,$value->id_user);
                // }
                // $id_user = implode(',', $arr_user); 
                // $sql = $this->db->query("SELECT * FROM header_visit_atm as hv, visit_atm as va WHERE hv.group_visit=va.group_visit and hv.id_user IN ($id_user) ");
                // log_r($this->db->last_query());
                $this->db->group_by('group_visit');
                $this->db->order_by('id_visit_outlet', 'desc');
                $sql = $this->db->get_where('header_visit_outlet', array('progress'=>0));
            } else {
                $this->db->group_by('group_visit');
                $this->db->order_by('id_visit_outlet', 'desc');
                $sql = $this->db->get_where('header_visit_outlet', array('progress'=>1));
            }
            $data = array(
                'konten' => 'visit/monitor_progress_outlet',
                'judul_page' => 'Monitoring Progress Outlet',
                'data'=>$sql
            );
            $this->load->view('v_index', $data);
        }

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

    public function add_visit_form($id_visit_outlet)
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
		$data = array(
			'konten' => 'visit/add_visit',
            'judul_page' => 'Add Visit Outlet',
            'd_visit' => $this->db->get_where('header_visit_outlet', array('id_visit_outlet'=>$id_visit_outlet))
		);
		$this->load->view('v_index', $data);
    }

    public function add_visit_form_atm($id_header)
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'visit/add_visit_atm',
            'judul_page' => 'Add Visit ATM',
            'd_visit' => $this->db->get_where('header_visit_atm', array('id_visit_atm'=>$id_header))
        );
        $this->load->view('v_index', $data);
    }

    public function add_outlet_visit()
    {
    	$id_outlet = $this->input->post('outlet');
    	$waktu = $this->input->post('waktu');
    	$user = $this->session->userdata('id_user');
        $group_visit = time();

    	$data = array(
            'id_user' => $user,
            'id_outlet' => $id_outlet,
            'date' => $waktu,
            'group_visit' => $group_visit,
        );
        $this->db->insert('header_visit_outlet', $data);

        $header_id = $this->db->insert_id();

        foreach ($this->db->get('check_detail')->result() as $rw) {
            $data = array(
                'id_detail_check' => $rw->id,
                'group_visit' => $group_visit,
                'id_visit_outlet' => $header_id,
            );
            $this->db->insert('visit', $data);
        }

    	$this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil, silahkan isi form berikut ini','info'));
		redirect('app/add_visit_form/'.$header_id,'refresh');

    }

    public function add_outlet_visit_atm()
    {
        $id_atm = $this->input->post('id_atm');
        $waktu = $this->input->post('waktu');
        $user = $this->session->userdata('id_user');
        $group_visit = time();

        $data = array(
            'id_user'=>$user,
            'no_id'=>$id_atm,
            'date'=>$waktu,
            'group_visit'=>$group_visit,
        );
        $this->db->insert('header_visit_atm', $data);
        $header_id = $this->db->insert_id();

        $this->db->where('id_check', 3);
        foreach ($this->db->get('check_detail')->result() as $rw) {
            $data = array(
                'id_detail_check' => $rw->id,
                'group_visit' => $group_visit,
                'id_visit_atm' => $header_id,
            );
            $this->db->insert('visit_atm', $data);
        }
        $this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil, silahkan isi form berikut ini','info'));
        redirect('app/add_visit_form_atm/'.$header_id,'refresh');


    }

    public function simpan_form_visit($id_detail_check,$id_visit_outlet)
    {
    	if ($this->input->post('pilihan') == '1') {
    		$this->db->where('id_visit_outlet', $id_visit_outlet);
            $this->db->where('id_detail_check', $id_detail_check);
    		$this->db->update('visit', array('pilihan_check'=>1));
    	} else {
    		$image = upload_gambar_biasa('visit', './image/visit/', 'jpeg|jpg|png|gif', 10000, 'foto');
    		$keterangan = $this->input->post('ket');

    		$this->db->where('id_visit_outlet', $id_visit_outlet);
            $this->db->where('id_detail_check', $id_detail_check);
    		$this->db->update('visit', array('pilihan_check'=>0,'foto'=>$image,'keterangan'=>$keterangan));
    	}

    	$this->session->set_flashdata('message', alert_biasa('Add Visit Berhasil','success'));
		redirect('app/add_visit_form/'.$id_visit_outlet,'refresh');

    }

    public function simpan_form_visit_detail($id_visit,$date,$user)
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
        redirect('app/detail_visit_outlet/'.base64_encode($waktu).'/'.$user,'refresh');

    }

    public function simpan_form_visit_atm($id_detail_check,$id_visit_atm)
    {
        if ($this->input->post('pilihan') == '1') {
            $this->db->where('id_visit_atm', $id_visit_atm);
            $this->db->where('id_detail_check', $id_detail_check);
            $this->db->update('visit_atm', array('pilihan_check'=>1));
        } else {
            $this->db->where('id_visit_atm', $id_visit_atm);
            $this->db->where('id_detail_check', $id_detail_check);
            $this->db->update('visit_atm', array('pilihan_check'=>0));
        }


        $this->session->set_flashdata('message', alert_biasa('Add Visit ATM Berhasil','success'));
       
        redirect('app/add_visit_form_atm/'.$id_visit_atm,'refresh');

    }

    public function simpan_form_visit_atm_detail($id_visit,$date,$user)
    {
        if ($this->input->post('pilihan') == '1') {
            $this->db->where('id_visit', $id_visit);
            $this->db->update('visit_atm', array('pilihan_check'=>1));
        } else {
            $this->db->where('id_visit', $id_visit);
            $this->db->update('visit_atm', array('pilihan_check'=>0));
        }

        $waktu = base64_decode($date);

        $this->session->set_flashdata('message', alert_biasa('Add Visit ATM Berhasil','success'));
       
        redirect('app/detail_visit_atm/'.base64_encode($waktu).'/'.$user,'refresh');

    }

    public function selesai_visit_outlet($id_visit_outlet)
    {
        
        $cek_detail = $this->db->query("SELECT * FROM visit WHERE (pilihan_check is null  or pilihan_check ='' and pilihan_check!=0) and id_visit_outlet='$id_visit_outlet' ");

        if ($cek_detail->num_rows() > 0) {
            $this->session->set_flashdata('message', alert_biasa('masih ada data yang belum terisi','info'));
            redirect('app/add_visit_form/'.$id_visit_outlet,'refresh');
        } else {
            $this->session->set_flashdata('message', alert_biasa('Visit Selesai dilakukan','success'));
            redirect('app/list_visit_outlet','refresh');
        }
    }

    public function selesai_visit_atm($id_visit_atm)
    {
        // $outlet = get_data('atm','no_id',$id_atm,'outlet');
        // $this->db->insert('approve', array('group_create'=>$id_user,'group_approve'=>$approve,'group_visit'=>$group_visit,'outlet'=>$outlet));

       

        // $this->session->set_flashdata('message', alert_biasa('berhasil','success'));
        // redirect('app/list_visit_atm','refresh');

        $cek_header = $this->db->query("SELECT * FROM header_visit_atm WHERE (( foto1 IS NULL OR foto2 IS NULL OR ket1 IS NULL OR ket2 IS NULL ) or (foto1 ='' OR foto2 ='' OR ket1 ='' OR ket2 ='')) and id_visit_atm='$id_visit_atm' ");
        $cek_detail = $this->db->query("SELECT * FROM visit_atm WHERE (pilihan_check is null  or pilihan_check ='' and pilihan_check!=0) and id_visit_atm='$id_visit_atm' ");

        if ($cek_header->num_rows() > 0 || $cek_detail->num_rows() > 0) {
            $this->session->set_flashdata('message', alert_biasa('masih ada data yang belum terisi','info'));
            redirect('app/add_visit_form_atm/'.$id_visit_atm,'refresh');
        } else {
            $this->session->set_flashdata('message', alert_biasa('Visit Selesai dilakukan','success'));
            redirect('app/list_visit_atm','refresh');
        }


    }

    public function detail_visit_outlet($g_visit)
    {

        if ($this->session->userdata('level') == 8) {
            $dilihat = get_data('header_visit_outlet','group_visit',$g_visit,'dilihat');
            $nama = $this->session->userdata('nama');
            $koma= '';
            if ($dilihat != '') {
                $koma = ', ';
            } 
            $cek = $this->db->query("SELECT * FROM header_visit_outlet WHERE dilihat like '%$nama%' and group_visit='$g_visit' ")->num_rows();
            if ($cek > 0) {
                # code...
            } else {
                $dilihat .= $koma.''.$nama;
                $this->db->where('group_visit', $g_visit);
                $this->db->update('header_visit_outlet', array('dilihat'=>$dilihat));
            }
            

        }

        $data = array(
            'konten' => 'visit/detail_visit_outlet',
            'judul_page' => 'Detail Visit Outlet',
        );
        $this->load->view('v_index', $data);
    }

    public function detail_visit_atm($g_visit)
    {
        if ($this->session->userdata('level') == 8) {
            $dilihat = get_data('header_visit_atm','group_visit',$g_visit,'dilihat');
            $nama = $this->session->userdata('nama');
            $koma= '';
            if ($dilihat != '') {
                $koma = ', ';
            } 
            $cek = $this->db->query("SELECT * FROM header_visit_atm WHERE dilihat like '%$nama%' and group_visit='$g_visit' ")->num_rows();
            if ($cek > 0) {
                # code...
            } else {
                $dilihat .= $koma.''.$nama;
                $this->db->where('group_visit', $g_visit);
                $this->db->update('header_visit_atm', array('dilihat'=>$dilihat));
            }
            

        }
        $data = array(
            'konten' => 'visit/detail_visit_atm',
            'judul_page' => 'Detail Visit ATM',
        );
        $this->load->view('v_index', $data);
    }

    public function delete_visit_outlet($id_user,$group_visit)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('group_visit', $group_visit);
        $this->db->delete('visit');
         $this->session->set_flashdata('message', alert_biasa('berhasil hapus data','success'));
        redirect('app/list_visit_outlet','refresh');
    }

    public function delete_visit_atm($id_user,$group_visit)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('group_visit', $group_visit);
        $this->db->delete('visit_atm');

         $this->session->set_flashdata('message', alert_biasa('berhasil hapus data','success'));
        redirect('app/list_visit_atm','refresh');
    }

    public function simpan_approve_atm($id_visit_atm)
    {
        $komentar = $this->input->post('komentar');
        
        if (isset($_POST['simpan'])) {
            //cek progress
            $progress = 0;
            if ($_POST['progress'] == '1') {
                $progress = 1;
            }
            $this->db->where('id_visit_atm', $id_visit_atm);
            $this->db->update('header_visit_atm', array('komentar'=>$komentar,'approve'=>1,'progress'=>$progress));

            $this->session->set_flashdata('message', alert_biasa('Komentar telah disimpan','success'));
            redirect('app/list_visit_atm','refresh');
        } elseif (isset($_POST['simpan_edit'])) {
            $progress = 0;
            if ($_POST['progress'] == '1') {
                $progress = 1;
            }
            $this->db->where('id_visit_atm', $id_visit_atm);
            $this->db->update('header_visit_atm', array('komentar'=>$komentar,'approve'=>1,'progress'=>$progress));

            //edit visit atm
            $id_atm = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'no_id');
            $waktu = get_waktu();
            $user = $this->session->userdata('id_user');
            $group_visit = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'group_visit');
            $foto1 = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'foto1');
            $foto2 = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'foto2');
            $ket1 = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'ket1');
            $ket2 = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'ket2');

            $data = array(
                'id_user'=>$user,
                'no_id'=>$id_atm,
                'date'=>$waktu,
                'group_visit'=>$group_visit,
                'foto1'=>$foto1,
                'foto2'=>$foto2,
                'ket1'=>$ket1,
                'ket2'=>$ket2,
            );
            if ($this->session->userdata('level') == 10) {
                $data['approve'] = 1;
            }
            $this->db->insert('header_visit_atm', $data);
            $header_id = $this->db->insert_id();

            $this->db->where('id_visit_atm', $id_visit_atm);
            foreach ($this->db->get('visit_atm')->result() as $rw) {
                $data = array(
                    'id_detail_check' => $rw->id_detail_check,
                    'pilihan_check'=>$rw->pilihan_check,
                    'group_visit' => $rw->group_visit,
                    'id_visit_atm' => $header_id,
                );
                $this->db->insert('visit_atm', $data);
            }
            

            $this->session->set_flashdata('message', alert_biasa('Komentar telah disimpan dan silahkan edit visit ini','success'));
            redirect('app/add_visit_form_atm/'.$header_id,'refresh');
        }


    }

    public function simpan_approve_outlet($id_visit_outlet)
    {
        $komentar = $this->input->post('komentar');
        
        if (isset($_POST['simpan'])) {
            //cek progress
            $progress = 0;
            if ($_POST['progress'] == '1') {
                $progress = 1;
            }
            $this->db->where('id_visit_outlet', $id_visit_outlet);
            $this->db->update('header_visit_outlet', array('komentar'=>$komentar,'approve'=>1,'progress'=>$progress));

            $this->session->set_flashdata('message', alert_biasa('Komentar telah disimpan','success'));
            redirect('app/list_visit_outlet','refresh');
        } elseif (isset($_POST['simpan_edit'])) {
            $progress = 0;
            if ($_POST['progress'] == '1') {
                $progress = 1;
            }
            $this->db->where('id_visit_outlet', $id_visit_outlet);
            $this->db->update('header_visit_outlet', array('komentar'=>$komentar,'approve'=>1,'progress'=>$progress));

            //edit visit atm
            $id_outlet = get_data('header_visit_outlet','id_visit_outlet',$id_visit_outlet,'id_outlet');
            $waktu = get_waktu();
            $user = $this->session->userdata('id_user');
            $group_visit = get_data('header_visit_outlet','id_visit_outlet',$id_visit_outlet,'group_visit');

            $data = array(
                'id_user'=>$user,
                'id_outlet'=>$id_outlet,
                'date'=>$waktu,
                'group_visit'=>$group_visit,
            );
            if ($this->session->userdata('level') == 10) {
                $data['approve'] = 1;
            }
            $this->db->insert('header_visit_outlet', $data);
            $header_id = $this->db->insert_id();

            $this->db->where('id_visit_outlet', $id_visit_outlet);
            foreach ($this->db->get('visit')->result() as $rw) {
                $data = array(
                    'id_detail_check' => $rw->id_detail_check,
                    'pilihan_check'=>$rw->pilihan_check,
                    'foto'=>$rw->foto,
                    'keterangan'=>$rw->keterangan,
                    'group_visit' => $rw->group_visit,
                    'id_visit_outlet' => $header_id,
                );
                $this->db->insert('visit', $data);
            }
            

            $this->session->set_flashdata('message', alert_biasa('Komentar telah disimpan dan silahkan edit visit ini','success'));
            redirect('app/add_visit_form/'.$header_id,'refresh');
        }

    }

    public function simpan_foto_atm($id_visit_atm)
    {
        // log_r($_FILES);

        $image1 = upload_gambar_biasa('foto_atm', './image/visit/', 'jpeg|jpg|png|gif', 10000, 'foto1');
        $ket1 = $this->input->post('ket1');
        $image2 = upload_gambar_biasa('foto_atm', './image/visit/', 'jpeg|jpg|png|gif', 10000, 'foto2');
        $ket2 = $this->input->post('ket2');

        if ($_FILES['foto1']['name'] == '') {
            $image1 = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'foto1');
        }
        if ($_FILES['foto2']['name'] == '') {
            $image2 = get_data('header_visit_atm','id_visit_atm',$id_visit_atm,'foto2');
        }


        $this->db->where('id_visit_atm', $id_visit_atm);
        $this->db->update('header_visit_atm', array(
            'foto1'=>$image1,
            'foto2'=>$image2,
            'ket1'=>$ket1,
            'ket2'=>$ket2,
        ));

        $this->session->set_flashdata('message', alert_biasa('Add Foto ATM Berhasil','success'));
        redirect('app/add_visit_form_atm/'.$id_visit_atm,'refresh');
    }

    public function simpan_foto_atm_detail($id_user,$group_visit,$date)
    {
        $image = upload_gambar_biasa('foto_atm', './image/visit/', 'jpeg|jpg|png|gif', 10000, 'foto');
        $keterangan = $this->input->post('ket');

        $this->db->insert('foto_atm', array('id_user'=>$id_user,'group_visit'=>$group_visit,'foto'=>$image,'keterangan'=>$keterangan));

        $waktu = base64_decode($date);

        $this->session->set_flashdata('message', alert_biasa('Add Foto ATM Berhasil','success'));
        redirect('app/detail_visit_atm/'.base64_encode($waktu).'/'.$id_user,'refresh');
    }

    public function edit_visit_atm($id_visit_atm)
    {
        
    }

    public function edit_visit_outlet($id_approve)
    {
        $id_user = get_data('approve','id_approve',$id_approve,'group_create');
        $group_visit = get_data('approve','id_approve',$id_approve,'group_visit');

        $this->db->where('id_user', $id_user);
        $this->db->where('group_visit', $group_visit);
        foreach ($this->db->get('visit')->result() as $rw) {
            $data = array(
                'id_user'=>$this->session->userdata('id_user'),
                'id_outlet'=>$rw->id_outlet,
                'date'=>$rw->date,
                'id_detail_check'=>$rw->id_detail_check,
                'pilihan_check'=>$rw->pilihan_check,
                'keterangan'=>$rw->keterangan,
                'group_visit'=>$rw->group_visit,
            );
            $this->db->insert('visit', $data);
        }
        redirect('app/detail_visit_outlet/'.$group_visit,'refresh');
    }



    

	
}
