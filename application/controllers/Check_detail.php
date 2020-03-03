<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Check_detail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Check_detail_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'check_detail/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'check_detail/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'check_detail/index.html';
            $config['first_url'] = base_url() . 'check_detail/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Check_detail_model->total_rows($q);
        $check_detail = $this->Check_detail_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'check_detail_data' => $check_detail,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'check_detail/check_detail_list',
            'konten' => 'check_detail/check_detail_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Check_detail_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'id_check' => $row->id_check,
		'detail' => $row->detail,
	    );
            $this->load->view('check_detail/check_detail_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('check_detail'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'check_detail/check_detail_form',
            'konten' => 'check_detail/check_detail_form',
            'button' => 'Create',
            'action' => site_url('check_detail/create_action'),
	    'id' => set_value('id'),
	    'id_check' => set_value('id_check'),
	    'detail' => set_value('detail'),
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
		'id_check' => $this->input->post('id_check',TRUE),
		'detail' => $this->input->post('detail',TRUE),
	    );

            $this->Check_detail_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('check_detail'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Check_detail_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'check_detail/check_detail_form',
                'konten' => 'check_detail/check_detail_form',
                'button' => 'Update',
                'action' => site_url('check_detail/update_action'),
		'id' => set_value('id', $row->id),
		'id_check' => set_value('id_check', $row->id_check),
		'detail' => set_value('detail', $row->detail),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('check_detail'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'id_check' => $this->input->post('id_check',TRUE),
		'detail' => $this->input->post('detail',TRUE),
	    );

            $this->Check_detail_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('check_detail'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Check_detail_model->get_by_id($id);

        if ($row) {
            $this->Check_detail_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('check_detail'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('check_detail'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_check', 'id check', 'trim|required');
	$this->form_validation->set_rules('detail', 'detail', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Check_detail.php */
/* Location: ./application/controllers/Check_detail.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-03 03:58:23 */
/* https://jualkoding.com */