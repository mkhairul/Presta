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
})

function select_subordinate(row_id, user_id)
{
    user_fullname = $('#'+row_id+' .name').html();
    $('#dialogue_title .moreinfo').html(user_fullname);
    
    $('.minimal tbody tr').animate({opacity:0}, "normal", function(){        
        $('.minimal tbody tr').hide();
        $('#'+row_id).css('opacity', '1')
        $('#'+row_id).show();
        
        $('#dialogue_contents').show();
        $('.subordinate_id').val(user_id);
    });
    
    $("tbody tr:nth-child(odd)").addClass("even");
    
    $.post('<?php echo site_url('kpi/ajax_subordinate_get_details'); ?>', { id: user_id}, function(data){
        if(data.status == 'success')
        {
            $('#1stquarter .display .contents').html(data.data.first);
            $('#2ndquarter .display .contents').html(data.data.second);
            $('#3rdquarter .display .contents').html(data.data.third);
            $('#final .display .contents').html(data.data.final);
            
            switch(data.data.rating)
            {
                case '1':
                    rating_str = '1 - Poor'
                    break;
                case '2':
                    rating_str = '2 - Unsatisfactory'
                    break;
                case '3':
                    rating_str = '3 - Average'
                    break;
                case '4':
                    rating_str = '4 - Good'
                    break;
                case '5':
                    rating_str = '5 - Excellent'
                    break;
            }
            if(data.data.rating)
            {
                $('#final .display #rating span').html(rating_str);
            }
        }
        else
        {
            // NOTHING!
        }
    }, "json")
    
    return false;
}

function edit_dialogue(id_name)
{
    $('#'+id_name+' .display').animate({opacity:0}, "normal", function(){
        $(this).hide();
        $('#'+id_name+' .contents-edit textarea').val($(this).children('.contents').html())
        $('#'+id_name+' .contents-edit').css('opacity', 0);
        $('#'+id_name+' .contents-edit').show();
        $('#'+id_name+' .contents-edit').animate({opacity: 1}, "normal");
    })
    
    return false;
}

