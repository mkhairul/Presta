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

</head>

<body>
	<div id="header"></div>
        <div id="content">
            <?php if(getstr($user_kpi_list)) { ?>
                <h2>User KPI List</h2>
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Objectives</th>
                    </tr>
                    <?php
                    foreach($user_kpi_list->result() as $row)
                    {
                    ?>
                        <tr>
                            <td><?php echo $row->fullname; ?></td>
                            <td><?php echo $this->department->get_name($row->department_id); ?></td>
                            <td>
                                <?php
                                    $total_obj = $this->objective->total($row->user_id);
                                    if($total_obj == 0)
                                    {
                                        $class = 'class="red"';
                                    }
                                    else
                                    {
                                        $class = '';
                                    }
                                ?>
                                <span <?php echo $class; ?>><?php echo $total_obj; ?></span>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } ?>
            <div class="buttons">
                <a class="positive" href="<?php echo site_url('scorecard'); ?>">
                    <img src="<?php echo $this->image; ?>sitedesign/arrow_left.png" alt="" />
                    Back
                </a>
            </div>
        </div>
        <div id="footer"></div>
</body>
</html>