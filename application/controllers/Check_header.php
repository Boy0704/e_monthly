<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Check_header extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Check_header_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'check_header/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'check_header/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'check_header/index.html';
            $config['first_url'] = base_url() . 'check_header/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Check_header_model->total_rows($q);
        $check_header = $this->Check_header_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'check_header_data' => $check_header,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'check_header/check_header_list',
            'konten' => 'check_header/check_header_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Check_header_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_check' => $row->id_check,
		'judul' => $row->judul,
	    );
            $this->load->view('check_header/check_header_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('check_header'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'check_header/check_header_form',
            'konten' => 'check_header/check_header_form',
            'button' => 'Create',
            'action' => site_url('check_header/create_action'),
	    'id_check' => set_value('id_check'),
	    'judul' => set_value('judul'),
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
		'judul' => $this->input->post('judul',TRUE),
	    );

            $this->Check_header_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('check_header'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Check_header_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'check_header/check_header_form',
                'konten' => 'check_header/check_header_form',
                'button' => 'Update',
                'action' => site_url('check_header/update_action'),
		'id_check' => set_value('id_check', $row->id_check),
		'judul' => set_value('judul', $row->judul),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('check_header'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_check', TRUE));
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
	    );

            $this->Check_header_model->update($this->input->post('id_check', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('check_header'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Check_header_model->get_by_id($id);

        if ($row) {
            $this->Check_header_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('check_header'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('check_header'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');

	$this->form_validation->set_rules('id_check', 'id_check', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Check_header.php */
/* Location: ./application/controllers/Check_header.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-03 03:02:50 */
/* https://jualkoding.com */