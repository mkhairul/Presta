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
                <h2>Initiative</h2>
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
                                    <?php echo $measure_desc; ?>
                                </td>
                                <td>
                                    <?php echo $row->action; ?>
                                <td>
                                    <?php echo ($row->status) ? '<span class="complete">Complete</span>':'<span class="incomplete">Incomplete</a>'; ?>
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
            
            <br class="clear" />
            <br/>
            
            
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>