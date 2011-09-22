<?php
class Department extends Controller {
    
    function Department()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check_admin();
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
    }

    function index()
    {
        $this->load->model('department_model', 'department');
        $this->data['department_list'] = $this->department->get_list();
        
        $this->data['title'] = 'PMS - Add Department';
        $this->load->view('department/add_dept', $this->data);
    }
    
    function add_submit()
    {
        $rules['dept_name'] = 'required|max_length[255]';
        $rules['parent_id'] = 'numeric';
        $rules['selectable'] = 'numeric';
        
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
                'parent_id' => $this->input->post('parent_id'),
                'selectable' => $this->input->post('selectable'),
                'uid' => $this->session->userdata('uid'),
                'timecreated' => strtotime('now')
            );
            
            $this->load->model('department_model', 'department');
            $this->department->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Department Successfully Added');
            redirect('department');
        }
    }
    
    function edit_submit()
    {
        $rules['dept_name'] = 'required|max_length[255]';
        $rules['dept_id'] = 'required|numeric';
        $rules['parent_id'] = 'numeric';
        $rules['selectable'] = 'numeric';
        
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
            //$selectable = ($this->input->post('selectable')) ? $this->input->post('selectable'):0;
            
            $data = array(
                'name' => $this->input->post('dept_name'),
                'parent_id' => $this->input->post('parent_id'),
                'selectable' => $this->input->post('selectable'),
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
            $this->load->model('department_model', 'department');
            $this->department->delete($id);
            
            redirect('department');
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