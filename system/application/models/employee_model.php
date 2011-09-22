<?php
class Employee_model extends Model {

    function Employee_model()
    {
        parent::Model();
    }
    
    function count_employee($department_id=0)
    {
        $CI =& get_instance();
        $CI->load->model('group_model','group');
        $gid = $CI->group->get_id('employee');
        
        if($department_id)
        {
            $this->db->where('department_id', $department_id);
        }
        
        $this->db->where('group_id', $gid);
        $query = $this->db->get('user');
        return $query->num_rows();
    }
}
?>