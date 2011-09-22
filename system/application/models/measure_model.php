<?php
class Measure_model extends Model {
    
    function Measure_model()
    {
        parent::Model();
        $this->table_name = 'measure';
        
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
                'objective_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE
                                  ),
                'name' => array(
                                    'type' => 'TEXT'                                    
                                  ),
                'target' => array(
                                    'type' => 'TEXT'
                                  ),
                'actual' => array(
                                    'type' => 'TEXT'
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
                log_message('debug', "Measure Table Created.");
            }
        }
    }
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        
        return $this->db->insert_id();
    }
    
    function get_name($objective_id)
    {
        $this->db->where('id', $objective_id);
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
    
    function get_desc($id)
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
    
    function get_list($objective_id=0)
    {
        if($objective_id)
        {
            $this->db->where('objective_id', $objective_id);
        }
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
    
    function get_list_kpi_id($kpi_id)
    {
        $this->db->where('kpi_id', $kpi_id);
        $query = $this->db->get($this->table_name);
        
        return ($query->num_rows() > 0) ? $query:FALSE;
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
        $status = $this->db->update($this->table_name);
    }
}
?>