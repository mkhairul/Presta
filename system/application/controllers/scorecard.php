<?php
class Scorecard extends Controller {

    function Scorecard()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
    }

    function index()
    {
        $this->load->model('strategic_model', 'strategic');
        $this->load->model('objective_model', 'objective');
        $this->load->model('measure_model', 'measure');
        $this->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
        
        $this->load->model('department_model', 'department');
        $this->data['department_list'] = $this->department->get_list();
        
        $this->load->model('perspective_model', 'perspective');
        //$this->data['perspective_list'] = $this->perspective->get_list();
        $this->load->model('scorecard_model', 'scorecard');
        $kpi_id = $this->scorecard->init_kpi();
        $this->data['scorecard_list'] = $this->scorecard->overview($kpi_id);
        
        $this->data['title'] = 'PMS - Scorecard Overview';
        $this->load->view('scorecard/overview', $this->data);
    }
    
    function add_entry_department()
    {
        $input_prefix = 'department';
        $rules[$input_prefix.'perspective_name'] = 'required';
        $rules[$input_prefix.'strategic_name'] = 'required';
        $rules[$input_prefix.'objective'] = 'required';
        $rules[$input_prefix.'measure'] = 'required';
        $rules[$input_prefix.'target'] = 'required';
        $rules['dept_name'] = 'required|max_length[255]';
        $rules['parent_id'] = 'required|numeric';
        
        $fields[$input_prefix.'perspective_name'] = 'Perspective Name';
        $fields[$input_prefix.'strategic_name'] = 'Strategic Name';
        $fields[$input_prefix.'objective'] = 'Objective';
        $fields[$input_prefix.'measure'] = 'Measurement';
        $fields[$input_prefix.'target'] = 'Target';
        $fields['dept_name'] = 'Department Name';
        $fields['parent_id'] = 'Department\'s Parent';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            /*------------------------------------------------------------------
             Insert data into all the tables, perspective, strategic, objective, measure (+target)
             If the respective info provides an id, update the data instead
             -----------------------------------------------------------------*/
            $timestamp = strtotime('now');
            
            $data_department = array(
                'parent_id' => $this->input->post('parent_id'),
                'name' => $this->input->post('dept_name'),
                'uid' => $this->session->userdata('uid'),
                'timecreated' => $timestamp
            );
            $this->load->model('department_model', 'department');
            $dept_id = $this->department->insert($data);
            
            /*
             Department User KPI maps between Users/Department to a KPI, since a KPI
             doesn't necessarily points to a user (it can also points to a dept without any user in it).
             The ID for this table will be a KPI ID. Which means that all elements
             that is related to a KPI will point to this ID (.e.g, perspective, objective, strategic, measure).
            */
            $this->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
            $this->load->model('kpi_model', 'kpi');
            $kpi_id = $this->kpi->init_kpi($dept_id);
            if($dept_id)
            {
                $kpi_id = $this->kpi->get_id_by_deptid($dept_id);
            }
            elseif(!($kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'))))
            {
                //echo var_dump($kpi_id);
                die('Argh!');
            }
            
            
            /*-------------------
             Perspective
             If the form passes an id and the id exists, update the entry
             ------------------*/
            $this->load->model('perspective_model', 'perspective');
            $data_perspective = array(
                'name' => $this->input->post('perspective_name', TRUE),
                'kpi_id' => $kpi_id,
                'timemodified' => $timestamp,
                'uid' => $this->session->userdata('uid')
            );
            $perspective_id = $this->perspective->insert($data_perspective);
            log_message('debug', 'Adding Perspective');
            
            
            /*-------------------
             Strategic
             If the form passes an id and the id exists, update the entry
             If a string similar to the posted value already exists, use that id
             ------------------*/
            $data_strategic = array(
                'name' => $this->input->post('strategic_name', TRUE),
                'perspective_id' => $perspective_id,
                'kpi_id' => $kpi_id,
                'timemodified' => $timestamp
            );
            $this->load->model('strategic_model', 'strategic');
            if($strategic_id = $this->input->post('strategic_id') &&
               $this->strategic->is_exists($this->input->post('strategic_id')))
            {
                $this->strategic->update($strategic_id, $data_strategic);
                log_message('debug', 'Updating Strategic');
            }
            elseif($strategic_id = $this->strategic->name_exists($this->input->post('strategic_name'), $kpi_id))
            {
                
            }
            else
            {
                $data_strategic['uid'] = $this->session->userdata('uid');
                $strategic_id = $this->strategic->insert($data_strategic);
                log_message('debug', 'Adding Strategic');
            }
            
            /*------------------------------------------------------------------
             Objective
             If the form passes an id and the id exists, update the entry
             -----------------------------------------------------------------*/
            $this->load->model('objective_model', 'objective');
            /*--------------------------------
                This is the format for inserting objective for scorecard.
                KPI is different than this.
                Refer to objective controller and see the format
            --------------------------------*/
            $data_objective = array(
                'name' => $this->input->post('objective', TRUE),
                'strategic_id' => $strategic_id,
                'timemodified' => $timestamp,
                'kpi_id' => $kpi_id
            );
            if($objective_id = $this->input->post('objective_id') &&
               $this->objective->is_exists($this->input->post('objective_id')))
            {
                $this->objective->update($objective_id, $data_objective);
                log_message('debug', 'Updating Objective');
            }
            else
            {
                $data_objective['uid'] = $this->session->userdata('uid');
                $objective_id = $this->objective->insert($data_objective);
                log_message('debug', 'Adding Objective');
            }
            
            /*-------------------
             Measure & Target
             If the form passes an id and the id exists, update the entry
             ------------------*/
            $this->load->model('measure_model', 'measure');
            $data_measure = array(
                'objective_id' => $objective_id,
                'name' => $this->input->post('measure'),
                'target' => $this->input->post('target'),
                'timemodified' => $timestamp,
                'kpi_id' => $kpi_id
            );
            if($measure_id = $this->input->post('measure_id') &&
               $this->measure->is_exists($this->input->post('measure_id')))
            {
                $this->measure->update($measure_id, $data_measure);
                log_message('debug', 'Updating Measure & Target');
            }
            else
            {
                $data_measure['uid'] = $this->session->userdata('uid');
                $measure_id = $this->measure->insert($data_measure);
                log_message('debug', 'Adding Measure & Target');
            }
            
            $this->session->set_flashdata('misc_success', 'Entry Successfully Added');
            redirect('kpi/view_by_dept/' . $kpi_id);
        }
    }
    
    function add_submit()
    {
        $rules['perspective_name'] = 'required|max_length[255]';
        $rules['strategic_name'] = 'required|max_length[255]';
        $rules['objective'] = 'required|max_length[255]';
        $rules['measure'] = 'required|max_length[255]';
        $rules['target'] = 'required|max_length[255]';
        
        $fields['perspective_name'] = 'Perspective Name';
        $fields['strategic_name'] = 'Strategic Name';
        $fields['objective'] = 'Objective';
        $fields['measure'] = 'Measurement';
        $fields['target'] = 'Target';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            /*-------------------
             Insert data into all the tables, perspective, strategic, objective, measure (+target)
             If the respective info provides an id, update the data instead
             ------------------*/
            $timestamp = strtotime('now');
            
            /*
             Department User KPI maps between Users/Department to a KPI, since a KPI
             doesn't necessarily points to a user (it can also points to a dept without any user in it).
             The ID for this table will be a KPI ID. Which means that all elements
             that is related to a KPI will point to this ID (e.g., perspective, objective, strategic, measure).
            */
            // GET THE SCORECARD(KPI) ID ASSOCIATED TO THIS YEAR
            $this->load->model('department_model', 'department');
            $dept_id = $this->department->get_top_dept();
            
            $this->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
            $thisyear = date('Y', strtotime('now'));
            $kpi_id = $this->departmentuser_kpi->get_id_by_deptid($dept_id, $thisyear);
            
            /*-------------------
             Perspective
             If the form passes an id and the id exists, update the entry
             If a string similar to the posted value already exists, use that id
             ------------------*/
            $this->load->model('perspective_model', 'perspective');
            $data_perspective = array(
                'name' => $this->input->post('perspective_name', TRUE),
                'kpi_id' => $kpi_id,
                'timecreated' => $timestamp
            );
            if($perspective_id = $this->input->post('perspective_id') &&
               $this->perspective->is_exists($this->input->post('perspective_id')))
            {
                $this->perspective->update($perspective_id, $data_perspective);
                log_message('debug', 'Updating Perspective');
            }
            elseif($perspective_id = $this->perspective->name_exists($this->input->post('perspective_name'), $kpi_id))
            {
                
            }
            else
            {
                $data_perspective['uid'] = $this->session->userdata('uid');
                $perspective_id = $this->perspective->insert($data_perspective);
                log_message('debug', 'Adding Perspective');
            }
            
            /*-------------------
             Strategic
             If the form passes an id and the id exists, update the entry
             If a string similar to the posted value already exists, use that id
             ------------------*/
            $data_strategic = array(
                'name' => $this->input->post('strategic_name', TRUE),
                'perspective_id' => $perspective_id,
                'kpi_id' => $kpi_id,
                'timemodified' => $timestamp
            );
            $this->load->model('strategic_model', 'strategic');
            if($strategic_id = $this->input->post('strategic_id') &&
               $this->strategic->is_exists($this->input->post('strategic_id')))
            {
                $this->strategic->update($strategic_id, $data_strategic);
                log_message('debug', 'Updating Strategic');
            }
            elseif($strategic_id = $this->strategic->name_exists($this->input->post('strategic_name'), $kpi_id))
            {
                
            }
            else
            {
                $data_strategic['uid'] = $this->session->userdata('uid');
                $strategic_id = $this->strategic->insert($data_strategic);
                log_message('debug', 'Adding Strategic');
            }
            
            /*-------------------
             Objective
             If the form passes an id and the id exists, update the entry
             ------------------*/
            $this->load->model('objective_model', 'objective');
            /*--------------------------------
                This is the format for inserting objective for scorecard. KPI is different than this.
                Refer to objective controller and see the format
            --------------------------------*/
            $data_objective = array(
                'name' => $this->input->post('objective', TRUE),
                'strategic_id' => $strategic_id,
                'timemodified' => $timestamp,
                'kpi_id' => $kpi_id
            );
            if($objective_id = $this->input->post('objective_id') &&
               $this->objective->is_exists($this->input->post('objective_id')))
            {
                $this->objective->update($objective_id, $data_objective);
                log_message('debug', 'Updating Objective');
            }
            else
            {
                $data_objective['uid'] = $this->session->userdata('uid');
                $objective_id = $this->objective->insert($data_objective);
                log_message('debug', 'Adding Objective');
            }
            
            /*-------------------
             Measure & Target
             If the form passes an id and the id exists, update the entry
             ------------------*/
            $this->load->model('measure_model', 'measure');
            $data_measure = array(
                'objective_id' => $objective_id,
                'name' => $this->input->post('measure'),
                'target' => $this->input->post('target'),
                'timemodified' => $timestamp,
                'kpi_id' => $kpi_id
            );
            if($measure_id = $this->input->post('measure_id') &&
               $this->measure->is_exists($this->input->post('measure_id')))
            {
                $this->measure->update($measure_id, $data_measure);
                log_message('debug', 'Updating Measure & Target');
            }
            else
            {
                $data_measure['uid'] = $this->session->userdata('uid');
                $measure_id = $this->measure->insert($data_measure);
                log_message('debug', 'Adding Measure & Target');
            }
            
            $this->session->set_flashdata('misc_success', 'Entry Successfully Added');
            redirect('scorecard');
        }
    }
    
    function update_perspective()
    {
        $rules['perspective_name'] = 'required|max_length[255]';
        $rules['perspective_id'] = 'required|numeric';
        
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
            $data = array('name' => $this->input->post('perspective_name'));
            
            $this->load->model('perspective_model', 'perspective');
            $this->perspective->update(
                $this->input->post('perspective_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Perspective Successfully Updated');
            redirect('scorecard');
        }
    }
    
    function update_strategic()
    {
        $rules['strategic_name'] = 'required|max_length[255]';
        $rules['strategic_id'] = 'required|numeric';
        
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
            $data = array('name' => $this->input->post('strategic_name'));
            
            $this->load->model('strategic_model', 'strategic');
            $this->strategic->update(
                $this->input->post('strategic_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Strategic Theme Successfully Updated');
            redirect('scorecard');
        }
    }
    
    function update_objective()
    {
        $rules['objective_name'] = 'required|max_length[255]';
        $rules['objective_id'] = 'required|numeric';
        
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
            $data = array('name' => $this->input->post('objective_name'));
            
            $this->load->model('objective_model', 'objective');
            $this->objective->update(
                $this->input->post('objective_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Objective Successfully Updated');
            redirect('scorecard');
        }
    }
    
    function update_measure()
    {
        $rules['measure_name'] = 'required|max_length[255]';
        $rules['measure_id'] = 'required|numeric';
        
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
            $data = array('name' => $this->input->post('measure_name'));
            
            $this->load->model('measure_model', 'measure');
            $this->measure->update(
                $this->input->post('measure_id'),
                $data
            );            
            
            $this->session->set_flashdata('misc_success', 'Measure Successfully Updated');
            redirect('scorecard');
        }
    }
    
    function update_target()
    {
        $rules['target_name'] = 'required|max_length[255]';
        $rules['target_id'] = 'required|numeric';
        
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
            $data = array('target' => $this->input->post('target_name'));
            
            $this->load->model('measure_model', 'measure');
            $this->measure->update(
                $this->input->post('target_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Target Successfully Updated');
            redirect('scorecard');
        }
    }
}
?>