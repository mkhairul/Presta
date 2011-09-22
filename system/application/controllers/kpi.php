<?php
class Kpi extends Controller {

    function Kpi()
    {
        parent::Controller();
        $this->load->model('auth_model', 'auth');
        $this->auth->check();
        
        $this->data['current_page'] = 'kpi';
        
        $this->data['misc_success'] = $this->session->flashdata('misc_success');
        $this->data['misc_error'] = $this->session->flashdata('misc_error');
    }

    /*--------------------------------------------------------------------------
     Displays the KPI Overview for a user / or an admin.
     Create the KPI ID for this year (timeframe) if it doesn't exists.
     -------------------------------------------------------------------------*/
    function index()
    {
        $this->load->model('user_model', 'user');
        $this->load->model('kpi_model', 'kpi');
        $this->kpi->init_kpi();
        
        $kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'));
        $this->data['kpi_list'] = $this->kpi->overview_kpi_id($kpi_id);
        
        $this->load->model('department_model', 'department');
        
        $this->load->model('employee_model', 'employee');
        $this->data['total_employee'] = $this->employee->count_employee(
                                            $this->user->get_department_id(
                                                $this->session->userdata('uid')));
        
        $this->load->model('perspective_model', 'perspective');
        $this->data['perspective_list'] = $this->perspective->get_list();
        
        $this->data['title'] = 'PMS - KPI Overview';
        $this->load->view('kpi/overview', $this->data);
    }
    
    function view_by_dept()
    {
        $dept_id = $this->data['dept_id'] = $this->uri->segment(3, FALSE);
        $this->load->model('kpi_model', 'kpi');
        $this->kpi->init_kpi($dept_id);
        
        $this->load->model('department_model', 'department');
        $this->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
        $kpi_id = $this->departmentuser_kpi->get_id_by_deptid($dept_id);
        
        $this->load->model('kpi_model', 'kpi');
        $this->data['kpi_list'] = $this->kpi->overview_kpi_id($kpi_id);
        
        $this->load->model('user_model', 'user');
        $this->load->model('employee_model', 'employee');
        $this->data['total_employee'] = $this->employee->count_employee(
                                            $this->user->get_department_id(
                                                $this->session->userdata('uid')));
        
        $this->load->model('perspective_model', 'perspective');
        $this->data['perspective_list'] = $this->perspective->get_list();
        
        $this->data['title'] = 'PMS - KPI Overview';
        $this->load->view('kpi/overview', $this->data);
    }
    
    function view_subordinate()
    {
        $user_id = $this->uri->segment(3, FALSE);
        $this->load->model('kpi_model', 'kpi');
        $this->kpi->init_kpi_user($user_id);
        
        $this->load->model('department_model', 'department');
        $this->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
        $this->load->model('user_model', 'user');
        $kpi_id = $this->user->get_kpi_id($user_id);
        
        $this->load->model('kpi_model', 'kpi');
        $this->data['kpi_id'] = $kpi_id;
        $this->data['kpi_list'] = $this->kpi->overview_kpi_id($kpi_id);
        
        $this->load->model('user_model', 'user');
        $this->load->model('employee_model', 'employee');
        $this->data['total_employee'] = $this->employee->count_employee(
                                            $this->user->get_department_id(
                                                $this->session->userdata('uid')));
        
        $this->load->model('perspective_model', 'perspective');
        $this->data['perspective_list'] = $this->perspective->get_list();
        
        $this->data['disable_all'] = TRUE;
        $this->data['disable_back'] = site_url('kpi/subordinate');
        $this->data['view_subordinate'] = TRUE;
        
        $this->data['title'] = 'PMS - KPI Overview';
        $this->load->view('kpi/overview_subordinate', $this->data);
    }
    
