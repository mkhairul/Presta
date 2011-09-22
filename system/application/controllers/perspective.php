<?php
class Perspective extends Controller{
    
    function Perspective()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
    }
    
    function index()
    {
        $this->load->model('perspective_model', 'perspective');
        $this->data['perspective_list'] = $this->perspective->get_list();
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'PMS - Add Perspective';
        $this->load->view('perspective/add_perspective', $this->data);
    }
    
    function add_submit()
    {
        $rules['name'] = 'required|max_length[255]|alpha_dash_space';
        
        $fields['name'] = 'Perspective Name';
        
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
               'name' => $this->input->post('name', TRUE),
               'timecreated' => strtotime('now'),
               'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('perspective_model', 'perspective');
            $this->perspective->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Successfully added perspective.');
            redirect('perspective');
        }
    }
}
?>