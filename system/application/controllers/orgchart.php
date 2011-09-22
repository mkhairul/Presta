<?php
class Orgchart extends Controller {

    function Orgchart()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
    }

    function index()
    {
        $this->load->model('department_model', 'department');
        $this->load->model('group_model', 'group');
        $this->load->model('orgchart_model', 'orgchart');
        $this->data['orgtree'] = $this->orgchart->overview();

        $this->data['misc_error'] = $this->session->flashdata('misc_error');
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['title'] = 'Organisation Chart';
        $this->load->view('orgchart/org_chart', $this->data);
    }
    
    function ajax_org_tree()
    {
        $this->load->model('orgchart_model', 'orgchart');
        
        if($this->input->post('root') == 'source')
        {
            $orgchart_list = $this->orgchart->overview();
        }
        else
        {
            $orgchart_list = $this->orgchart->get_list($this->input->post('root'));
        }
        
        $data = array();
        foreach($orgchart_list->result() as $row)
        {
            $tmp = array();
            if($this->orgchart->child_exists($row->id))
            {
                $tmp['hasChildren'] = true;
                $tmp['id'] = $row->id;
            }
            $tmp['text'] = $row->name . '<a class="view" href="'.site_url('kpi/view_by_dept/'.$row->id).'"></a>';
            $data[] = $tmp;
        }
        
        echo json_encode($data);
    }
}