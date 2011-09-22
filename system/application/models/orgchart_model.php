<?php
class Orgchart_model extends Model {

    function Orgchart_model()
    {
        parent::Model();
        $this->table_name = 'department';
    }
    
    function overview()
    {
        $this->db->where('parent_id', 0);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            return $query;
        }
        else
        {
            return FALSE;
        }
    }
    
    function child_exists($id)
    {
        $this->db->where('parent_id', $id);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? TRUE:FALSE;
    }
    
    function get_list($id)
    {
        $this->db->where('parent_id', $id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            return $query;
        }
        else
        {
            return FALSE;
        }
    }
}
?>