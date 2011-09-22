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
                <div style="float:right; margin-top: 15px;">
                  <?php echo $this->session->userdata('fullname'); ?>, <a href="<?php echo site_url('login/logout'); ?>">Logout</a>
                </div>
                <h2>Quaterly Performance and Developmental Dialogue</h2>
            </div>
            
            <div class="menu">
                <ul>
                    <li class="page_item">
                        <a href="<?php echo site_url('kpi'); ?>"><span>KPI</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('initiative'); ?>"><span>Initiative</span></a>
                    </li>
                    <li class="current_page_item">
                        <a href="<?php echo site_url('dialogue'); ?>" title="Quaterly Performance and Developmental Dialogue"><span>Performance Dialogue</span></a>
                    </li>
                </ul>
            </div>
            
            <br class="clear"/>
            
            <div class="content-box">
                <h3>1<sup>st</sup> Quarter</h3>
                <div class="contents">
                    No comments.
                </div>
            </div>
            
            <div class="content-box">
                <h3>2<sup>nd</sup> Quarter</h3>
                <div class="contents">
                    No comments.
                </div>
            </div>
            
            <div class="content-box">
                <h3>3<sup>rd</sup> Quarter</h3>
                <div class="contents">
                    No comments.
                </div>
            </div>
            
            
            <div class="content-box">
                <div class="span-14">
                    <h3>Final Review &amp; Rating</h3>
                    <div class="contents">
                        No comments
                    </div>
                </div>
                <div class="span-5" style="padding-left: 5px;">
                    <span><strong>Legend</strong></span>
                    <ul>
                        <li>1 – poor (44 and below)</li>
                        <li>2 – Unsatisfactory (45-64)</li>
                        <li>3 – average (65-79)</li>
                        <li>4 – Good (80 -99)</li>
                        <li>5 – Excellent (100 and above)</li>
                    </ul>
                </div>
            </div>

        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>