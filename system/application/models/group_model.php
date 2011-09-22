<?php
class Group_model extends Model {
    
    function Group_model()
    {
        parent::Model();
        $this->table_name = 'group';
        
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
                'name' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '255',
                                    'null' => FALSE,
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
                log_message('debug', "Group Table Created.. creating default entries..");
                
                $data = array(
                    'name' => 'Admin',
                    'timecreated' => strtotime('now')
                );
                $this->db->insert($this->table_name, $data);
                $data = array(
                    'name' => 'Employee',
                    'timecreated' => strtotime('now')
                );
                $this->db->insert($this->table_name, $data);
                $data = array(
                    'name' => 'Supervisor',
                    'timecreated' => strtotime('now')
                );
                $this->db->insert($this->table_name, $data);
                
                log_message('debug', "Entries Created created");
            }
        }
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('group');
    }
    
    function get_name($group_id)
    {
        $this->db->where('id', $group_id);
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
    
    function get_id($group_name)
    {
        $this->db->where('LCASE(name)', strtolower($group_name));
        $query = $this->db->get('group');
        $result = $query->row();
        return $result->id;
    }
    
    function get_list()
    {
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
    
    function get_list_for_registration()
    {
        $this->db->where('name !=', 'admin');
        $this->db->order_by('name', 'ASC');
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
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
    }
}
?>