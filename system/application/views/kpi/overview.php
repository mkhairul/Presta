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
    $("tbody tr:nth-child(odd)").addClass("even");
    $('.success').animate({opacity:0}, 'slow', function(){
        $(this).hide();
    });
    
    //$('fieldset').corner();
    $('#content').corner();
    
    form_invalid = <?php echo (getstr($this->validation->error_string)) ? '1':'0'; ?>;
    if(form_invalid)
    {
        show_form('insert_entry');
    }
})

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

function show_form(formname)
{
    hide_all();
    $('#' + formname).css('opacity', 0);
    $('#' + formname).parent().show();
    $('#' + formname).animate({opacity: 1}, 'normal');
    
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
                <?php $this->load->view('includes/user_options', $this->data); ?>
                <h2>KPI Overview <?php $dept_name = $this->department->get_name(getstr($dept_id)); echo ($dept_name) ? ' - '.$dept_name:''; ?></h2>
                <div class="fullname"><?php echo $this->session->userdata('fullname'); ?></div>
            </div>
            
            <?php $this->load->view('includes/menu_employee'); ?>
            
            <br class="clear"/>
            
            <?php echo success_msg($misc_success); ?>
            
            <?php if(getstr($view_subordinate)){ ?>
                <h3><?php echo $this->user->get_name($this->kpi->get_user_id($kpi_id)); ?></h3>
            <?php } ?>
            
            <!--
            <table class="kpi-overview scorecard" border="1" cellspacing="0" cellpadding="0">
            -->
            <table class="minimal" border="1" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th class="first" style="width: 50px;">Perspective</th>
                        <th style="width: 100px;">Strategic</th>
                        <th style="width: 180px;">Objectives</th>
                        <th style="width: 180px;">Measure</th>
                        <th style="width: 120px;">Target</th>
                        <th style="width: 80px;">Actual</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(getstr($kpi_list))
                {
                    $perspective_name = '';
                    $objective_name = '';
                    $strategic_name = '';
                    
                    foreach($kpi_list->result() as $row)
                    {
                        if(!$perspective_name)
                        {
                            $perspective_name = $row->perspective_name;
                            $pname = FALSE;
                        }
                        else
                        {
                            $pname = ($perspective_name == $row->perspective_name) ? TRUE:FALSE;
                        }
                        
                        if(!$strategic_name)
                        {
                            $strategic_name = $row->strategic_name;
                            $sname = FALSE;
                        }
                        else
                        {
                            if($strategic_name == $row->strategic_name)
                            {
                                $sname = TRUE;
                            }
                            else
                            {
                                $strategic_name = $row->strategic_name;
                                $sname = FALSE;
                            }
                        }
                        
                        if(!$objective_name)
                        {
                            $objective_name = $row->objective_name;
                            $oname = FALSE;
                        }
                        else
                        {
                            $oname = ($objective_name == $row->objective_name) ? TRUE:FALSE;
                        }
                        
                ?>
                    <tr>
                        <td class="first">
                            <?php if(!$pname){ ?>
                            <a href="#" onclick="return edit_data('perspective', <?php echo $row->perspective_id; ?>, '<?php echo $row->perspective_name; ?>');">
                                <strong><?php echo ($pname) ? '':$row->perspective_name; ?></strong>
                            </a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if(!$sname){ ?>
                            <a href="#" onclick="return edit_data('strategic', <?php echo $row->strategic_id; ?>, '<?php echo $row->strategic_name; ?>');">
                                <?php echo ($sname) ? '':truncate($row->strategic_name, 100, '...');?>
                            </a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="#" onclick="return edit_data('objective', <?php echo $row->objective_id; ?>, '<?php echo htmlentities($row->objective_name); ?>');">
                                <?php echo ($oname) ? '':truncate($row->objective_name, 100, '...');?>
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="return edit_data('measure', <?php echo $row->measure_id; ?>, '<?php echo htmlentities($row->measure_name); ?>');">
                                <?php echo $row->measure_name; ?>
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="return edit_data('target', <?php echo $row->measure_id; ?>, '<?php echo htmlentities($row->target); ?>');">
                                <?php echo $row->target; ?>
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="return edit_data('actual', <?php echo $row->measure_id; ?>, '<?php echo htmlentities($row->actual); ?>');">
                                <?php echo ($row->actual) ? $row->actual:'-'; ?>
                            </a>
                        </td>
                    </tr>
                    
                <?php
                    }
                }else{
                ?>
                    <tr>
                        <td class="first" colspan="7">No entries</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            
            <?php echo error_msg($this->validation->error_string); ?>
            
            <?php echo form_open('kpi/update_perspective', array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="perspective_form">
                    <legend>Edit Perspective</legend>
                    <input type="hidden" name="perspective_id" id="perspective_id" value="" />
                    <p>
                        <label for="perspective">Perspective Name <?php echo required(); ?></label>
                        <br/>
                        <input id="perspective" class="title full" type="text" value="<?php echo '';?>" name="perspective_name" />
                        <span id="perspective_info" class="moreinfo"></span>
                        <?php echo error_msg($this->validation->perspective_name_error); ?>
                    </p>
                    <div class="buttons button-section">
                        <button class="positive" type="submit">
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                        Save
                        </button>
                        <a href="#" class="negative" onclick="return hide_form('perspective');"
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                        Cancel
                        </a>
                    </div>
                </fieldset>
            </form>
        
            <?php $formname = 'strategic'; ?>
            <?php echo form_open('kpi/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label>
                        <br/>
                        <input  id="<?php echo $formname; ?>" class="title full" type="text" value="<?php echo '';?>" name="<?php echo $formname; ?>_name" />
                        <span id="<?php echo $formname; ?>_info" class="moreinfo"></span>
                        <?php
                            $error_name = $formname . "_name_error";
                            echo error_msg($this->validation->$error_name);
                        ?>
                    </p>
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
        
            <?php $formname = 'objective'; ?>
            <?php echo form_open('kpi/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label>
                        <br/>
                        <textarea  id="<?php echo $formname; ?>" style="width: 95%; height: 50px;" name="<?php echo $formname; ?>_name"><?php echo '';?></textarea>
                        <span id="<?php echo $formname; ?>_info" class="moreinfo"></span>
                        <?php
                            $error_name = $formname . "_name_error";
                            echo error_msg($this->validation->$error_name);
                        ?>
                    </p>
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
        
            <?php $formname = 'measure'; ?>
            <?php echo form_open('kpi/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label>
                        <br/>
                        <textarea  id="<?php echo $formname; ?>" style="width: 95%; height: 50px;" name="<?php echo $formname; ?>_name"><?php echo '';?></textarea>
                        <span id="<?php echo $formname; ?>_info" class="moreinfo"></span>
                        <?php
                            $error_name = $formname . "_name_error";
                            echo error_msg($this->validation->$error_name);
                        ?>
                    </p>
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
        
            <?php $formname = 'target'; ?>
            <?php echo form_open('kpi/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label>
                        <br/>
                        <textarea  id="<?php echo $formname; ?>" style="width: 95%; height: 50px;" name="<?php echo $formname; ?>_name"><?php echo '';?></textarea>
                        <span id="<?php echo $formname; ?>_info" class="moreinfo"></span>
                        <?php
                            $error_name = $formname . "_name_error";
                            echo error_msg($this->validation->$error_name);
                        ?>
                    </p>
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
        
            <?php $formname = 'actual'; ?>
            <?php echo form_open('kpi/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Details<?php echo required(); ?></label>
                        <br/>
                        <textarea  id="<?php echo $formname; ?>" style="width: 95%; height: 50px;" name="<?php echo $formname; ?>_name"><?php echo '';?></textarea>
                        <span id="<?php echo $formname; ?>_info" class="moreinfo"></span>
                        <?php
                            $error_name = $formname . "_name_error";
                            echo error_msg($this->validation->$error_name);
                        ?>
                    </p>
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
            
            
            <?php echo form_open('kpi/add_submit/' . getstr($dept_id), array('class' => 'hide')); ?>
            <fieldset class="lightblue-bg" id="add_new">
                <legend>Insert Data (<a href="#" class="close" onclick="return hide_fade('add_new');">Close</a>)</legend>
                <div class="span-10">
                    <p>
                        <label for="perspective">Perspective Name <?php echo required(); ?></label>
                        <br/>
                        <input type="hidden" id="perspective_id" name="perspective_id" value="<?php echo getstr($this->validation->perspective); ?>" />
                        <input id="perspective" class="title full" type="text" value="" name="perspective"/>
                    </p>
                </div>
                
                <div class="span-11 last">
                    <p>
                        <label for="strategic">Strategic Theme</label>
                        <br/>
                        <input id="strategic" class="title full" type="text" value="<?php echo getstr($this->validation->strategic_name); ?>" name="strategic_name"/>
                        <input id="strategic_id" name="strategic_id" type="hidden" value=""/>
                        <span id="strategic_info" class="moreinfo"></span>
                        <?php echo error_msg($this->validation->strategic_name_error); ?>
                    </p>
                </div>
                
                <br class="clear" />
                <p>
                    <label for="objective">Objectives</label>
                    <br/>
                    <textarea name="objective" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->objective); ?></textarea>
                </p>
                <p>
                    <label for="measure">Measurement</label>
                    <br/>
                    <textarea name="measure" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->measure); ?></textarea>
                </p>
                <p>
                    <label for="target">Target</label>
                    <br/>
                    <textarea name="target" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->target); ?></textarea>
                </p>
                <p>
                    <label for="actual">Actual</label>
                    <br/>
                    <textarea name="actual" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->actual); ?></textarea>
                </p>
            
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
            
            <?php if(!getstr($disable_all)) { ?>
            <div class="buttons">
                <a id="add_entry" href="#" onclick="return show_form('add_new');" >
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/user_suit.png"/>
                    Add New
                </a>
            </div>
            <?php } ?>
            
            <br class="clear" />
            <br/>
            <br/>
            
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>