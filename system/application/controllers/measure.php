<?php
class Measure extends Controller{
    
    function Measure()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
    }
    
    function index($objective_id)
    {
        $objective_id = ($objective_id) ? $objective_id:$this->uri->segment(3, FALSE);
        
        $this->load->model('objective_model', 'objective');
        $this->data['objective_id'] = $objective_id;
        $this->data['objective_name'] = $this->objective->get_name($objective_id);
        $this->data['strategic_id'] = $this->objective->get_strategic_id($objective_id);
        
        $this->load->model('measure_model', 'measure');
        $this->data['measure_list'] = $this->measure->get_list($objective_id);
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'PMS - Add Measurement';
        $this->load->view('measure/add_measure', $this->data);
    }
    
    function add_submit()
    {
        $rules['name'] = 'required|max_length[255]';
        $rules['objective_id'] = 'required|numeric|max_length[11]';
        $rules['target'] = 'max_length[255]';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        
        if($this->validation->run() === FALSE)
        {
            $this->index($this->input->post('objective_id'));
        }
        else
        {
            $data = array(
                'objective_id' => $this->input->post('objective_id'),
                'name' => $this->input->post('name', TRUE),
                'target' => $this->input->post('target'),
                'timecreated' => strtotime('now'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('measure_model', 'measure');
            $this->measure->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Successfully added Measurement');
            redirect('measure/index/' . $this->input->post('objective_id'));
        }
    }
}
?>