    function add_submit()
    {
        $rules['perspective'] = 'required|max_length[255]';
        $rules['strategic_name'] = 'required|max_length[255]';
        $rules['objective'] = 'required';
        $rules['measure'] = 'required';
        $rules['target'] = 'required';
        $rules['actual'] = '';
        
        $fields['perspective'] = 'Perspective';
        $fields['strategic_name'] = 'Strategic';
        $fields['objective'] = 'Objective';
        $fields['measure'] = 'Measure';
        $fields['target'] = 'Target';
        $fields['actual'] = 'Actual';
        
        $this->load->library('validation');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
        
        if($this->validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $timestamp = strtotime('now');
            
            $dept_id = $this->uri->segment(3, FALSE);
            $this->load->model('user_model', 'user');
            $this->load->model('kpi_model', 'kpi');
            
            if($dept_id)
            {
                $kpi_id = $this->kpi->get_id_by_deptid($dept_id);
            }
            elseif(!($kpi_id = $this->user->get_kpi_id($this->session->userdata('uid'))))
            {
                //echo var_dump($kpi_id);
                die('Argh!');
            }
            
            /*------------------------------------------------------------------
             Insert data into the appropriate tables.
             Perspective, objective, measure, target and actual.
             -----------------------------------------------------------------*/
            $this->load->model('perspective_model', 'perspective');
            $data_perspective = array(
                'name'          => $this->input->post('perspective', TRUE),
                'timecreated'   => $timestamp,
                'kpi_id'        => $kpi_id,
                'uid'           => $this->session->userdata('uid')
            );
            if($perspective_id = $this->perspective->name_exists($this->input->post('perspective_name'), $kpi_id))
            {
                
            }
            else
            {
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

            $this->load->model('objective_model', 'objective');
            $data_objective = array(
                'name'          => $this->input->post('objective', TRUE),
                'strategic_id'  => $strategic_id,
                'timecreated'   => $timestamp,
                'kpi_id'        => $kpi_id,
                'uid'           => $this->session->userdata('uid')
            );
            if($objective_id = $this->objective->name_exists($this->input->post('objective'), $kpi_id))
            {
                
            }
            else
            {
                $objective_id = $this->objective->insert($data_objective);
                log_message('debug', 'Adding Objective');   
            }
            
            // Put in dummy data for actual, even though I could make it by default in the column level, but
            // I didn't and I don't know why
            if($this->input->post('actual'))
            {
                $actual = '-';
            }
            else
            {
                $actual = $this->input->post('actual');
            }
            
            $this->load->model('measure_model', 'measure');
            $data_measure = array(
                'objective_id'  => $objective_id,
                'name'          => $this->input->post('measure', TRUE),
                'target'        => $this->input->post('target'),
                'actual'        => $actual,
                'timecreated'   => $timestamp,
                'uid'           => $this->session->userdata('uid'),
                'kpi_id'        => $kpi_id
            );
            $measure_id = $this->measure->insert($data_measure);
            log_message('debug', 'Adding Measure & Target');
            
            $this->session->set_flashdata('misc_success', 'Entry Successfully Added');
            if($dept_id)
            {
                redirect('kpi/view_by_dept/' . $dept_id);
            }
            else
            {
                redirect('kpi');
            }
        }
    }
    
    function details()
    {
        if($obj_id = $this->uri->segment(3, FALSE))
        {
            $this->load->model('kpi_model','kpi');
            $this->data['details'] = $this->kpi->objective_details($obj_id, $this->session->userdata('uid'));
            $this->load->view('kpi/details', $this->data);
        }
    }
    
    function subordinate()
    {
        $this->load->model('subordinate_model', 'subordinate');
        $this->load->model('user_model', 'user');
        $this->load->model('position_model', 'position');
        
        // get department id
        $department_id = $this->user->get_department_id($this->session->userdata('uid'));
        $this->data['subordinate_list'] = $this->subordinate->get_list($department_id);
        
        $this->data['title'] = 'View Subordinate';
        $this->load->view('kpi/subordinate', $this->data);
    }
    
    function ajax_subordinate_get_details()
    {
        if($user_id = $this->input->post('id'))
        {
            $this->load->model('dialogue_model', 'dialogue');
            $this->load->model('user_model', 'user');
            $kpi_id = $this->user->get_kpi_id($user_id);
            if($details = $this->dialogue->get_details($kpi_id))
            {
                $data = array(
                    'first' => $details->first_quarter,
                    'second' => $details->second_quarter,
                    'third' => $details->third_quarter,
                    'final' => $details->final_review,
                    'rating' => $details->final_rating
                );
                
                echo json_encode(array('status' => 'success', 'data' => $data));
            }
            else
            {
                echo json_encode(array('status' => 'error'));
            }
        }
    }
    
    function subordinate_quarter_save()
    {
        if($dialogue = $this->uri->segment(3,FALSE))
        {
            $rules['content'] = 'required';
            $rules['subordinate_id'] = 'required|numeric';
        
            $fields['content'] = 'Content';
            
            $this->load->library('validation');
            $this->validation->set_rules($rules);
            $this->validation->set_fields($fields);
            
            if($this->validation->run() === FALSE)
            {
                $this->subordinate();
            }
            else
            {
                $timestamp = strtotime('now');
                $this->load->model('user_model', 'user');
                // get_kpi_id will automatically init the user's kpi and returns a kpi_id
                if(!$kpi_id = $this->user->get_kpi_id($this->input->post('subordinate_id')))
                {
                    //echo 'subordinate_id = ' . $this->input->post('subordinate_id');
                    //echo var_dump($kpi_id);
                    die('ARGH!');
                }
                
                $data = array(
                    'timecreated' => $timestamp,
                    'kpi_id' => $kpi_id,
                    'uid' => $this->session->userdata('uid')
                );
                
                if($dialogue == 1)
                {
                    $data['first_quarter'] = $this->input->post('content');
                }
                elseif($dialogue == 2)
                {
                    $data['second_quarter'] = $this->input->post('content');
                }
                elseif($dialogue == 3)
                {
                    $data['third_quarter'] = $this->input->post('content');
                }
                elseif($dialogue == 'final')
                {
                    $data['final_review'] = $this->input->post('content');
                    $data['final_rating'] = $this->input->post('rating');
                }
                
                $this->load->model('dialogue_model', 'dialogue');
                if($this->dialogue->exists($kpi_id))
                {
                    $this->dialogue->update($kpi_id, $data);
                }
                else
                {
                    $this->dialogue->insert($data);
                }
                
                
                $this->session->set_flashdata('misc_success', 'Dialogue Saved');
                
                redirect('kpi/subordinate');
            }
        }
        else
        {
            echo 'Argh!';
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
            redirect('kpi');
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
            redirect('kpi');
        }
    }
    
    function update_objective()
    {
        $rules['objective_name'] = 'required';
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
            redirect('kpi');
        }
    }
    
    function update_measure()
    {
        $rules['measure_name'] = 'required';
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
            redirect('kpi');
        }
    }
    
    function update_actual()
    {
        $rules['actual_name'] = 'required';
        $rules['actual_id'] = 'required|numeric';
        
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
            $data = array('actual' => $this->input->post('actual_name'));
            
            $this->load->model('measure_model', 'measure');
            $this->measure->update(
                $this->input->post('actual_id'),
                $data
            );
            
            $this->session->set_flashdata('misc_success', 'Actual Successfully Updated');
            redirect('kpi');
        }
    }
    
    function update_target()
    {
        $rules['target_name'] = 'required';
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
            redirect('kpi');
        }
    }
    
    function view_list()
    {
        $this->load->model('kpi_model', 'kpi');
        $this->data['user_kpi_list'] = $this->kpi->user_list();
        
        $this->load->model('user_model', 'user');
        $this->load->model('objective_model','objective');
        $this->load->model('department_model','department');
        
        $this->data['title'] = 'PMS - KPI User List';
        $this->load->view('kpi/view_list', $this->data);
    }
}
?>