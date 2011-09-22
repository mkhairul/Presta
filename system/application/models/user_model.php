<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends Model {

    function User_model()
    {
        parent::Model();
        $this->table_name = strtolower('User');

        // Create the basic user table
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
                'department_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                    'default' => '0'
                                  ),
                'position_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                    'default' => '0'
                                  ),
                'type' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '100'
                                  ),
                'group_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                    'default' => '0'
                                  ),
                'fullname' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '255',
                                    'null' => FALSE,
                                  ),
                'employee_id' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '255',
                                    'null' => FALSE,
                                  ),
                'group_id' => array(
                                    'type' => 'INT',
                                    'constraint' => 11,
                                    'unsigned' => TRUE,
                                    'default' => '0'
                                  ),
                'reports_to' => array(
                                    'type' =>'INT',
                                    'constraint' => 11,
                                    'null' => FALSE,
                                  ),
				'username' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '255',
                                    'null' => FALSE,
                                  ),
                'password' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '150',
                                    'null' => FALSE,
                                  ),
                'email' => array(
                                    'type' => 'VARCHAR',
                                    'constraint' => '150',
                                    'null' => FALSE,
                                  ),
                'activated' => array(
                                    'type' => 'TINYINT',
                                    'constraint' => '1',
                                    'default' => 1,
                                    'null' => FALSE,
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
                log_message('debug', "User Table Created.. creating default account..");
                
                $CI->load->model('auth_model', 'auth');
                $password = $CI->auth->create_password('qwe123');
                $data = array(
                    'group_id' => 1,
                    'type' => 'corporate',
                    'fullname' => 'Administrator',
                    'username' => 'admin',
                    'password' => $password,
                    'email' => 'mkhairul@gmail.com',
                    'timecreated' => strtotime('now')
                );
                $this->db->insert($this->table_name, $data);
                
                log_message('debug', "Admin account created");
            }
        }
    }
    
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        return TRUE;
    }
    
    function get_department_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->department_id;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_details($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? $query->row():FALSE;
    }
    
    function get_groupid($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->group_id;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_user($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get($this->table_name);
        return ($query->num_rows() > 0) ? $query->row():FALSE;
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

    function get_name($id)
    {
        if(!$id){ return FALSE; }

        $this->db->where('id', $id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->fullname;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_supervisor_list()
    {
        $CI =& get_instance();
        $CI->load->model('group_model', 'group');
        $group_id = $CI->group->get_id('supervisor');
        
        $this->db->where('group_id', $group_id);
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
    
    function get_supervisor_name($dept_id)
    {
        $CI =& get_instance();
        $CI->load->model('group_model', 'group');
        $group_id = $CI->group->get_id('supervisor');
        
        $this->db->where('group_id', $group_id);
        $this->db->where('department_id', $dept_id);
        $query = $this->db->get($this->table_name);
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->fullname;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_type($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('user');
    
        if($query->num_rows() > 0)
        {
            $result = $query->row();
            return $result->type;
        }
        else
        {
            return FALSE;
        }
    }
    
    /*--------------------------------------------------------------------------
     Get the user's group, get the user's group's name. If the user is a supervisor,
     use the user's dept_id to retrieve the KPI id.
     
     If the user doesn't have any KPI ID, initialize KPI ID. The USER MUST HAVE KPI ID!
     -------------------------------------------------------------------------*/
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
	
	function total($all=0)
	{
		if(!$all)
		{
			$this->db->where('username !=', 'admin');
		}
		$query = $this->db->get($this->table_name);
		return $query->num_rows();
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
    }
}
?>