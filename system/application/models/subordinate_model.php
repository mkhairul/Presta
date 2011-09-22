<?php
class Subordinate_model extends Model {

    function Subordinate_model()
    {
        parent::Model();
        $this->error = '';
        $this->table_name = '';
    }
    
    /*--------------------------------------------------------------------------
     Get list of users who is under the department
     If users doesn't exists
        get list of departments under the department
        get the supervisor id of those departments
     -------------------------------------------------------------------------*/
    function get_list($department_id)
    {
        if(!$department_id){ return FALSE; }
        
        // get the group id for employee
        $CI =& get_instance();
        $CI->load->model('group_model', 'group');
        $group_id = $CI->group->get_id('employee');
        
        $this->db->where('department_id', $department_id);
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('user');
        
        if($query->num_rows() > 0)
        {
            return $query;
        }
        else
        {
            //$CI->load->model('department_model', 'department');
            //$child_dept_list = $this->department->get_list_child($department_id);
            
            // get group ID for supervisors
            $group_id_supervisor = $CI->group->get_id('supervisor');
            
            /*
                SELECT * FROM department
                LEFT JOIN `user`
                ON `user`.department_id = department.id
                HAVING `user`.group_id = 2 AND department.parent_id = 5
            */
            
            $this->db->select('*');
            $this->db->from('department');
            $this->db->join('user', 'user.department_id = department.id', 'left');
            $this->db->having('user.group_id ='.$group_id_supervisor);
            $this->db->having('department.parent_id='.$department_id);
            $query = $this->db->get();
            
            return ($query->num_rows() > 0) ? $query:FALSE;
        }
    }
}
?>