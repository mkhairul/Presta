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
<script type="text/javascript" src="<?php echo $this->js; ?>jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo $this->js; ?>jquery.curvycorners.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $("tbody tr:nth-child(odd)").addClass("even");
    //reset_form();
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
        //$('#' + formname).hide();
        $('#' + formname).parent().hide();
    });
    return false;
}

function set_value(idname, idnumber, text)
{
    $('input#' + idname + '_id').val(idnumber);
    $('#' + idname).val(text);
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

function reset_form()
{
    // alert('resetting..');
    $('#perspective_id').val('');
    $('#perspective').val('');
    
    $('#strategic_id').val('');
    $('#strategic').val('');
    
    $('#objective_id').val('');
    $('#objective').val('');
    
    $('#measure_id').val('');
    $('#measure').val('');
    
    $('#target_id').val('');
    $('#target').val('');
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
                <h2>Scorecard Overview</h2>
            </div>
            
            <?php $this->load->view('includes/menu_admin', $this->data); ?>
            
            <?php //echo success_msg($misc_success); ?>
            <?php echo error_msg($this->validation->error_string); ?>
            
            <table border="1" cellspacing="0" cellpadding="0" class="minimal">
                <thead>
                    <tr>
                        <th class="first">Perspective</th>
                        <th>Strategic Themes</th>
                        <th>Objectives</th>
                        <th>Measurement</th>
                        <th>Target</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(getstr($scorecard_list))
                {
                    $perspective_name = '';
                    $objective_name = '';
                    $strategic_name = '';
                    
                    /* remove duplication on names (perspective, strategic, etc) */
                    foreach($scorecard_list->result() as $row)
                    {
                        /*-------------------
                         If perspective name is not set, use it.
                         If $pname is set to false, means it will be displayed.
                         -------------------*/
                        if(!$perspective_name)
                        {
                            $perspective_name = $row->perspective_name;
                            $pname = FALSE;
                        }
                        else
                        {
                            if($perspective_name == $row->perspective_name)
                            {
                                $pname = TRUE;
                            }
                            else
                            {
                                $pname = FALSE;
                                $perspective_name = $row->perspective_name;
                            }
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
                            if($objective_name == $row->objective_name)
                            {
                                $oname = TRUE;
                            }
                            else
                            {
                                $objective_name = $row->objective_name;
                                $oname = FALSE;
                            }
                            //$oname = ($objective_name == $row->objective_name) ? TRUE:FALSE;
                        }
                        
                ?>
                    <tr>
                        <td class="first">
                            <?php if(!$pname){ ?>
                            <a href="#" onclick="return edit_data('perspective', <?php echo $row->perspective_id; ?>, '<?php echo $row->perspective_name; ?>');">
                            <!--<a href="#" id="perspective_link" class="formlink">-->
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
                            <?php if(!$oname){ ?>
                            <a href="#" onclick="return edit_data('objective', <?php echo $row->objective_id; ?>, '<?php echo htmlentities($row->objective_name); ?>');">
                                <?php echo ($oname) ? '':truncate($row->objective_name, 100, '...');?>
                            </a>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="#" onclick="return edit_data('measure', <?php echo ($row->measure_id) ? $row->measure_id:0; ?>, '<?php echo $row->measure_name; ?>');">
                                <?php echo ($row->measure_name) ? $row->measure_name:''; ?>
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="return edit_data('target', <?php echo $row->measure_id; ?>, '<?php echo $row->target; ?>');">
                                <?php echo $row->target; ?>
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
                        <td class="first" colspan="5">No entries.</td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            
            <?php echo form_open('scorecard/update_perspective', array('class' => 'hide')); ?>
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
                        <a href="#" class="negative" onclick="return hide_form('perspective');">
                        <!--<a href="#" class="negative">-->
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                        Cancel
                        </a>
                    </div>
                </fieldset>
            </form>
        
            <?php $formname = 'strategic'; ?>
            <?php echo form_open('scorecard/update_' . $formname, array('class' => 'hide')); ?>
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
            <?php echo form_open('scorecard/update_' . $formname, array('class' => 'hide')); ?>
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
        
            <?php $formname = 'measure'; ?>
            <?php echo form_open('scorecard/update_' . $formname, array('class' => 'hide')); ?>
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
        
            <?php $formname = 'target'; ?>
            <?php echo form_open('scorecard/update_' . $formname, array('class' => 'hide')); ?>
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
            
            <!-- ADD NEW ENTRY -->
            <?php echo form_open('scorecard/add_submit', array('class' => 'hide')); ?>
            <fieldset class="lightblue-bg" id="insert_entry">
                <legend>Insert Data</legend>
                
                <div class="span-10">
                    <p>
                        <label for="perspective">Perspective Name <?php echo required(); ?></label>
                        <br/>
                        <input  id="perspective" class="title full" type="text" value="<?php echo getstr($this->validation->perspective_name);?>" name="perspective_name" />
                        <input id="perspective_id" name="perspective_id" type="hidden" value="woot"/>
                        <span id="perspective_info" class="moreinfo"></span>
                        <?php echo error_msg($this->validation->perspective_name_error); ?>
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
                    <textarea id="objective" name="objective" style="width: 95%; height: 50px;" ><?php echo getstr($this->validation->objective); ?></textarea>
                    <input id="objective_id" name="objective_id" type="hidden" value=""/>
                    <span id="objective_info" class="moreinfo"></span>
                    <?php echo error_msg($this->validation->objective_error); ?>
                </p>
                <p>
                    <label for="measure">Measurement</label>
                    <br/>
                    <textarea id="measure" name="measure" style="width: 95%; height: 50px;"></textarea>
                    <input id="measure_id" name="measure_id" type="hidden" value=""/>
                    <span id="measure_info" class="moreinfo"></span>
                    <?php echo error_msg($this->validation->measure_error); ?>
                </p>
                <p>
                    <label for="target">Target</label>
                    <br/>
                    <textarea id="target" name="target" style="width: 95%; height: 50px;"><?php echo getstr($this->validation->target); ?></textarea>
                    <input id="target_id" name="target_id" type="hidden" value=""/>
                    <span id="target_info" class="moreinfo"></span>
                    <?php echo error_msg($this->validation->target_error); ?>
                </p>
            
                <div class="buttons button-section">
                    <button class="positive" type="submit">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                    Save
                    </button>
                    <a href="#" class="negative" onclick="return hide_fade('insert_entry');">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                    Cancel
                    </a>
                    <button class="negative" type="reset" onclick="reset_form()">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                    Reset
                    </button>
                </div>
            </fieldset>
            </form>
            <!-- end form -->
            
            <!-- add entry with department info -->
            <?php $formname = 'department'; ?>
            <?php echo form_open('scorecard/add_entry_' . $formname, array('class' => 'hide')); ?>
                <fieldset class="lightblue-bg" id="<?php echo $formname; ?>_form">
                    <legend>Add <?php echo ucfirst($formname); ?></legend>
                    <input type="hidden" name="<?php echo $formname; ?>_id" id="<?php echo $formname; ?>_id" value="" />
                    <p>
                        <label for="parentdept">Parent Department</label>
                        <br/>
                        <select name="parent_id">
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
                    </p>
                    <p>
                        <label for="dept">Department Name</label>
                        <br/>
                        <input id="dept" class="title" type="text" value="" name="dept_name"/>
                    </p>
                
                    <!--- SEPERATE DEPARTMENT INFO FROM KPI -->
                    <hr/>
                    <!--- WOOOOOTTTTT! -->
                    
                    <div class="span-10">
                        <p>
                            <label for="perspective">Perspective Name <?php echo required(); ?></label>
                            <br/>
                            <input  id="perspective" class="title full" type="text" value="<?php echo '';?>" name="<?php echo $formname; ?>_perspective_name" />
                            <span id="perspective_info" class="moreinfo"></span>
                            <?php echo error_msg($this->validation->perspective_name_error); ?>
                        </p>
                    </div>
                    <div class="span-11 last">
                        <p>
                            <label for="strategic">Strategic Theme</label>
                            <br/>
                            <input id="strategic" class="title full" type="text" value="<?php echo ''; ?>" name="<?php echo $formname; ?>_strategic_name"/>
                            <input id="strategic_id" name="strategic_id" type="hidden" value=""/>
                            <span id="strategic_info" class="moreinfo"></span>
                            <?php echo error_msg($this->validation->strategic_name_error); ?>
                        </p>
                    </div>
                    <br class="clear" />
                    <p>
                        <label for="objective">Objectives</label>
                        <br/>
                        <textarea id="objective" name="<?php echo $formname; ?>_objective" style="width: 95%; height: 50px;" ></textarea>
                        <span id="objective_info" class="moreinfo"></span>
                        <?php echo error_msg($this->validation->objective_error); ?>
                    </p>
                    <p>
                        <label for="measure">Measurement</label>
                        <br/>
                        <textarea id="measure" name="<?php echo $formname; ?>_measure" style="width: 95%; height: 50px;"></textarea>
                        <span id="measure_info" class="moreinfo"></span>
                        <?php echo error_msg($this->validation->measure_error); ?>
                    </p>
                    <p>
                        <label for="target">Target</label>
                        <br/>
                        <textarea id="target" name="<?php echo $formname; ?>_target" style="width: 95%; height: 50px;"></textarea>
                        <span id="target_info" class="moreinfo"></span>
                        <?php echo error_msg($this->validation->target_error); ?>
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
            <!-- END add entry with department info -->
            
            
            <div class="buttons">
                <a href="<?php echo site_url('perspective'); ?>" onclick="return show_form('insert_entry');">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/page_add.png"/>
                    Add an Entry
                </a>
                <!--
                <a href="#" onclick="return edit_data('department', 0, '');">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/page_add.png"/>
                    Add Entry for Department
                </a>
                -->
            </div>
            
            <br class="clear" />
            <br/>
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>