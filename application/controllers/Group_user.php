<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Group_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Group_user_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'group_user/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'group_user/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'group_user/index.html';
            $config['first_url'] = base_url() . 'group_user/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Group_user_model->total_rows($q);
        $group_user = $this->Group_user_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'group_user_data' => $group_user,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'group_user/group_user_list',
            'konten' => 'group_user/group_user_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Group_user_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_group' => $row->id_group,
		'nama_group' => $row->nama_group,
	    );
            $this->load->view('group_user/group_user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('group_user'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'group_user/group_user_form',
            'konten' => 'group_user/group_user_form',
            'button' => 'Create',
            'action' => site_url('group_user/create_action'),
	    'id_group' => set_value('id_group'),
	    'nama_group' => set_value('nama_group'),
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
		'nama_group' => $this->input->post('nama_group',TRUE),
	    );

            $this->Group_user_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('group_user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Group_user_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'group_user/group_user_form',
                'konten' => 'group_user/group_user_form',
                'button' => 'Update',
                'action' => site_url('group_user/update_action'),
		'id_group' => set_value('id_group', $row->id_group),
		'nama_group' => set_value('nama_group', $row->nama_group),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('group_user'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_group', TRUE));
        } else {
            $data = array(
		'nama_group' => $this->input->post('nama_group',TRUE),
	    );

            $this->Group_user_model->update($this->input->post('id_group', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('group_user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Group_user_model->get_by_id($id);

        if ($row) {
            $this->Group_user_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('group_user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('group_user'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_group', 'nama group', 'trim|required');

	$this->form_validation->set_rules('id_group', 'id_group', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Group_user.php */
/* Location: ./application/controllers/Group_user.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-03 04:20:45 */
/* https://jualkoding.com */