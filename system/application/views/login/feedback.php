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
    $('#content').corner();
    $('#username').focus();
})
</script>
</head>

<body>
	<div id="header"></div>
        <div id="content">
			<div class="headermenu">
				<div id="logo">
					<img src="<?php echo $this->image;?>sitedesign/agency.png" alt="" />
					Organization Name
				</div>
            
                <ul>
                    <li><a href="<?php echo site_url('login'); ?>">&laquo; Back</a></li>
				</ul>
            
                <br class="clear"/>
			</div>
		    <div class="title">
				<h1>Performance Management System</h1>
			    <div class="titlecontent">
					<div style="float:left; width: 60px;"><strong>Mission:</strong></div>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				</div>
				<div class="titlecontent">
					<div style="float:left; width: 60px;"><strong>Vision:</strong></div>
					Aliquam viverra quam sit amet sem accumsan vitae tempor neque iaculis.
				</div>
			</div>
			<br class="clear" />
			<br class="clear" />
			
			<h2>Feedback?</h2>
        
            <p>
                Send Feedback to <strong>mkhairul@gmail.com</strong> with <strong>[PRESTA]</strong> in the subject.
            </p>
            
			
            <br class="clear" />
        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>