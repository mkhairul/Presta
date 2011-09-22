<?php
class Group extends Controller {

    function index()
    {
        $this->load->model('auth_model', 'auth');
        $this->auth->check_admin();
        
        $this->load->model('group_model', 'group');
        $this->data['group_list'] = $this->group->get_list();
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'PMS - Add Group';
        $this->load->view('group/add_group', $this->data);
    }
    
    function add_submit()
    {
        $rules['name'] = 'required|max_length[255]';
        
        $fields['name'] = 'Group Name';
        
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
                'timecreated' => strtotime('now'),
                'uid' => $this->session->userdata('uid')
            );
            
            $this->load->model('group_model', 'group');
            $this->group->insert($data);
            
            $this->session->set_flashdata('misc_success', 'Group Successfully Added');
            redirect('group');
        }
    }
    
    function delete()
    {
        if($id = $this->uri->segment(3,FALSE))
        {
            $this->load->model('group_model', 'group');
            $this->group->delete($id);
            
            redirect('group');
        }
    }
}
?>