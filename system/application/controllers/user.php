<?php
class User extends Controller {
    
    function User()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
    }

    function index()
    {
        $this->load->model('department_model', 'department');
        $this->data['dept_list'] = $this->department->get_list();
        
        $this->load->model('group_model', 'group');
        $this->data['group_list'] = $this->group->get_list();
        
        $this->load->model('user_model', 'user');
        $this->data['user_list'] = $this->user->get_list();
        
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        
        $this->load->model('position_model', 'position');
        $this->data['position_list'] = $this->position->get_list();
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'PMS - Users';
        $this->load->view('user/overview', $this->data);
    }
    
    function add_user()
    {
        $this->load->model('department_model', 'department');
        $this->data['department_list'] = $this->department->get_list();
        
        $this->load->model('group_model', 'group');
        $this->data['group_list'] = $this->group->get_list();
        
        $this->load->model('position_model', 'position');
        $this->data['position_list'] = $this->position->get_list();
        
        $this->load->model('user_model', 'user');
        $this->data['supervisor_list'] = $this->user->get_supervisor_list();
        
        $this->data['title'] = 'PMS - Add User';
        $this->load->view('user/add_user', $this->data);
    }
    
    function add_submit()
    {
        $rules['fullname'] = 'required|max_length[255]';
        $rules['employee_id'] = 'max_length[100]';
        $rules['department_id'] = 'required|max_length[255]';
        $rules['position_id'] = 'required|numeric';
        $rules['group_id'] = 'required|max_length[255]';
        $rules['type'] = 'required';
        $rules['username'] = 'required|max_length[255]|alpha_dash';
        $rules['password'] = 'required|max_length[255]|alpha_numeric';
        $rules['confirmpassword'] = 'required|matches[password]';
        $rules['enable'] = 'required|numeric';
        
        $fields['fullname'] = 'Full Name';
        $fields['employee_id'] = 'Employee Id';
        $fields['department_id'] = 'Department';
        $fields['position_id'] = 'Position';
        $fields['group_id'] = 'Group';
        $fields['type'] = 'User Type';
        $fields['username'] = 'Username';
        $fields['password'] = 'Password';
        $fields['confirmpassword'] = 'Confirm Password';
        $fields['enable'] = 'Activate User';
        
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
            
            $this->load->model('auth_model', 'auth');
            $password = $this->auth->create_password($this->input->post('password'));
            
            $data = array(
                'fullname' => $this->input->post('fullname'),
                'employee_id' => $this->input->post('employee_id'),
                'department_id' => $this->input->post('department_id'),
                'position_id' => $this->input->post('position_id'),
                'group_id' => $this->input->post('group_id'),
                'type' => $this->input->post('type'),
                'username' => $this->input->post('username'),
                'password' => $password,
                'activated' => $this->input->post('enable'),
                'timecreated' => $timestamp,
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('user_model', 'user');
            $this->user->insert($data);
            
            $this->session->set_flashdata('misc_success', 'User successfully added.');
            redirect('user');
        }
    }
    
    
    function add_user_submit()
    {
        $rules['name'] = 'required|max_length[255]';
        $rules['department_id'] = 'required|max_length[255]';
        $rules['group_id'] = 'required|max_length[255]';
        $rules['username'] = 'required|max_length[255]|alpha_dash';
        $rules['password'] = 'required|max_length[255]|alpha_numeric';
        $rules['confirmpassword'] = 'required|matches[password]';
        
        $fields['name'] = 'Full Name';
        $fields['department_id'] = 'Department';
        $fields['group_id'] = 'Group';
        $fields['username'] = 'Username';
        $fields['password'] = 'Password';
        $fields['confirmpassword'] = 'Confirm Password';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->add_user();
        }
        else
        {
            $this->load->model('auth_model', 'auth');
            $password = $this->auth->create_password($this->input->post('password'));
            
            $data = array(
                'department_id' => $this->input->post('department_id'),
                'type' => $this->input->post('type'),
                'group_id' => $this->input->post('group_id'),
                'fullname' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'password' => $password,
                'activated' => $this->input->post('enable'),
                'timecreated' => strtotime('now'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('user_model', 'user');
            $this->user->insert($data);
            
            $this->session->set_flashdata('misc_success', 'User successfully added.');
            redirect('user');
        }
    }
    
    function change_password()
    {
        $this->load->model('group_model', 'group');
        
        $this->data['title'] = 'Presta - Change Password';
        $this->load->view('user/change_password', $this->data);
    }
    
    function change_password_submit()
    {
        $rules['password'] = 'required|max_length[50]';
        $rules['password_confirm'] = 'required|matches[password]';
        
        $fields['password'] = 'Password';
        $fields['password_confirm'] = 'Confirm Password';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->change_password();
        }
        else
        {
            $this->load->library('Authlib');
            $this->authlib->change_password($this->session->userdata('uid'),
                                            $this->input->post('password'));
            
            $this->session->set_flashdata('misc_success', 'Password Successfully Updated');
            redirect('user/change_password');
        }
    }
    
    function delete()
    {
        if($id = $this->uri->segment(3, FALSE))
        {
            $this->load->model('user_model', 'user');
            $this->user->delete($id);
            
            $this->session->set_flashdata('misc_success', 'User successfully deleted.');
            redirect('user');
        }
    }
    
    function update_position()
    {
        $rules['position_name'] = 'required|max_length[255]';
        $rules['position_id'] = 'required|numeric';
        
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
            $user_id = $this->input->post('position_id');
            
            $data = array('position_id' => $this->input->post('position_name'));
            
            $this->load->model('user_model', 'user');
            $this->user->update(
                $user_id,
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Position Successfully Updated');
            redirect('user');
        }
    }
}
?>