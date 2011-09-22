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
                <h2>Department</h2>
            </div>
            
            <?php echo form_open('department/edit_submit'); ?>
            <fieldset>
                <legend>Edit Department</legend>
                
                <?php echo success_msg($misc_success); ?>
                <?php echo error_msg($this->validation->error_string); ?>
                
                <input type="hidden" name="dept_id" value="<?php echo $department_id; ?>" />
                <div>
                    <label for="parentdept">Parent Department</label>
                    <br/>
                    <select name="parent_id">
                        <option value="">- None -</option>
                        <?php
                        if(getstr($department_list))
                        {
                            $parent_id = $this->department->get_parent_id($department_id);
                            foreach($department_list->result() as $row)
                            {
                                if($row->id == $parent_id)
                                {
                                    $selected = 'selected="selected"';
                                }
                                else
                                {
                                    $selected = '';
                                }
                        ?>
                                <option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label for="dept">Department Name</label>
                    <br/>
                    <input id="dept" class="title" type="text" value="<?php echo $this->department->get_name($department_id); ?>" name="dept_name"/>
                </div>
				
				<div>
					<input type="checkbox" name="selectable" value="1" <?php echo ($this->department->is_selectable($department_id) == 1) ? 'checked="checked"':''; ?> /><label>Selectable</label><br/>
					<span class="moreinfo">If this is checked, the department will be selectable at the registration page</span>
				</div>
			
				<br/><br/>
				
                <div class="buttons">
                    <button class="positive" type="submit">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                    Save
                    </button>
                    <a href="<?php echo site_url('department'); ?>">
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                        Cancel
                    </a>
                    <a href="<?php echo site_url('department'); ?>">
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