<?php
class Perspective_model extends Model {
    
    function Perspective_model()
    {
        parent::Model();
        $this->table_name = 'perspective';
        
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
                                  ),
                'kpi_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                  ),
                
            );
            $CI->dbforge->add_field($fields);
            
            if ($CI->dbforge->create_table($this->table_name))
            {
                log_message('debug', ucfirst($this->table_name)." Table Created.");
            }
        }
    }
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        
        return $this->db->insert_id();
    }
    
    function get_name($perspective_id)
    {
        $this->db->where('id', $perspective_id);
        $query = $this->db->get('perspective');
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
    
    function get_list($user_id = 0)
    {
        if($user_id)
        {
            $this->db->where('uid', $user_id);
        }
        
        $query = $this->db->get('perspective');
        if($query->num_rows() > 0)
        {
            return $query;
        }
        else
        {
            return FALSE;
        }
    }
    
    function is_exists($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? TRUE:FALSE;
    }
    
    function name_exists($name, $kpi_id)
    {
        $this->db->like('name', $name);
        $this->db->where('kpi_id', $kpi_id);
        
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
    
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->set($data);
        $this->db->update($this->table_name);
        
        return TRUE;
    }
}
?>