function display_dialogue(id_name)
{
    $('#'+id_name+' .contents-edit').animate({opacity:0}, "normal", function(){
        $(this).hide();
        $('#'+id_name+' .display').css('opacity', 0);
        $('#'+id_name+' .display').show();
        $('#'+id_name+' .display').animate({opacity: 1}, "normal");
    })
    
    return false;
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
                <h2>View Subordinate(s)</h2>
            </div>
            
            <div class="menu">
                <ul>
                    <li class="page_item">
                        <a href="<?php echo site_url('kpi'); ?>"><span>KPI</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('initiative'); ?>"><span>Initiative</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('dialogue'); ?>" title="Quaterly Performance and Developmental Dialogue"><span>Performance Dialogue</span></a>
                    </li>
                    <li class="current_page_item">
                        <a href="<?php echo site_url('kpi/subordinate'); ?>" title=""><span>View Subordinates</span></a>
                    </li>
                </ul>
            </div>
            
            <br class="clear"/>
            
            <?php echo success_msg($misc_success); ?>
            <?php echo error_msg($misc_error); ?>
            
            <table cellspacing="0" cellpadding="0" border="0" class="minimal">
                <thead>
                    <tr>
                        <th class="first">Name</th>
                        <th>Position</th>
                        <th style="width: 200px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(getstr($subordinate_list)){ ?>
                        <?php foreach($subordinate_list->result() as $row){ ?>
                            <tr id="user_<?php echo $row->id;?>">
                                <td class="first">
                                    <span class="name"><?php echo $row->fullname; ?></span>
                                </td>
                                <td><?php echo $this->position->get_name($row->position_id); ?></td>
                                <td>
                                    <ul>
                                        <li>
                                            <a href="<?php echo site_url('kpi/view_subordinate/' . $row->id); ?>">
                                            View KPI
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('initiative/overview_subordinate/' . $row->id); ?>">
                                            View Initiative
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" onclick="return select_subordinate('user_<?php echo $row->id;?>', <?php echo $row->id;?>)">
                                            Dialog Comments
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td colspan="3" class="first">No subordinates</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <br/>
            
            <div id="dialogue_contents" class="hide">
                <h3 id="dialogue_title">Dialogue Comments for <span class="moreinfo green">No user selected</span></h3>
                
                <div class="content-box" id="1stquarter">
                    <h3>1<sup>st</sup> Quarter
                        <a href="#" class="edit" onclick="return edit_dialogue('1stquarter');">edit</a>
                    </h3>
                    <div class="display">
                        <div class="contents">No comments.</div>
                    </div>
                    <div class="contents-edit hide">
                        <?php echo form_open('kpi/subordinate_quarter_save/1'); ?>
                            <input type="hidden" class="subordinate_id" name="subordinate_id" value="" />
                            <textarea name="content" style="width: 95%; height: 50px;"></textarea>
                            <div class="buttons button-section">
                                <button class="positive" type="submit">
                                <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                                Save
                                </button>
                                <a href="#" class="negative" onclick="return display_dialogue('1stquarter');">
                                <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                                Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="content-box" id="2ndquarter">
                    <h3>2<sup>nd</sup> Quarter
                        <a href="#" class="edit" onclick="return edit_dialogue('2ndquarter');">edit</a>
                    </h3>
                    <div class="display">
                        <div class="contents">No comments.</div>
                    </div>
                    <div class="contents-edit hide">
                        <?php echo form_open('kpi/subordinate_quarter_save/2'); ?>
                            <input type="hidden" class="subordinate_id" name="subordinate_id" value="" />
                            <textarea name="content" style="width: 95%; height: 50px;"></textarea>
                            <div class="buttons button-section">
                                <button class="positive" type="submit">
                                <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                                Save
                                </button>
                                <a href="#" class="negative" onclick="return display_dialogue('2ndquarter');">
                                <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                                Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="content-box" id="3rdquarter">
                    <h3>3<sup>rd</sup> Quarter
                        <a href="#" class="edit" onclick="return edit_dialogue('3rdquarter');">edit</a>
                    </h3>
                    <div class="display">
                        <div class="contents">No comments.</div>
                    </div>
                    <div class="contents-edit hide">
                        <?php echo form_open('kpi/subordinate_quarter_save/3'); ?>
                            <input type="hidden" class="subordinate_id" name="subordinate_id" value="" />
                            <textarea name="content" style="width: 95%; height: 50px;"></textarea>
                            <div class="buttons button-section">
                                <button class="positive" type="submit">
                                <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                                Save
                                </button>
                                <a href="#" class="negative" onclick="return display_dialogue('3rdquarter');">
                                <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                                Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                
                <div class="content-box" id="final">
                    <div class="span-14">
                        <h3>Final Review &amp; Rating
                            <a href="#" class="edit" onclick="return edit_dialogue('final');">edit</a>
                        </h3>
                        <div class="display">
                            <div class="contents">
                                No comments.
                            </div>
                            <div id="rating">
                                <strong>Rating:</strong> <span></span>
                            </div>
                        </div>
                        <div class="contents-edit hide">
                            <?php echo form_open('kpi/subordinate_quarter_save/final'); ?>
                                <input type="hidden" class="subordinate_id" name="subordinate_id" value="" />
                                <textarea name="content" style="width: 95%; height: 50px;"></textarea>
                                
                                <div>
                                    <strong>Rating</strong><br/>
                                    <input type="radio" name="rating" value="1" />Poor<br/>
                                    <input type="radio" name="rating" value="2" />Unsatisfactory<br/>
                                    <input type="radio" name="rating" value="3" />Average<br/>
                                    <input type="radio" name="rating" value="4" />Good<br/>
                                    <input type="radio" name="rating" value="5" />Excellent<br/>
                                </div>
                                
                                <div class="buttons button-section">
                                    <button class="positive" type="submit">
                                    <img alt="" src="<?php echo $this->image; ?>sitedesign/tick.png"/>
                                    Save
                                    </button>
                                    <a href="#" class="negative" onclick="return display_dialogue('final');">
                                    <img alt="" src="<?php echo $this->image; ?>sitedesign/cross.png"/>
                                    Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="span-5" style="padding-left: 5px;">
                        <span><strong>Legend</strong></span>
                        <ul>
                            <li>1 – Poor (44 and below)</li>
                            <li>2 – Unsatisfactory (45-64)</li>
                            <li>3 – Average (65-79)</li>
                            <li>4 – Good (80 -99)</li>
                            <li>5 – Excellent (100 and above)</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->load->view('includes/footer', $this); ?>
</body>
</html>