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
<script type="text/javascript" src="<?php echo $this->js; ?>jquery.selectboxes.pack.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("tbody tr:nth-child(odd)").addClass("even");
    $('#content').corner();
});

function refresh()
{
    $("tbody tr:nth-child(odd)").addClass("even");
}

function hide_all()
{
    $('.hide').hide();
    //$('.hide').animate({opacity: 0}, 'normal');
    //$('.hide').hide();
}

function hide_form(formname)
{
    $('#' + formname + '_form').animate({opacity: 0}, 'normal', function(){
        //$('#' + formname + '_form').hide();
        $('#' + formname + '_form').parent().hide();
    });
    return false;
}

function edit_data(formname, id, data)
{
    hide_all();
    $('#' + formname + '_form').css('opacity', 0);
    //$('#' + formname + '_form').show();
    $('#' + formname + '_form').parent().show();
    $('#' + formname + '_form').animate({opacity:1}, 'normal');
    $('#' + formname + '_id').val(id);
    $('#'+formname).val(data);
    $('#'+formname).focus();
    
    return false;
}

function edit_data_select(formname, id, data)
{
    hide_all();
    $('#' + formname + '_form').css('opacity', 0);
    //$('#' + formname + '_form').show();
    $('#' + formname + '_form').parent().show();
    $('#' + formname + '_form').animate({opacity:1}, 'normal');
    $('#' + formname + '_id').val(id);
    $('#'+formname).selectOptions(data);
    $('#'+formname).focus();
    
    return false;
}

function show_form(formname)
{
    hide_all();
	$('#' + formname).css('opacity', 0).parent().show();
    $('#' + formname).animate({opacity: 1}, 'normal', function(){
		
		// focus on the first input in the form
		$('#'+formname+' input:text:first').focus();
		
		offset = $('#add_new').offset().top;
		$('html, body').animate({ 
                 scrollTop: offset }, 2000);
	});
    
    return false;
}

function hide_fade(formname)
{
    $('#' + formname).animate({opacity: 0}, 'normal', function(){
        $('#' + formname).parent().hide();
    });
    return false;
}

function set_value(idname, idnumber, text)
{
    $('input#' + idname + '_id').val(idnumber);
    //alert($('#' + idname + '_id').val());
    $('#' + idname).val(text);
    //$('#' + idname + '_info').html('Update');
    return false;
}

function set_id(id)
{
    if($('#' + id).val() == "")
    {
        // alert($('#' + id + '_id').val());
        $('#' + id + '_id').val('');
        $('#' + id + '_info').html('');
    }
}
</script>
</head>

