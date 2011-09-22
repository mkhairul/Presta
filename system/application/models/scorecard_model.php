<?php
class Scorecard_model extends Model {

    function Scorecard_model()
    {
        parent::Model();
    }
    
    function init_kpi()
    {
        // check scorecard for this year. If it doesn't exist, create one.
        $lastyear = strtotime(date('Y', strtotime('now')) . ' -1 year');
        $thisyear = strtotime(date('Y', strtotime('now')));
        
        $this->db->where('type', 'scorecard');
        $this->db->where('timeframe >=', $lastyear);
        $this->db->where('timeframe <=', $thisyear);
        $query = $this->db->get('department_user_kpi');
        
        if($query->num_rows() == 0)
        {
            // retrieve the first department created, which is the Rector who is in-charge of the Scorecard.
            $CI =& get_instance();
            $CI->load->model('department_model', 'dept');
            $dept_id = $CI->dept->get_top_dept();
            
            $data = array(
                'dept_id' => $dept_id,
                'type' => 'scorecard',
                'timeframe' => $thisyear,
                'timecreated' => strtotime('now')
            );
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
    
    function overview($kpi_id=0)
    {
        $this->db->select('pers.name as perspective_name,
                           pers.id as perspective_id,
                           str.id as strategic_id,
                           str.name as strategic_name,
                           obj.name as objective_name,
                           obj.id as objective_id,
                           mea.id as measure_id,
                           mea.name as measure_name, mea.target');
        $this->db->from('perspective as pers');
        $this->db->join('strategic as str', 'str.perspective_id = pers.id', 'left');
        $this->db->join('objective as obj', 'obj.strategic_id = str.id', 'left');
        $this->db->join('measure as mea', 'mea.objective_id = obj.id', 'left');
        $this->db->where('pers.kpi_id', $kpi_id);
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