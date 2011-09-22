<?php
class Dialogue extends Controller {

    function Dialogue()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
        
        $this->load->model('group_model', 'group');
        
        $this->data['current_page'] = 'dialogue';
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
    }
    
    function index()
    {
        $this->load->model('user_model', 'user');
        $kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'));
        
        $this->load->model('dialogue_model', 'dialogue');
        $this->data['dialogue_details'] = $details = $this->dialogue->get_details($kpi_id);
        
        /*
          Display the supervisor's name
          Get the user's details.
          Get the user's role (employee, supervisor, etc).
          If the user is a supervisor
            get parent department ID
                if parent department ID doesnt exist, set supervisor as none.
            get department's supervisor ID
          Else
            get the user's department id and get the current supervisor of the department.
        */
        $this->load->model('department_model', 'department');
        $this->load->model('group_model', 'group');
        
        $user_details = $this->user->get_details($this->session->userdata('uid'));
        $group_name = $this->group->get_name($user_details->group_id);
        
        if(strtolower($group_name) === 'supervisor')
        {
            // get parent department's ID
            $dept_id = $user_details->department_id;
            $parent_dept_id = $this->department->get_parent_id($dept_id);
            if($supr_id = $this->department->get_supervisor_id($parent_dept_id))
            {
                $this->data['supervisor_name'] = $this->user->get_name($supr_id);
            }
            else
            {
                $this->data['supervisor_name'] = 'Nobody';
            }
        }
        else
        {
            if($supr_id = $this->department->get_supervisor_id($user_details->department_id))
            {
                $this->data['supervisor_name'] = $this->user->get_name($supr_id);
            }
            else
            {
                $this->data['supervisor_name'] = 'Nobody';
            }
        }
        
        $this->data['title'] = 'Quaterly Performance and Developmental Dialogue';
        $this->load->view('dialogue/overview', $this->data);
    }
    
    function supervisor()
    {
        $this->data['title'] = 'Quaterly Performance and Developmental Dialogue';
        $this->load->view('dialogue/supervisor', $this->data);
    }
}
?>