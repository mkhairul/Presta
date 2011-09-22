<?php
class Department_model extends Model {
    
    function Department_model()
    {
        parent::Model();
        $this->table_name = 'department';
        
        if(!$this->db->table_exists($this->table_name))
        {
            $CI =& get_instance();
            $CI->load->dbforge();
            $CI->dbforge->add_key('id', TRUE);
            $fields = array(
                'id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                    'auto_increment' => TRUE
                                  ),
                'parent_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE
                                  ),
                'name' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '255',
                                    'null' => FALSE,
                                  ),
                'selectable' => array(
                                    'type' => 'TINYINT',
                                    'constraint' => 5,
                                    'default' => 0
                                  ),
                'uid' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                  ),
                'timecreated' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'null' => FALSE,
                                  )
                
            );
            $CI->dbforge->add_field($fields);
            
            if ($CI->dbforge->create_table($this->table_name))
            {
                log_message('debug', "Department Table Created.. creating default entries..");
                
                $data = array(
                    'name' => 'Rector',
                    'timecreated' => strtotime('now')
                );
                $dept_id = $this->insert($data);
                
                $data = array(
                    'name' => 'ICT',
                    'parent_id' => $dept_id,
                    'timecreated' => strtotime('now')
                );
                $dept_id = $this->insert($data);
                
                $data = array(
                    'name' => 'Systems Development',
                    'parent_id' => $dept_id,
                    'timecreated' => strtotime('now')
                );
                $this->insert($data);
                
                log_message('debug', "Entries created");
            }
        }
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('department');
        return TRUE;
    }
    
    function get_top_dept()
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get($this->table_name);
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
    
    function get_total_instances($dept_id)
    {
        $this->db->where('department_id', $dept_id);
        $query = $this->db->get('user');
        return $query->num_rows();
    }
    
    function get_name($dept_id)
    {
        if(!$dept_id){ return FALSE; }
        
        $this->db->where('id', $dept_id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->name;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_parent_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->parent_id;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_list($selectable=1)
    {
        if($selectable)
        {
            $this->db->where('selectable', '1');
        }
        $this->db->order_by('parent_id', 'ASC');
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
    
    function get_list_child($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
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
    
    function get_supervisor_id($dept_id)
    {
        // get the group id for supervisor
        $CI =& get_instance();
        $CI->load->model('group_model', 'group');
        $group_id = $CI->group->get_id('supervisor');
        
        $this->db->where('department_id', $dept_id);
        $this->db->where('group_id', $group_id);
        $query = $this->db->get('user');
        
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
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        
        return $this->db->insert_id();
    }
    
    function is_selectable($id)
    {
        $this->db->where('id', $id);
        $this->db->where('selectable', 1);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? TRUE:FALSE;
    }
    
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->set($data);
        $this->db->update($this->table_name);
    }
}
?>