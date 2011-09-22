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
})
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
            
            <?php echo form_open('user/change_password_submit'); ?>
                <fieldset class="lightblue-bg" id="perspective_form">
                    <legend>Change Password</legend>
                    <div>
                        <label>Password <?php echo required(); ?></label>
                        <br/>
                        <input name="password" class="title" type="password" value="<?php echo '';?>"  />
                        <span class="moreinfo"></span>
                        <?php echo error_msg($this->validation->password_error); ?>
                    </div>
                    <div>
                        <label>Confirm Password <?php echo required(); ?></label>
                        <br/>
                        <input name="password_confirm" class="title" type="password" value="<?php echo '';?>" />
                        <span class="moreinfo"></span>
                        <?php echo error_msg($this->validation->password_confirm_error); ?>
                    </div>
                    <div class="buttons button-section">
                        <button class="positive" type="submit">
                            <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                            Change Password
                        </button>
                    </div>
                </fieldset>
            </form>
            
            <br class="clear" />
            <br/>
            
            
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>