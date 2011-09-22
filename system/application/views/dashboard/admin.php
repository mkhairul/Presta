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
<script type="text/javascript" src="<?php echo $this->js; ?>jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo $this->js; ?>jquery.curvycorners.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#content').corner();
    $("tbody tr:nth-child(odd)").addClass("even");
    $("tbody tr td:first-child").css('font-weight', 'bold');
});
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
                <h2><?php echo $title; ?></h2>
            </div>
            
            <div class="menu" style="margin-bottom: 10px;">
                <ul>
                    <li class="current_page_item">
                        <a href="<?php echo site_url('scorecard'); ?>"><span>&laquo; Back</span></a>
                    </li>
                </ul>
            </div>
            
            <br class="clear" />
            
            <div>
                <table class="minimal minimal-border" cellpadding="0" cellspacing="0" border="0">              
                    <tbody>
                        <tr>
                            <td style="width: 250px;">Total KPI</td>
                            <td><?php echo $this->kpi->total_kpi(); ?></td>
                        </tr>
                        <tr>
                            <td>Total Users</td>
                            <td><?php echo $this->user->total(); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>