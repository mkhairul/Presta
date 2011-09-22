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
            <?php echo form_open('measure/add_submit'); ?>
            <fieldset>
                <legend>Insert Measurement</legend>
                
                <?php echo success_msg($misc_success); ?>
                <?php echo error_msg($this->validation->error_string); ?>
                
                <p>
                    <label for="strategic">Objective</label>
                    <br/>
                    <span><?php echo getstr($objective_name); ?></span>
                    <input type="hidden" name="objective_id" value="<?php echo $objective_id; ?>" />
                </p>
                
                <p>
                    <label for="measure">Measurement Name</label>
                    <br/>
                    <input id="measure" class="title" type="text" value="" name="name"/>
                </p>
                <p>
                    <label for="target">Target</label>
                    <br/>
                    <input id="target" class="title" type="text" value="" name="target"/>
                </p>
            
                <div class="buttons">
                    <button class="positive" type="submit">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                    Save
                    </button>
                    <a href="<?php echo site_url('objective/index/' . $strategic_id); ?>">
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/arrow_left.png"/>
                        Back
                    </a>
                    <a href="<?php echo site_url('kpi'); ?>">
                        <img alt="" src="<?php echo $this->image; ?>sitedesign/arrow_left.png"/>
                        Back to KPI
                    </a>
                </div>
            </fieldset>
            </form>
            
            <?php if(getstr($measure_list)) { ?>
                <h2>Measurement List</h2>
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Name</th>
                        <th>Target</th>
                    </tr>
                    <?php
                    foreach($measure_list->result() as $row)
                    {
                    ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo ($row->target) ? $row->target:'-'; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php } ?>
        </div>
        <div id="footer"></div>
</body>
</html>