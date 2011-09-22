<?php
class Dialogue_model extends Model {
    
    function Dialogue_model()
    {
        parent::Model();
        $this->table_name = 'dialogue';
        
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
                'first_quarter' => array(
                                    'type' => 'TEXT'
                                  ),
                'second_quarter' => array(
                                    'type' => 'TEXT'
                                  ),
                'third_quarter' => array(
                                    'type' => 'TEXT'
                                  ),
                'final_review' => array(
                                    'type' => 'TEXT'
                                  ),
                'final_rating' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
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
                'kpi_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
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
    
    function get_details($kpi_id)
    {
        $this->db->where('kpi_id', $kpi_id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result;
        }
        else
        {
            return FALSE;
        }
    }
    
    function exists($kpi_id)
    {
        $this->db->where('kpi_id', $kpi_id);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? TRUE:FALSE;
    }
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        return $this->db->insert_id();
    }
    
    function update($id, $data)
    {
        $this->db->where('kpi_id', $id);
        $this->db->set($data);
        $this->db->update($this->table_name);
        return TRUE;
    }
}
?>