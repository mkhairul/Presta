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
<script type="text/javascript" src="<?php echo $this->js; ?>jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="<?php echo $this->js; ?>jquery.curvycorners.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#content').corner();
    $('#username').focus();
})
</script>
</head>

<body>
	<div id="header"></div>
        <div id="content">
			<div class="headermenu">
				<div id="logo">
					<img src="<?php echo $this->image;?>sitedesign/agency.png" alt="" />
					ORGANIZATION NAME
				</div>
				<ul>
                    <li>Presta v0.1</li>
				    <li><a href="<?php echo site_url('login/feedback'); ?>">Feedback</a></li>
				</ul>
				
                <br class="clear"/>
			</div>
		    <div class="title">
				<h1>Performance Management System</h1>
			    <div class="titlecontent">
					<div style="float:left; width: 60px;"><strong>Mission:</strong></div>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				</div>
				<div class="titlecontent">
					<div style="float:left; width: 60px;"><strong>Vision:</strong></div>
					Aliquam viverra quam sit amet sem accumsan vitae tempor neque iaculis.
				</div>
			</div>
			<br class="clear" />
			<br class="clear" />
			
			
			<div class="block span-9">
				<h3>Login</h3>
				<?php echo form_open('login/login_submit'); ?>
				<fieldset class="span-8 login" style="background-color: #D8E8FF;">
					<?php echo success_msg($login_success); ?>
					<?php echo error_msg($login_error); ?>
					
					<div>
						<label for="username">Username</label>
						<br/>
						<input name="username" id="username" type="text" value="<?php echo getstr($this->validation->username);?>"/>
					</div>
					<div>
						<label for="password">Password</label>
						<br/>
						<input name="password" id="password" type="password" value=""/>
					</div>
				
					<div class="buttons">
						<button class="positive" type="submit">
						<img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
						Login
						</button>
					</div>
				</fieldset>
				</form>
			</div>
            
			<div class="block span-12">
				<h3>Registration <span style="font-size: 70%;">(if you have not registered)</span></h3>
				<?php echo form_open('login/register'); ?>
				<fieldset class="span-11 login">
                    
					<?php echo success_msg($misc_success); ?>
					<?php echo error_msg($misc_error); ?>
					<p class="required">* required</p>
					
					<div>
						<label for="fullname">Name <?php echo required(); ?></label>
						<br/>
						<input id="fullname" class="full" type="text" value="<?php echo getstr($this->validation->fullname);?>" name="fullname"/>
					</div>
                     
					<div>
						<label for="employee_id">Employee ID</label>
						<br/>
						<input id="employee_id" type="text" value="<?php echo getstr($this->validation->employee_id);?>" name="employee_id"/>
					</div>
                
                    <br/>
                
					<div>
						<label for="department_id">Division/Department <?php echo required(); ?></label><br/>
                        <span class="moreinfo">Select from the list</span><br/>
						<select name="department_id">
							<option>-Select-</option>
                            <?php
                                if($dept_list)
                                {
                                    foreach($dept_list->result() as $row)
                                    {
                            ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                            <?php
                                    }
                                }
                            ?>
						</select>
                        <br/>
					</div>
					<div>
						<label for="position_id">Position <?php echo required(); ?></label><br/>
                        <span class="moreinfo">Select from the list</span><br/>
						<select name="position_id">
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
                        <br/>
					</div>
                
                    <div>
						<label for="group_id">Role/Group <?php echo required(); ?></label><br/>
                        <span class="moreinfo">Select from the list</span><br/>
						<select name="group_id">
                            <?php
                                if($group_list)
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
                        <br/>
					</div>
                
                    <hr/>
					
					<div>
						<label for="username_reg">Username <?php echo required(); ?></label>
						<br/>
						<input id="username_reg" type="text" value="<?php echo getstr($this->validation->username);?>" name="username_reg"/>
					</div>
					<div>
						<label for="password_reg">Password <?php echo required(); ?></label>
						<br/>
						<input id="password_reg" type="password" value="" name="password_reg"/>
					</div>
					<div>
						<label for="confirm">Confirm Password <?php echo required(); ?></label>
						<br/>
						<input id="confirm" type="password" value="" name="confirm"/>
					</div>
				
					<div class="buttons">
						<button class="positive" type="submit">
						<img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
						Register
						</button>
					</div>
				</fieldset>
				</form>
                <br class="clear" />
			</div>
            <br class="clear" />
        </div>
        <div id="footer">
            mkhairul.sembangprogramming.com
        </div>
</body>
</html>