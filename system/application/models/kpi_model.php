<?php
class Kpi_model extends Model {

    function Kpi_model()
    {
        parent::Model();
    }
    
    /*--------------------------------------------------------------------------
     Get KPI ID by using User Id
    --------------------------------------------------------------------------*/
    function get_id_by_uid($user_id, $year='')
    {
        if($year)
        {
            $lastyear = strtotime(date('Y', strtotime($year)) . ' -1 year');
            $thisyear = strtotime(date('Y', strtotime($year)));
        }
        else
        {
            $lastyear = strtotime(date('Y', strtotime('now')) . ' -1 year');
            $thisyear = strtotime(date('Y', strtotime('now')));
        }
        
        $this->db->where('uid', $user_id);
        $this->db->where('type', 'kpi');
        $this->db->where('timeframe >=', $lastyear);
        $this->db->where('timeframe <=', $thisyear);
        $query = $this->db->get('department_user_kpi');
        
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->id;
        }
        else
        {
            return FALSE;
        }
    }
    
    /*--------------------------------------------------------------------------
     Get KPI ID by using Department Id
    --------------------------------------------------------------------------*/
    function get_id_by_deptid($dept_id, $year='')
    {
        if($year)
        {
            $lastyear = strtotime(date('Y', strtotime($year)) . ' -1 year');
            $thisyear = strtotime(date('Y', strtotime($year)));
        }
        else
        {
            $lastyear = strtotime(date('Y', strtotime('now')) . ' -1 year');
            $thisyear = strtotime(date('Y', strtotime('now')));
        }
        
        $this->db->where('dept_id', $dept_id);
        $this->db->where('type', 'kpi');
        $this->db->where('timeframe >=', $lastyear);
        $this->db->where('timeframe <=', $thisyear);
        $query = $this->db->get('department_user_kpi');
        
        //echo var_dump($this->db->last_query());
        
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->id;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_user_id($kpi_id)
    {
        $this->db->where('id', $kpi_id);
        $query = $this->db->get('department_user_kpi');
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->uid;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_dept_id($kpi_id)
    {
        $this->db->where('id', $kpi_id);
        $query = $this->db->get('department_user_kpi');
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->dept_id;
        }
        else
        {
            return FALSE;
        }
    }
    
    function init_kpi($dept_id=0)
    {
        /*----------------------------------------------------------------------
         If there is no dept_id, check the user's privilege/details.
         If the user is a supervisor, get the dept's id and use it
         Else, use the user's id.
         
         Create a KPI entry.
        ----------------------------------------------------------------------*/
        $CI =& get_instance();
        
        if(!$dept_id)
        {
            $CI->load->model('user_model', 'user');
            $group_id = $CI->user->get_groupid($this->session->userdata('uid'));
            $CI->load->model('group_model', 'group');
            $group_name = $CI->group->get_name($group_id);
            
            if(strtolower($group_name) == 'supervisor')
            {
                $dept_id = $CI->user->get_department_id($this->session->userdata('uid'));
            }
            else
            {
                $user_id = $this->session->userdata('uid');
            }
        }
        
        // check scorecard for this year. If it doesn't exist, create one.
        $lastyear = strtotime(date('Y', strtotime('now')) . ' -1 year');
        $thisyear = strtotime(date('Y', strtotime('now')));
        
        if($dept_id)
        {
            $this->db->where('dept_id', $dept_id);
        }
        else
        {
            $this->db->where('uid', $user_id);
        }
        $this->db->where('type', 'kpi');
        $this->db->where('timeframe >=', $lastyear);
        $this->db->where('timeframe <=', $thisyear);
        $query = $this->db->get('department_user_kpi');
        
        //echo $this->db->last_query();
        
        if($query->num_rows() == 0)
        {
            $CI =& get_instance();
            $CI->load->model('user_model', 'user');
            
            $data = array(
                'type' => 'kpi',
                'timeframe' => $thisyear,
                'timecreated' => strtotime('now')
            );
            if(getstr($dept_id))
            {
                $data['dept_id'] = $dept_id;
            }
            else
            {
                $data['uid'] = $user_id;
            }
            $CI->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
            $kpi_id = $CI->departmentuser_kpi->insert($data);
            
            return $kpi_id;
        }
        else
        {
            $result = $query->row();
            return $result->id;
        }
    }
    
    function init_kpi_user($user_id=0)
    {
        $dept_id = 0;
        /*----------------------------------------------------------------------
         
         Create a KPI entry.
        ----------------------------------------------------------------------*/
        $CI =& get_instance();
        
        // check scorecard for this year. If it doesn't exist, create one.
        $lastyear = strtotime(date('Y', strtotime('now')) . ' -1 year');
        $thisyear = strtotime(date('Y', strtotime('now')));
        
        if($dept_id)
        {
            $this->db->where('dept_id', $dept_id);
        }
        else
        {
            $this->db->where('uid', $user_id);
        }
        $this->db->where('type', 'kpi');
        $this->db->where('timeframe >=', $lastyear);
        $this->db->where('timeframe <=', $thisyear);
        $query = $this->db->get('department_user_kpi');
        
        //echo $this->db->last_query();
        
        if($query->num_rows() == 0)
        {
            $CI =& get_instance();
            $CI->load->model('user_model', 'user');
            
            $data = array(
                'type' => 'kpi',
                'timeframe' => $thisyear,
                'timecreated' => strtotime('now')
            );
            if(getstr($dept_id))
            {
                $data['dept_id'] = $dept_id;
            }
            else
            {
                $data['uid'] = $user_id;
            }
            $CI->load->model('departmentuser_kpi_model', 'departmentuser_kpi');
            $kpi_id = $CI->departmentuser_kpi->insert($data);
            
            return $kpi_id;
        }
        else
        {
            $result = $query->row();
            return $result->id;
        }
    }
    
    function objective_details($obj_id, $user_id)
    {
        $this->db->select('pers.name as perspective_name,
                           obj.name as objective_name,
                           obj.id as obj_id,
                           mea.name as measure_name, mea.target');
        $this->db->from('perspective AS pers');
        $this->db->join('objective as obj', 'obj.perspective_id = pers.id', 'left');
        $this->db->join('measure as mea', 'mea.objective_id = obj.id');
        $this->db->where('obj.uid', $user_id);
        $this->db->where('obj.id', $obj_id);
        $query = $this->db->get();
        
        return $query;
    }
    
    function overview($user_id)
    {
        $this->db->select('pers.name as perspective_name,
                           pers.id as perspective_id,
                           str.id as strategic_id,
                           str.name as strategic_name,
                           obj.name as objective_name,
                           obj.id as objective_id,
                           mea.id as measure_id,
                           mea.name as measure_name, mea.target, mea.actual as actual');
        $this->db->from('perspective AS pers');
        $this->db->join('strategic as str', 'str.perspective_id = pers.id', 'left');
        $this->db->join('objective as obj', 'obj.strategic_id = str.id', 'left');
        $this->db->join('measure as mea', 'mea.objective_id = obj.id');
        $this->db->where('obj.uid', $user_id);
        $query = $this->db->get();
        
        return $query;
    }
    
    /*--------------------------------------------------------------------------
     Total number of KPI in the system
    --------------------------------------------------------------------------*/ 
    function total_kpi()
    {
        $this->db->select('pers.name as perspective_name,
                           pers.id as perspective_id,
                           str.id as strategic_id,
                           str.name as strategic_name,
                           obj.name as objective_name,
                           obj.id as objective_id,
                           mea.id as measure_id,
                           mea.name as measure_name, mea.target, mea.actual as actual');
        $this->db->from('perspective AS pers');
        $this->db->join('strategic as str', 'str.perspective_id = pers.id', 'left');
        $this->db->join('objective as obj', 'obj.strategic_id = str.id', 'left');
        $this->db->join('measure as mea', 'mea.objective_id = obj.id');
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    function overview_kpi_id($kpi_id)
    {
        $this->db->select('pers.name as perspective_name,
                           pers.id as perspective_id,
                           str.id as strategic_id,
                           str.name as strategic_name,
                           obj.name as objective_name,
                           obj.id as objective_id,
                           mea.id as measure_id,
                           mea.name as measure_name, mea.target, mea.actual as actual');
        $this->db->from('perspective AS pers');
        $this->db->join('strategic as str', 'str.perspective_id = pers.id', 'left');
        $this->db->join('objective as obj', 'obj.strategic_id = str.id', 'left');
        $this->db->join('measure as mea', 'mea.objective_id = obj.id');
        $this->db->where('obj.kpi_id', $kpi_id);
        $query = $this->db->get();
        
        return ($query->num_rows() > 0) ? $query:FALSE;
    }
    
    function user_list()
    {
        $this->db->select('usr.id as user_id,
                           usr.fullname as fullname,
                           usr.department_id as department_id,
                           pers.name as perspective_name,
                           obj.name as objective_name,
                           mea.name as measure_name, mea.target as target');
        $this->db->from('`user` AS usr');
        $this->db->join('perspective AS pers', 'pers.uid = usr.id', 'left');
        $this->db->join('objective as obj', 'obj.perspective_id = pers.id', 'left');
        $this->db->join('measure as mea', 'mea.objective_id = obj.id', 'left');
        $this->db->group_by('usr.id');
        $query = $this->db->get();
        
        return $query;
    }
}
?>