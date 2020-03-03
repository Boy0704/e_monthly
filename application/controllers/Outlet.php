<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Outlet extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Outlet_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'outlet/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'outlet/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'outlet/index.html';
            $config['first_url'] = base_url() . 'outlet/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Outlet_model->total_rows($q);
        $outlet = $this->Outlet_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'outlet_data' => $outlet,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'outlet/outlet_list',
            'konten' => 'outlet/outlet_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Outlet_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_outlet' => $row->id_outlet,
		'outlet' => $row->outlet,
		'alamat' => $row->alamat,
	    );
            $this->load->view('outlet/outlet_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('outlet'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'outlet/outlet_form',
            'konten' => 'outlet/outlet_form',
            'button' => 'Create',
            'action' => site_url('outlet/create_action'),
	    'id_outlet' => set_value('id_outlet'),
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
		'outlet' => $this->input->post('outlet',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Outlet_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('outlet'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Outlet_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'outlet/outlet_form',
                'konten' => 'outlet/outlet_form',
                'button' => 'Update',
                'action' => site_url('outlet/update_action'),
		'id_outlet' => set_value('id_outlet', $row->id_outlet),
		'outlet' => set_value('outlet', $row->outlet),
		'alamat' => set_value('alamat', $row->alamat),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('outlet'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_outlet', TRUE));
        } else {
            $data = array(
		'outlet' => $this->input->post('outlet',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Outlet_model->update($this->input->post('id_outlet', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('outlet'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Outlet_model->get_by_id($id);

        if ($row) {
            $this->Outlet_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('outlet'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('outlet'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('outlet', 'outlet', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

	$this->form_validation->set_rules('id_outlet', 'id_outlet', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Outlet.php */
/* Location: ./application/controllers/Outlet.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-03 02:49:19 */
/* https://jualkoding.com */