<body>
	<div id="header"></div>
        <div id="content">
                
                <?php $this->load->view('includes/header_menu', $this); ?>
            
                <div class="content-title">
                    <div style="float:right; margin-top: 15px;">
                      <?php echo $this->session->userdata('fullname'); ?>, <a href="<?php echo site_url('login/logout'); ?>">Logout</a>
                    </div>
                    <h2>Users</h2>
                </div>
                
                <div class="menu">
                    <ul>
                        <li class="current_page_item">
                            <a href="<?php echo site_url('scorecard'); ?>"><span>&laquo; Back</span></a>
                        </li>
                        <li class="page_item">
                            <a href="<?php echo site_url('user/add_user'); ?>" onclick="return show_form('add_new');"><span>Add User</span></a>
                        </li>
                    </ul>
                </div>
				
				<br class="clear" />
		
                <?php echo success_msg($misc_success); ?>
		
                <table class="minimal" border="1" cellspacing="0" cellpadding="0">
					<thead>	
						<tr>
							<th class="first">Username</th>
							<th>Name</th>
							<th>Department</th>
							<th>Position</th>
							<th>Group</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                    <?php
                    if(getstr($user_list))
                    {
                        foreach($user_list->result() as $row)
                        {
                        ?>
                            <tr>
                                <td class="first"><?php echo $row->username; ?></td>
                                <td><?php echo $row->fullname; ?></td>
                                <td><?php echo $this->department->get_name($row->department_id); ?></td>
								<td>
									<?php
										// if there is not position for the user, set the default text as edit
										$position_name = $this->position->get_name($row->position_id);
									?>
									<a href="#" class="<?php echo (!$position_name) ? 'edit':'';?>" onclick="return edit_data_select('position', <?php echo $row->id; ?>, '<?php echo $row->position_id; ?>');">
										<?php
											echo ($position_name) ? $position_name:'Edit';
										?>
									</a>
								</td>
                                <td><?php echo $this->group->get_name($row->group_id); ?></td>
                                <td>
                                    <a href="<?php echo site_url('user/delete/' . $row->id); ?>" title="Delete <?php echo $row->fullname; ?>" onclick="return confirm('Are you sure you want to delete?')">
                                        <img src="<?php echo $this->image; ?>sitedesign/cross.png" alt="" />
                                    </a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    else
                    {
                    ?>
                            <tr>
                                <td>No users!</td>
                            </tr>
                    <?php
                    }
                    ?>
					</tbody>
                </table>
				
				
				<?php $formname = 'position'; ?>
				<?php echo form_open('user/update_' . $formname, array('class' => 'hide')); ?>
					<fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
						<legend>Edit <?php echo ucfirst($formname); ?></legend>
						<input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
						<div>
							<label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label><br/>
							<select id="<?php echo $formname; ?>" class="title full" name="<?php echo $formname; ?>_name">
								<?php if(getstr($position_list)){ ?>
									<option value="">-Select-</option>
									<?php foreach($position_list->result() as $row){ ?>
										<option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<span id="<?php echo $formname; ?>_info" class="moreinfo"></span>
							<?php
								$error_name = $formname . "_name_error";
								echo error_msg($this->validation->$error_name);
							?>
						</div>
						<div class="buttons button-section">
							<button class="positive" type="submit">
							<img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
							Save
							</button>
							<a href="#" class="negative" onclick="return hide_form('<?php echo $formname; ?>');"
							<img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
							Cancel
							</a>
						</div>
					</fieldset>
				</form>
		
				<?php if(getstr($this->validation->error_string)){ ?>
					<?php echo form_open('user/add_submit/'); ?>
				<?php } else { ?>
					<?php echo form_open('user/add_submit/', array('class' => 'hide')); ?>
				<?php } ?>
				<fieldset class="lightblue-bg" id="add_new">
					<legend>Insert Data (<a href="#" class="close" onclick="return hide_fade('add_new');">Close</a>)</legend>
					<?php echo error_msg($this->validation->error_string); ?>
					<div>
						<label for="fullname">Name <?php echo required(); ?></label><br/>
						<input id="fullname" class="full text" type="text" value="<?php echo getstr($this->validation->fullname);?>" name="fullname"/>
					</div>
				
					<div>
						<label for="employee_id">Employee ID</label>
						<br/>
						<input id="employee_id" type="text" value="<?php echo getstr($this->validation->employee_id);?>" name="employee_id"/>
					</div>
				
					<br/>
				
					<div>
						<label for="department">Division/Department <?php echo required(); ?></label><br/>
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
							<option>-Select-</option>
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
				
					<div>
						<label for="type">User Type <?php echo required(); ?></label><br/>
                        <span class="moreinfo">Corporate users can view and modify scorecards. Individual Users can only view their KPIs.</span><br/>
						<select name="type">
                            <option value="individual">Individual</option>
							<option value="corporate">Corporate</option>
						</select>
                        <br/>
					</div>

					<hr/>
					
					<div>
						<label for="username">Username <?php echo required(); ?></label>
						<br/>
						<input id="username" type="text" value="<?php echo getstr($this->validation->username);?>" name="username"/>
					</div>
					<div>
						<label for="password">Password <?php echo required(); ?></label>
						<br/>
						<input id="password" type="password" value="" name="password"/>
					</div>
					<div>
						<label for="confirmpassword">Confirm Password <?php echo required(); ?></label>
						<br/>
						<input id="confirmpassword" type="password" value="" name="confirmpassword"/>
					</div>
					
					<div>
						<label>Activate User</label><br/>
						<span class="moreinfo">Activated users can login</span><br/>
						<input type="radio" name="enable" value="1" checked="checked">Activate<br/>
						<input type="radio" name="enable" value="0">Deactivate<br/>
					</div>
				
					<br/>
				
					<div class="buttons">
						<button class="positive" type="submit">
						<img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
						Save
						</button>
						<a class="negative" href="#" onclick="return hide_fade('add_new');">
							<img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
							Cancel
						</a>
					</div>
				</fieldset>
				</form>
				
            
            <div class="buttons">
                <a href="<?php echo site_url('user/add_user'); ?>" onclick="return show_form('add_new');">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/user_suit.png"/>
                    Add User
                </a>
            </div>
            
            <br class="clear" />
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>