<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class KPI_lib
{
    function KPI_lib()
    {
    
    }
    
    function delete_all($uid)
    {
        
    }
    
    function retrieve_kpi_id($uid)
    {
        
    }
    
    /*--------------------------------------------------------------------------
     Get the user's group, get the user's group's name. If the user is a supervisor,
     use the user's dept_id to retrieve the KPI id.
     
     If the user doesn't have any KPI ID, initialize KPI ID. The USER MUST HAVE KPI ID!
     -------------------------------------------------------------------------*/
    
    /*--------------------------------------------------------------------------
     
    --------------------------------------------------------------------------*/
    function get_kpi_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $user_details = $query->row();
            
            $CI =& get_instance();
            $CI->load->model('group_model', 'group');
            $group_name = $CI->group->get_name($user_details->group_id);
            
            $CI->load->model('kpi_model', 'kpi');
            if(strtolower($group_name) == 'supervisor')
            {
                $kpi_id = $CI->kpi->get_id_by_deptid($user_details->department_id);
            }
            else
            {
                $kpi_id = $CI->kpi->get_id_by_uid($user_details->id);
            }
            
            if(!$kpi_id)
            {
                $CI =& get_instance();
                $CI->load->model('kpi_model', 'kpi');
                $kpi_id = $CI->kpi->init_kpi_user($user_id);
            }
            
            return $kpi_id;
        }
        else
        {
            return FALSE;
        }
    }
}
?>