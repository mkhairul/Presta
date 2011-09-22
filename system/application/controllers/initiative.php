<?php
class Initiative extends Controller {

    function Initiative()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
        
        $this->data['current_page'] = 'initiative';
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
    }
    
    function index()
    {
        $this->load->model('department_model', 'department');
        $this->load->model('user_model', 'user');
        $this->load->model('measure_model', 'measure');
        $this->load->model('initiative_model', 'init');

        $kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'));
        $this->data['measure_list'] = $this->measure->get_list_kpi_id($kpi_id);

        $this->data['init_list'] = $this->init->get_list_kpi_id($kpi_id);
        
        $this->data['title'] = 'Initiative';
        $this->load->view('initiative/overview', $this->data);
    }
    
    function overview_subordinate()
    {
        if(!$user_id = $this->uri->segment(3,FALSE))
        {
            die('Argh!');
        }
        
        $this->load->model('department_model', 'department');
        $this->load->model('user_model', 'user');
        $this->load->model('measure_model', 'measure');
        $this->load->model('initiative_model', 'init');

        $kpi_id = $this->user->get_kpi_id($user_id);
        $this->data['kpi_id'] = $kpi_id;
        $this->data['measure_list'] = $this->measure->get_list_kpi_id($kpi_id);

        $this->data['init_list'] = $this->init->get_list_kpi_id($kpi_id);
        
        $this->data['disable_all'] = TRUE;
        $this->data['disable_back'] = site_url('kpi/subordinate');
        $this->data['view_subordinate'] = TRUE;
        
        $this->data['title'] = 'Initiative';
        $this->load->view('initiative/overview_subordinate', $this->data);
    }
    
    function add_submit()
    {
        $rules['measure'] = 'required';
        $rules['action'] = 'required';
        $rules['status'] = 'required|numeric';
        
        $fields['measure'] = 'Measure';
        $fields['action'] = 'Action';
        $fields['status'] = 'Status';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $timestamp = strtotime('now');
            
            $this->load->model('user_model', 'user');
            $kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'));
            
            $data = array(
                'action' => $this->input->post('action', TRUE),
                'status' => $this->input->post('status'),
                'timecreated' => $timestamp,
                'uid' => $this->session->userdata('uid'),
                'kpi_id' => $kpi_id
            );
            
            // Check if a measure with the same name already exists.
            $this->load->model('measure_model', 'measure');
            if($measure_id = $this->measure->name_exists($this->input->post('measure'), $kpi_id))
            {
                $data['measure_id'] = $measure_id;
            }
            else
            {
                $data['measure_description'] = $this->input->post('measure', TRUE);
            }
            $this->load->model('initiative_model', 'init');
            $this->init->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Successfully Added');
            redirect('initiative');
        }
    }
    
    function update_action()
    {
        $rules['action'] = 'required';
        $rules['action_id'] = 'required|numeric';
        
        //$fields[''] = '';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        //$this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $timestamp = strtotime('now');
            
            $data = array(
                'action'        => $this->input->post('action'),
                'timemodified'  => $timestamp
            );
            
            $this->load->model('initiative_model', 'init');
            $this->init->update(
                $this->input->post('action_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Action Successfully Updated');
            redirect('initiative');
        }
    }
    
    function update_measure()
    {
        $rules['measure'] = 'required';
        $rules['measure_id'] = 'required|numeric';
        
        //$fields[''] = '';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        //$this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $timestamp = strtotime('now');
            
            $this->load->model('user_model', 'user');
            $kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'));
            
            $data = array(
                'timemodified' => $timestamp
            );
            
            // Check if a measure with the same name already exists.
            $this->load->model('measure_model', 'measure');
            if($measure_id = $this->measure->name_exists($this->input->post('measure'), $kpi_id))
            {
                $data['measure_id'] = $measure_id;
                $data['measure_description'] = '';
            }
            else
            {
                $data['measure_description'] = $this->input->post('measure', TRUE);
                $data['measure_id'] = '';
            }
            
            $this->load->model('initiative_model', 'init');
            $this->init->update(
                $this->input->post('measure_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Measurement Successfully Updated');
            redirect('initiative');
        }
    }
    
    function update_status()
    {
        $rules['status'] = 'required';
        $rules['status_id'] = 'required|numeric';
        
        //$fields[''] = '';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        //$this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $timestamp = strtotime('now');
            
            $data = array(
                'status'        => $this->input->post('status'),
                'timemodified'  => $timestamp
            );
            
            $this->load->model('initiative_model', 'init');
            $this->init->update(
                $this->input->post('status_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Status Successfully Updated');
            redirect('initiative');
        }
    }
}
?>