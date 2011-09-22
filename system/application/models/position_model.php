<?php
class Position_model extends Model {
    
    function Position_model()
    {
        parent::Model();
        $this->table_name = 'position';
        
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
                                    'constraint' => '255'
                                  ),
                'timecreated' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'null' => FALSE,
                                  ),
                'timemodified' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'null' => FALSE,
                                  ),
                'uid' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                  )
            );
            $CI->dbforge->add_field($fields);
            
            if ($CI->dbforge->create_table($this->table_name))
            {
                log_message('debug', ucfirst($this->table_name)." Table Created.");
            }
        }
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        return TRUE;
    }
    
    function get_name($id)
    {
        $this->db->where('id', $id);
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
    
    function get_total_instances($id)
    {
        $this->db->where('position_id', $id);
        $query = $this->db->get('user');
        return $query->num_rows();
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
    
    function get_list()
    {
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
    
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->set($data);
        $this->db->update($this->table_name);
    }
}
?>