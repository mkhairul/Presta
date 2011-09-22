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
    $('#content').corner();
    
    form_invalid = <?php echo (getstr($this->validation->error_string)) ? '1':'0'; ?>;
    if(form_invalid)
    {
        show_form('insert_entry');
    }
})

function refresh()
{
    $("tbody tr:nth-child(even)").addClass("even");
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

function edit_data_radio(formname, id, data)
{
    hide_all();
    $('#' + formname + '_form').css('opacity', 0);
    //$('#' + formname + '_form').show();
    $('#' + formname + '_form').parent().show();
    $('#' + formname + '_form').animate({opacity:1}, 'normal');
    $('#' + formname + '_id').val(id);
    $('.'+formname).removeAttr('checked');
    
    if(data == 1)
    {
        $('#'+formname+'_positive').attr('checked', data);
    }
    else
    {
        $('#'+formname+'_negative').attr('checked', data);
    }
    
    
    //$('#'+formname).focus();
    
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

var measure = '';

function choose_measure(id_name)
{
    measure = id_name;
    //alert('#' + id_name);
    $('#' + id_name).animate({opacity:0}, 'normal', function(){
        $(this).hide();
        $('#' + id_name + '_select').css('opacity', 0);
        $('#' + id_name + '_select').show();
        $('#' + id_name + '_select').animate({opacity:1}, 'normal');
    })
}

function insert_measure(elem)
{
    //alert(measure)
    $('#' + measure + ' textarea').val($(elem).html())
    $('#' + measure + '_select').animate({opacity:0}, 'normal', function(){
        $(this).hide();
        $('#' + measure).css('opacity', 0);
        $('#' + measure).show();
        $('#' + measure).animate({opacity:1}, 'normal');
    })
}
</script>
</head>

<body>
    
	<div id="header"></div>
        <div id="content">
            
            <?php $this->load->view('includes/header_menu', $this); ?>
            
            <div class="content-title">
                <?php $this->load->view('includes/user_options', $this->data); ?>
                <h2>Initiative</h2>
                <div class="fullname"><?php echo $this->session->userdata('fullname'); ?></div>
            </div>
            
            <?php $this->load->view('includes/menu_employee'); ?>
            
            <br class="clear"/>
            
            <?php echo success_msg($misc_success); ?>
            
            <table class="minimal" cellpadding="0" cellspacing="0" border="0">
                <col>
                <col>
                <col>
                <thead>
                    <tr>
                        <th class="first">Measurement</th>
                        <th>Action Plan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(getstr($init_list)){ ?>
                        <?php foreach($init_list->result() as $row){ ?>
                            <tr>
                                <td class="first">
                                    <?php
                                    $measure_desc = ($row->measure_id) ? $this->measure->get_desc($row->measure_id):$row->measure_description;
                                    ?>
                                    <a href="#" onclick="return edit_data('measure', <?php echo $row->id; ?>, '<?php echo $measure_desc; ?>');">
                                    <?php echo $measure_desc; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" onclick="return edit_data('action', <?php echo $row->id; ?>, '<?php echo $row->action; ?>');">
                                        <?php echo $row->action; ?>
                                    </a>
                                <td>
                                    <a href="#" onclick="return edit_data_radio('status', <?php echo $row->id; ?>, '<?php echo $row->status; ?>');">
                                        <?php echo ($row->status) ? '<span class="complete">Complete</span>':'<span class="incomplete">Incomplete</a>'; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td class="first" colspan="3">No entries found.</td>
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
        
            <?php $formname = 'status'; ?>
            <?php echo form_open('initiative/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    
                    <div>
                        <label>Status</label><br/>
                        <input type="radio" class="<?php echo $formname; ?>" id="<?php echo $formname; ?>_negative" name="status" value="0" checked="checked" />Incomplete<br/>
                        <input type="radio" class="<?php echo $formname; ?>" id="<?php echo $formname; ?>_positive" name="status" value="1" />Complete
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
        
            <?php $formname = 'measure'; ?>
            <?php echo form_open('initiative/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <div>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label><br/>
                        <div id="measure_update">
                            <span class="moreinfo">Insert measurement or you can <a href="#" onclick="choose_measure('measure_update')">choose from existing</a></span>
                            <textarea id="<?php echo $formname; ?>" name="measure" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->measure); ?></textarea>
                        </div>
                        <div id="measure_update_select" class="hide-select">
                            <?php if(getstr($measure_list)) { ?>
                                <span class="moreinfo">Click to select</span>
                                <table class="select-table" cellpadding="0" cellspacing="0" border="0">
                                    <?php foreach($measure_list->result() as $row){ ?>
                                        <tr>
                                            <td>
                                                <a href="#" onclick="insert_measure($(this))"><?php echo $row->name; ?></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php }else{ ?>
                                <span>No measure data</span>
                            <?php } ?>
                        </div>
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
        
            <?php $formname = 'action'; ?>
            <?php echo form_open('initiative/update_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Edit <?php echo ucfirst($formname); ?> (<a href="#" class="close" onclick="return hide_form('<?php echo $formname; ?>');">Close</a>)</legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="<?php echo $formname; ?>"><?php echo ucfirst($formname); ?> Name <?php echo required(); ?></label>
                        <br/>
                        <textarea  id="<?php echo $formname; ?>" class="title" style="width: 95%; height: 50px;" name="action"><?php echo '';?></textarea>
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
                        <a href="#" class="negative" onclick="return hide_form('<?php echo $formname; ?>');">
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                        Cancel
                        </a>
                    </div>
                </fieldset>
            </form>
            
            
            <?php echo form_open('initiative/add_submit/', array('class' => 'hide')); ?>
            <fieldset class="lightblue-bg" id="add_new">
                <legend>Insert Data (<a href="#" class="close" onclick="return hide_fade('add_new');">Close</a>)</legend>
                
                <div>
                    <label>Measurement</label><br/>
                    <div id="measure_insert">
                        <span class="moreinfo">Insert measurement or you can <a href="#" onclick="choose_measure('measure_insert')">choose from existing</a></span>
                        <textarea name="measure" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->measure); ?></textarea>
                    </div>
                    <div id="measure_insert_select" class="hide-select">
                        <?php if(getstr($measure_list)) { ?>
                            <span class="moreinfo">Click to select</span>
                            <table class="select-table" cellpadding="0" cellspacing="0" border="0">
                                <?php foreach($measure_list->result() as $row){ ?>
                                    <tr>
                                        <td>
                                            <a href="#" onclick="insert_measure($(this))"><?php echo $row->name; ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php }else{ ?>
                            <span>No measure data</span>
                        <?php } ?>
                    </div>
                </div>
                
                <div>
                    <label>Action</label><br/>
                    <textarea name="action" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->action); ?></textarea>
                </div>
                
                <div>
                    <label>Status</label><br/>
                    <input type="radio" name="status" value="0" checked="checked" />Incomplete<br/>
                    <input type="radio" name="status" value="1" />Complete
                </div>
            
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
                <a id="add_entry" href="#" onclick="return show_form('add_new');" >
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/user_suit.png"/>
                    Add New
                </a>
            </div>
            
            <br class="clear" />
            <br/>
            
            
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>