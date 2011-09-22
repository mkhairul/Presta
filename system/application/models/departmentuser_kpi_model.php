<?php
class Departmentuser_kpi_model extends Model
{
    function Departmentuser_kpi_model()
    {
        parent::Model();
        $this->table_name = 'department_user_kpi';
        
        if(!$this->db->table_exists($this->table_name))
        {
            $CI =& get_instance();
            $CI->load->dbforge();
            $CI->dbforge->add_key('id', TRUE);
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE,
                    'auto_increment' => TRUE
                ),
                'dept_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE,
                    'unsigned' => TRUE
                ),
                'uid' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE,
                    'unsigned' => TRUE
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '150',
                    'null' => FALSE,
                ),
                'type' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '50',
                    'null' => FALSE,
                ),
                'timeframe' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE,
                ),
                'timecreated' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE,
                ),
            );
            $CI->dbforge->add_field($fields);
            
            if ($CI->dbforge->create_table($this->table_name))
            {
                log_message('debug', "Department->User KPI Table Created");
            }
        }
    }
    
    function get_id_by_deptid($id, $year='')
    {
        if($year)
        {
            $upperbound = strtotime(date('Y', strtotime($year)));
            $lowerbound = strtotime(date('Y', strtotime($year)) . ' -1 year');
            $this->db->where('timeframe >=', $lowerbound);
            $this->db->where('timeframe <=', $upperbound);
        }
        
        $this->db->where('dept_id', $id);
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
    
    function insert($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        return $this->db->insert_id();
    }
}
?>