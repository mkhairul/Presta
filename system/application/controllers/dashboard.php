<?php
class Dashboard extends Controller {

    function Dashboard()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
        
        $this->load->model('kpi_model', 'kpi');
        $this->load->model('user_model', 'user');
    }

    /*--------------------------------------------------------------------------
     If the user is an admin, redirect to an admin dashboard page.
     -------------------------------------------------------------------------*/
    function index()
    {
        // Get User Group ID
        $group_id = $this->session->userdata('group_id');
        
        $this->load->model('group_model', 'group');
        if($group_id === $this->group->get_id('admin'))
        {
            $path = 'dashboard/admin';
        }
        
        // Set the page's main title
        $this->data['title'] = 'Dashboard';
        
        if(getstr($path))
        {
            $this->load->view($path, $this->data);
        }
    }
}
?>