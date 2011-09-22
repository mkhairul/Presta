<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo getstr($title); ?></title>
<link rel="shortcut icon" href="<?php echo $this->image; ?>favicon.ico" />
<link rel="stylesheet" href="<?php echo $this->css; ?>blueprint/screen.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="<?php echo $this->css; ?>blueprint/print.css" type="text/css" media="print" /> 
<!--[if IE]><link rel="stylesheet" href="<?php echo $this->css; ?>blueprint/ie.css" type="text/css" media="screen, projection" /><![endif]-->
<link href="<?php echo $this->css; ?>pms_style.css" rel="stylesheet" type="text/css" />

</head>

<body>
	<div id="header"></div>
        <div id="content">
            
            <?php $this->load->view('includes/header_menu', $this); ?>
            
            <div class="content-title">
                <div style="float:right; margin-top: 15px;">
                  <?php echo $this->session->userdata('fullname'); ?>, <a href="<?php echo site_url('login/logout'); ?>">Logout</a>
                </div>
                <h2>Add User</h2>
            </div>
            
            <?php echo form_open('user/add_user_submit'); ?>
            <fieldset>
                <legend>Add User</legend>
                
                <?php echo success_msg($misc_success); ?>
                <?php echo error_msg($this->validation->error_string); ?>
                
                <p>
                    <label for="dept">Select Department</label>
                    <br/>
                    <select name="department_id">
                        <option value="">- Select one -</option>
                        <?php
                        if(getstr($department_list))
                        {
                            foreach($department_list->result() as $row)
                            {
                        ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </p>
            
                <p>
                    <label for="username">Position</label>
                    <br/>
                    <select name="position">
                        <option>-Select-</option>
                        <?php
                            if($position_list)
                            {
                                foreach($position_list->result() as $row)
                                {
                        ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </p>
            
                <p>
                    <label for="supervisor">Reports To</label>
                    <br/>
                    <select name="supervisor">
                        <option>-Select-</option>
                        <?php
                            if($supervisor_list)
                            {
                                foreach($supervisor_list->result() as $row)
                                {
                        ?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->fullname; ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                </p>
            
                <br/>
                <hr/>
            
                <p>
                    <label for="group_id">Select Group</label>
                    <br/>
                    <select name="group_id">
                        <option value="">- Select one -</option>
                        <?php
                        if(getstr($group_list))
                        {
                            foreach($group_list->result() as $row)
                            {
                        ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>
					<label for="type">Select Type of View (scorecard or KPI)</label>
                    <br/>
                    <select name="type">
                        <option value="individual" selected="selected">Individual</option>
						<option value="corporate">Corporate</option>
                    </select>
				</p>
            
                <br/>
                <hr/>
            
                <p>
                    <label for="fullname">Full Name</label>
                    <br/>
                    <input id="fullname" class="title" type="text" value="<?php echo getstr($this->validation->name);?>" name="name"/>
                </p>
                <p>
                    <label for="employee_no">Employee No.</label>
                    <br/>
                    <input id="employee_no" type="text" value="<?php echo getstr($this->validation->username);?>" name="employee_no"/>
                </p>
                <p>
                    <label for="username">Username</label>
                    <br/>
                    <input id="username" type="text" value="<?php echo getstr($this->validation->username);?>" name="username"/>
                </p>
                <p>
                    <label for="password">Password</label>
                    <br/>
                    <input id="password" type="password" value="" name="password"/>
                </p>
                <p>
                    <label for="confirmpassword">Confirm Password</label>
                    <br/>
                    <input id="confirmpassword" type="password" value="" name="confirmpassword"/>
                </p>
                
                <p>
                    <label for="enable">Enable Account</label>
                    <br/>
                    <input type="radio" name="enable" value="1" checked="checked" />Enable
                    <br/>
                    <input type="radio" name="enable" value="0" />Disable
                </p>
            
                <div class="buttons">
                    <button class="positive" type="submit">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                    Save
                    </button>
                    <a href="<?php echo site_url('user'); ?>">
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/arrow_left.png"/>
                        Back
                    </a>
                </div>
            </fieldset>
            </form>
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>