<?php
class Objective extends Controller {
    
    function Objective()
    {
        parent::Controller();
        
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
    }
    
    /*------------------------------------------------------------------
        Form to add objective for scorecard
    -------------------------------------------------------------------*/
    function index($strategic_id='')
    {
        $strategic_id = ($strategic_id) ? $strategic_id:$this->uri->segment(3, FALSE);
        $this->load->model('strategic_model', 'strategic');
        $this->data['strategic_id'] = $strategic_id;
        $this->data['strategic_name'] = $this->strategic->get_name($strategic_id);
        $this->data['perspective_id'] = $this->strategic->get_perspective_id($strategic_id);
        
        $this->load->model('objective_model', 'objective');
        $this->data['objective_list'] = $this->objective->get_list($strategic_id);
        
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'PMS - Add Objective';
        $this->load->view('objective/add_objective', $this->data);
    }
    
    function add_kpi($perspective_id='')
    {
        $perspective_id = ($perspective_id) ? $perspective_id:$this->uri->segment(3, FALSE);
        $this->load->model('perspective_model', 'perspective');
        $this->data['perspective_list'] = $this->perspective->get_list();
        $this->data['perspective_id'] = $perspective_id;
        
        $this->load->model('objective_model', 'objective');
        $this->data['objective_list'] = $this->objective->get_list_perspective($perspective_id, $this->session->userdata('uid'));
        
        $this->load->view('objective/add_kpi', $this->data);
    }
    
    function add_kpi_submit()
    {
        $rules['name'] = 'required';
        $rules['perspective_id'] = 'required|numeric|max_length[11]';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        
        if($this->validation->run() === FALSE)
        {
            $this->add_kpi($this->input->post('perspective_id'));
        }
        else
        {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'perspective_id' => $this->input->post('perspective_id'),
                'timecreated' => strtotime('now'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('objective_model', 'objective');
            $this->objective->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Successfully added Objective');
            redirect('objective/add_kpi/' . $this->input->post('perspective_id'));
        }
    }
    
    function add_submit()
    {
        $rules['name'] = 'required';
        $rules['strategic_id'] = 'required|numeric|max_length[11]';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        
        if($this->validation->run() === FALSE)
        {
            $this->index($this->input->post('strategic_id'));
        }
        else
        {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'strategic_id' => $this->input->post('strategic_id'),
                'timecreated' => strtotime('now'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('objective_model', 'objective');
            $this->objective->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Successfully added Objective');
            redirect('objective/index/' . $this->input->post('strategic_id'));
        }
    }
}
?>