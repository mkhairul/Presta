<?php
class Initiative_model extends Model {
    
    function Initiative_model()
    {
        parent::Model();
        $this->table_name = 'initiative';
        
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
                'measure_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                  ),
                'measure_description' => array(
                                    'type' => 'TEXT'
                                  ),
                'action' => array(
                                    'type' => 'TEXT'
                                  ),
                'status' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => 10
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
    
    function get_list()
    {
        
    }
    
    function get_list_kpi_id($kpi_id)
    {
        $this->db->where('kpi_id', $kpi_id);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? $query:FALSE;
    }
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        
        return $this->db->insert_id();
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