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
<script type="text/javascript">
$(document).ready(function(){
  $("tbody tr:nth-child(even)").addClass("even");
})
</script>
</head>

<body>
	<div id="header"></div>
        <div id="content">
            <div style="float:right; margin-top: 15px;">
			  <?php echo $this->session->userdata('fullname'); ?>, <a href="<?php echo site_url('login/logout'); ?>">Logout</a>
			</div>
            <h2>Objective Details</h2>
            
            <?php
            $row = $details->result();
            echo var_dump($row);
            ?>
            
            <label>Perspective Name</label>
            <br/>
            <span><?php echo $row[0]->perspective_name; ?></span>
            
            
            
        </div>
        <div id="footer"></div>
</body>
</html>