<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Atm extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Atm_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'atm/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'atm/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'atm/index.html';
            $config['first_url'] = base_url() . 'atm/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Atm_model->total_rows($q);
        $atm = $this->Atm_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'atm_data' => $atm,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'atm/atm_list',
            'konten' => 'atm/atm_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Atm_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_atm' => $row->id_atm,
		'no_id' => $row->no_id,
		'nama_atm' => $row->nama_atm,
		'cabang' => $row->cabang,
		'outlet' => $row->outlet,
		'alamat' => $row->alamat,
	    );
            $this->load->view('atm/atm_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('atm'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'atm/atm_form',
            'konten' => 'atm/atm_form',
            'button' => 'Create',
            'action' => site_url('atm/create_action'),
	    'id_atm' => set_value('id_atm'),
	    'no_id' => set_value('no_id'),
	    'nama_atm' => set_value('nama_atm'),
	    'cabang' => set_value('cabang'),
	    'outlet' => set_value('outlet'),
	    'alamat' => set_value('alamat'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_id' => $this->input->post('no_id',TRUE),
		'nama_atm' => $this->input->post('nama_atm',TRUE),
		'cabang' => $this->input->post('cabang',TRUE),
		'outlet' => $this->input->post('outlet',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Atm_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('atm'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Atm_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'atm/atm_form',
                'konten' => 'atm/atm_form',
                'button' => 'Update',
                'action' => site_url('atm/update_action'),
		'id_atm' => set_value('id_atm', $row->id_atm),
		'no_id' => set_value('no_id', $row->no_id),
		'nama_atm' => set_value('nama_atm', $row->nama_atm),
		'cabang' => set_value('cabang', $row->cabang),
		'outlet' => set_value('outlet', $row->outlet),
		'alamat' => set_value('alamat', $row->alamat),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('atm'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_atm', TRUE));
        } else {
            $data = array(
		'no_id' => $this->input->post('no_id',TRUE),
		'nama_atm' => $this->input->post('nama_atm',TRUE),
		'cabang' => $this->input->post('cabang',TRUE),
		'outlet' => $this->input->post('outlet',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Atm_model->update($this->input->post('id_atm', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('atm'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Atm_model->get_by_id($id);

        if ($row) {
            $this->Atm_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('atm'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('atm'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_id', 'no id', 'trim|required');
	$this->form_validation->set_rules('nama_atm', 'nama atm', 'trim|required');
	$this->form_validation->set_rules('cabang', 'cabang', 'trim|required');
	$this->form_validation->set_rules('outlet', 'outlet', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

	$this->form_validation->set_rules('id_atm', 'id_atm', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Atm.php */
/* Location: ./application/controllers/Atm.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-04 13:03:32 */
/* https://jualkoding.com */