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
        
        $('#'+formname+' .input:first').focus();
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
                <h2>Department</h2>
            </div>
            
            <div class="menu">
				<ul>
					<li class="current_page_item">
						<a href="<?php echo site_url('scorecard'); ?>"><span>&laquo; Back</span></a>
					</li>
					<li class="page_item">
						<a href="<?php echo site_url('department/add_department'); ?>" onclick="return show_form('add_new');"><span>Add Department</span></a>
					</li>
				</ul>
			</div>
            
			<br class="clear" />
            
            <table border="1" cellspacing="0" cellpadding="0" class="minimal">
                <thead>
                    <tr>
                        <th class="first">Name</th>
                        <th>Parent Department</th>
                        <th>Instances</th>
						<th>Selectable</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(getstr($department_list)) { ?>
                <?php
                foreach($department_list->result() as $row)
                {
                ?>
                    <tr>
                        <td class="first"><?php echo $row->name; ?></td>
                        <td><?php echo ($row->parent_id) ? $this->department->get_name($row->parent_id):'-'; ?></td>
                        <td><?php echo $this->department->get_total_instances($row->id); ?></td>
						<td>
							<?php echo ($this->department->is_selectable($row->id) == 1) ? 'Yes':'No'; ?>
						</td>
                        <td>
                            <a href="<?php echo site_url('department/edit/' . $row->id); ?>" class="action edit" title="Edit">
                            </a>
                            <a href="<?php echo site_url('department/delete/' . $row->id); ?>" onclick="return confirm('Are you sure you want to delete?')" class="action delete" title="Delete">
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <?php } ?>
                </tbody>
            </table>
            
            <?php if(getstr($this->validation->error_string)){ ?>
				<?php echo form_open('department/add_submit/'); ?>
			<?php } else { ?>
				<?php echo form_open('department/add_submit/', array('class' => 'hide')); ?>
			<?php } ?>
			<fieldset class="lightblue-bg" id="add_new">
				<legend>Insert Data (<a href="#" class="close" onclick="return hide_fade('add_new');">Close</a>)</legend>
				<?php echo error_msg($this->validation->error_string); ?>
                
                <div>
                    <label for="parentdept">Parent Department</label>
                    <br/>
                    <select id="parent_id" name="parent_id" class="input">
                        <option value="">- None -</option>
                        <?php
                        if(getstr($department_list)){
                            foreach($department_list->result() as $row)
                            {
                        ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                
				<div>
					<label>Department Name<?php echo required(); ?></label><br/>
					<input id="name" class="full text" type="text" value="<?php echo getstr($this->validation->position);?>" name="dept_name"/>
				</div>
			
				<div>
					<input type="checkbox" name="selectable" value="1" /><label>Selectable</label><br/>
					<span class="moreinfo">If this is checked, the department will be selectable at the registration page</span>
				</div>
			
				<br/><br/>
			
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
        
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>