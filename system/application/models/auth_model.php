<?php
class Auth_model extends Model {

    function Auth_model()
    {
        parent::Model();
        $this->error = '';
    }
    
    function authenticate( $username=null, $password=null )
    {
        if(!$username or !$password)
        {
            $this->error = 'Please insert a username and/or password.';
            return FALSE;
        }
        
        $this->status	= FALSE;
        $this->username	= $username;
        $this->password	= $password;

        $this->db->where(array('username' 	=> $this->username));
        $query = $this->db->get('user');
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row();
            if(((int)$row->activated) !== 0)
            {
                $salt = substr($this->password,0,2);
                $this->load->library('encrypt');
                if ( $this->encrypt->sha1($this->password . $salt) == $row->password )
                {
                    $this->status 	= TRUE;
                    $this->user_id 	= $row->id;
                    $this->group_id		= $row->group_id;
                    $this->fullname = $row->fullname;
                }else{
                    $this->status = FALSE;
                    $this->error = 'Username and password does not match';
                }
            }
            else
            {
                $this->error = 'Account activation still pending. Please click on the link sent to your email.';
                $this->status = FALSE;
            }
        }
        else
        {
            $this->error = 'Incorrect Username or Password.';
        }

        //$this->db->_close();
        return $this->status;
    }
    
    function check($page='login')
    {
        if(!$this->is_authenticated())
        {
            redirect($page);
        }
    }
    
    function check_admin()
    {
        
    }
    
    function create_password($password='')
    {
        $salt = substr($password,0,2);
        $this->load->library('encrypt');
        $password = $this->encrypt->sha1($password . $salt);

        return $password;
    }
    
    function is_authenticated()
    {
        $status = $this->session->userdata('username');
        return (!empty($status)) ? TRUE : FALSE;
    }
    
    function login($username='',$password='')
    {
        $username = ($username) ? $username : $this->input->post('username', true);
        $password = ($password) ? $password : $this->input->post('password', true);
        log_message('debug', "Username: $username and Password: $password received");

        if ( $this->authenticate($username, $password) )
        {
            log_message('debug', "User is successfully authenticated.");
            $name = $this->fullname;
            $this->session->set_userdata(
                array(
                    'username' 	=> $username,
                    'name'	=> $name,
                    'user_id'	=> $this->user_id,
                    'group_id'		=> $this->group_id,
                ));
            return true;
        }
        else
        {
            log_message('debug', "User failed authentication.");
            return false;
        }
    }
    
    function logout($page)
    {
        $this->session->sess_destroy();
        redirect($page);
    }
    
    function permission($permission_name)
    {
        $gid = $this->session->userdata('group_id');
        $CI =& get_instance();
        $CI->load->model('group_model', 'group');
        $group_name = $CI->group->get_name($gid);
        if(strtolower($group_name) == strtolower($permission_name))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
?>