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
                <h2>KPI Overview <?php $dept_name = $this->department->get_name(getstr($dept_id)); echo ($dept_name) ? ' - '.$dept_name:''; ?></h2>
            </div>
            
            <?php $this->load->view('includes/menu_employee'); ?>
            
            <br class="clear"/>
            
            <?php echo success_msg($misc_success); ?>
            
            <?php
            // Get the user id, or department id
            if(getstr($view_subordinate))
            {
                if($user_id = $this->kpi->get_user_id($kpi_id))
                {
            ?>
                    <h3><?php echo $this->user->get_name($user_id); ?></h3>
            <?php
                }
                else
                {
                    $dept_id = $this->kpi->get_dept_id($kpi_id);
                    $supr_name = $this->user->get_supervisor_name($dept_id);
                    
            ?>
                    <h3><?php echo getstr($supr_name); ?></h3>
            <?php   
                }
            }
            ?>
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
                                <strong><?php echo ($pname) ? '':$row->perspective_name; ?></strong>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if(!$sname){ ?>
                                <?php echo ($sname) ? '':$row->strategic_name;?>
                            <?php } ?>
                        </td>
                        <td><?php echo ($oname) ? '':$row->objective_name;?></td>
                        <td><?php echo $row->measure_name; ?></td>
                        <td><?php echo $row->target; ?></a>
                        </td>
                        <td><?php echo ($row->actual) ? $row->actual:'-'; ?></td>
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
            
            <br class="clear" />
            <br/>
            <br/>
            
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>