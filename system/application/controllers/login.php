<?php
class Login extends Controller {

    function Login()
    {
        parent::Controller();
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['login_error'] = $this->session->flashdata('login_error');
        
        $this->load->model('user_model', 'user');
    }

    function index()
    {
        $this->load->model('department_model', 'department');
        $this->data['dept_list'] = $this->department->get_list();
        
        $this->load->model('position_model', 'position');
        $this->data['position_list'] = $this->position->get_list();
        
        $this->data['supervisor_list'] = $this->user->get_supervisor_list();
        
        $this->load->model('group_model', 'group');
        $this->data['group_list'] = $this->group->get_list_for_registration();
        
        $this->data['title'] = 'Presta - Users';
        $this->load->view('login/login_page', $this->data);
    }
    
    function feedback()
    {
        $this->data['title'] = 'Presta - Feedback Page!';
        $this->load->view('login/feedback', $this->data);
    }
    
    function login_submit()
    {
        $rules['username'] = 'required|max_length[100]';
        $rules['password'] = 'required|max_length[50]';
        
        $fields['username'] = 'Username';
        $fields['password'] = 'Password';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        $this->load->library('authlib');
        
        if(($this->validation->run() === FALSE) || ($this->authlib->login() === FALSE))
        {
            $this->data['login_error'] = $this->authlib->error;
            $this->index();
        }
        else
        {
            $this->session->set_flashdata('login_success', 'You are logged in!');
            $this->_login_redirect();
        }
    }
    
    function _login_redirect()
    {
        ($this->user->get_type($this->session->userdata('uid')) == 'corporate') ? redirect('scorecard'):redirect('kpi');
    }
    
    function logout()
    {
        $this->load->model('auth_model', 'auth');
        $this->auth->logout('login');
    }
    
    function register()
    {
        $rules['fullname'] = 'required|max_length[255]';
        $rules['employee_id'] = 'max_length[255]';
        $rules['department_id'] = 'required|max_length[255]';
        $rules['position_id'] = 'required|max_length[255]';
        $rules['group_id'] = 'required|max_length[255]';
        $rules['username_reg'] = 'required|max_length[255]|alpha_dash';
        $rules['password_reg'] = 'required|max_length[255]';
        $rules['confirm'] = 'required|matches[password_reg]';
        
        //$fields[''] = '';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        //$this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->session->set_flashdata('misc_error', $this->validation->error_string);
            $this->index();
        }
        else
        {
            $timestamp = strtotime('now');
            
            // Get the supervisor of the department selected
            $this->load->model('department_model', 'department');
            $report_to = $this->department->get_supervisor_id($this->input->post('department'));
            
            // Get the group_id for an employee
            $this->load->model('group_model', 'group');
            $group_id = $this->group->get_id('employee');
            
            $this->load->model('auth_model', 'auth');
            $password = $this->auth->create_password($this->input->post('password_reg'));
            $data = array(
                'fullname' => $this->input->post('fullname', TRUE),
                'employee_id' => $this->input->post('employee_id', TRUE),
                'department_id' => $this->input->post('department_id'),
                'group_id' => $this->input->post('group_id'),
                'position_id' => $this->input->post('position'),
                'username' => $this->input->post('username_reg'),
                'password' => $password,
                'timecreated' => $timestamp,
                'activated' => 1
            );
            
            $this->load->model('user_model', 'user');
            $this->user->insert($data);
            
            $this->session->set_flashdata('misc_success', 'You account have been created, please login');
            redirect('login');
        }
    }
}
?>