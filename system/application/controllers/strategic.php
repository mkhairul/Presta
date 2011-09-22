<?php
class Strategic extends Controller{
    
    function Strategic()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
    }
    
    function index($perspective_id='')
    {
        $perspective_id = ($this->uri->segment(3, FALSE)) ? $this->uri->segment(3, FALSE):$perspective_id;
        $this->data['perspective_id'] = $perspective_id;
        
        $this->load->model('perspective_model', 'perspective');
        $this->data['perspective_list'] = $this->perspective->get_list();
        $this->data['perspective_name'] = $this->perspective->get_name($perspective_id);
        
        $this->load->model('strategic_model', 'strategic');
        $this->data['strategic_list'] = $this->strategic->get_list($perspective_id);
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'PMS - Add Strategic Theme';
        $this->load->view('strategic/add_strategic', $this->data);
    }
    
    function add_submit()
    {
        $rules['name'] = 'required|max_length[255]';
        $rules['perspective_id'] = 'required|numeric|max_length[11]';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        
        if($this->validation->run() === FALSE)
        {
            $this->index($this->input->post('perspective_id'));
        }
        else
        {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'perspective_id' => $this->input->post('perspective_id'),
                'timecreated' => strtotime('now'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('strategic_model', 'strategic');
            $this->strategic->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Successfully added strategic theme');
            redirect('strategic/index/' . $this->input->post('perspective_id'));
        }
    }
}
?>