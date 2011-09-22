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
</head>

<body>
	<div id="header"></div>
        <div id="content">
            <?php echo form_open('objective/add_kpi_submit'); ?>
            <fieldset>
                <legend>Insert Objective</legend>
                
                <?php echo success_msg($misc_success); ?>
                <?php echo error_msg($this->validation->error_string); ?>
                
                <p>
                    <label for="strategic">Select Perspective</label>
                    <br/>
                    <select name="perspective_id">
                        <option value="">- Select -</option>
                        <?php
                        if(getstr($perspective_list))
                        {
                            foreach($perspective_list->result() as $row)
                            {
                                if($this->validation->perspective_id == $row->id)
                                {
                                    $selected = 'selected="selected"';
                                }
                                else
                                {
                                    $selected = '';
                                }
                        ?>
                                <option value="<?php echo $row->id;?>" <?php echo $selected; ?>><?php echo $row->name;?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </p>
                
                <p>
                    <label for="objective">Objective Description</label>
                    <br/>
                    <textarea id="objective" name="name"><?php echo getstr($this->validation->name); ?></textarea>
                    
                </p>
            
                <div class="buttons">
                    <button class="positive" type="submit">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                    Save
                    </button>
                    <a href="<?php echo site_url('kpi'); ?>" class="positive">
                    <img alt="" src="<?php echo $this->image; ?>sitedesign/arrow_left.png"/>
                    Back
                    </a>
                </div>
            </fieldset>
            </form>
            
            <?php if(getstr($objective_list)) { ?>
                <h2>Objective List</h2>
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    foreach($objective_list->result() as $row)
                    {
                    ?>
                        <tr>
                            <td><?php echo truncate($row->name, 50); ?></td>
                            <td>
                                <a href="<?php echo site_url('measure/index/' . $row->id); ?>">
                                    Add Measurement
                                </a>
                            </td>
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