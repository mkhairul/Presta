<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Authlib {
    
    var $error = '';
    var $_user_data = '';
    
    function Authlib()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('user_model', 'user', TRUE);
    }
    
    function _authenticate()
    {
        
        if(!($this->_user_data = $this->CI->user->get_user($this->username)))
        {
            $this->error = 'Invalid username and/or password';
        }
        else
        {
            if(!$this->_check_password())
            {
                $this->error = 'Invalid username and/or password';
                return FALSE;
            }
        }
        return ($this->_user_data) ? TRUE:FALSE;
    }
    
    function change_password($uid, $password)
    {
        if($uid && $password)
        {
            $password = $this->create_password($password);
            $this->CI->user->update($uid, array('password' => $password));
        }
    }
    
    function _check_password()
    {
        return ($this->create_password($this->password) === $this->_user_data->password) ? TRUE:FALSE;
    }
    
    function create_password($password='')
    {
        $salt = substr($password,0,2);
        $this->CI->load->library('encrypt');
        $password = $this->CI->encrypt->sha1($password . $salt);

        return $password;
    }
    
    function _create_user_session()
    {
        $this->CI->session->set_userdata(
            array(
                'username' => $this->_user_data->username,
                'fullname' => $this->_user_data->fullname,
                'uid' => $this->_user_data->id,
                'gid' => $this->_user_data->group_id
            )
        );
    }

    function login()
    {
        if($this->_retrieve_login_posts())
        {
            if($this->_authenticate())
            {
                $this->_create_user_session();
                return TRUE;
            }
        }
        return FALSE;
    }
    
    function _retrieve_login_posts()
    {
        $this->username = $this->CI->input->post('username');
        $this->password = $this->CI->input->post('password');
        if(!$this->username or !$this->password)
        {
            $this->error = 'Please insert a username and/or password';
        }
        return ($this->error) ? FALSE:TRUE;
    }
}
?>