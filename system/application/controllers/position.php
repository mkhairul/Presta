<?php
class Position extends Controller {
    
    function Position()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
    }

    function index()
    {
        $this->load->model('position_model', 'position');
        $this->data['position_list'] = $this->position->get_list();
        
        $this->data['title'] = 'PMS - Add Position';
        $this->load->view('position/position_add', $this->data);
    }
    
    function add_submit()
    {
        $rules['name'] = 'required|max_length[255]';
        
        $fields['name'] = 'Position Name';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $data = array(
                'name' => $this->input->post('name'),
                'uid' => $this->session->userdata('uid'),
                'timecreated' => strtotime('now')
            );
            
            $this->load->model('position_model', 'position');
            $this->position->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Position Successfully Added');
            redirect('position');
        }
    }
    
    function edit_submit()
    {
        $rules['dept_name'] = 'required|max_length[255]';
        $rules['dept_id'] = 'required|numeric';
        
        $fields['dept_name'] = 'Department Name';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $data = array(
                'name' => $this->input->post('dept_name'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('department_model', 'department');
            $this->department->update($this->input->post('dept_id'), $data);
            
            $this->session->set_flashdata('misc_success', 'Department Successfully Updated');
            redirect('department');
        }
    }
    
    function delete()
    {
        if($id = $this->uri->segment(3, FALSE))
        {
            $this->load->model('position_model', 'position');
            $this->position->delete($id);
            
            redirect('position');
        }
    }
    
    function edit()
    {
        if($department_id = $this->uri->segment(3, FALSE))
        {
            $this->data['department_id'] = $department_id;
            $this->load->model('department_model', 'department');
            $this->data['department_list'] = $this->department->get_list();
            
            $this->data['title'] = 'PMS - Edit Department';
            $this->load->view('department/edit_dept', $this->data);
        }
        else
        {
            redirect('department');
        }
    }
}
?>