            <div class="menu">
                <ul>
                    <!--
                    <li class="<?php echo (getstr($current_page) == 'dashboard') ? 'current_page_item':'page_item'; ?>">
                        <a href="<?php echo site_url('dashboard'); ?>"><span>Dashboard</span></a>
                    </li>
                    -->
                    <?php if(getstr($disable_all)){ ?>
                    <li class="current_page_item">
                        <a href="<?php echo getstr($disable_back); ?>"><span>&laquo; Back</span></a>
                    </li>
                    <?php }else{ ?>
                    <li class="<?php echo (getstr($current_page) == 'kpi') ? 'current_page_item':'page_item'; ?>">
                        <a href="<?php echo site_url('kpi'); ?>"><span>KPI</span></a>
                    </li>
                    <li class="<?php echo (getstr($current_page) == 'initiative') ? 'current_page_item':'page_item'; ?>">
                        <a href="<?php echo site_url('initiative'); ?>"><span>Initiative</span></a>
                    </li>
                    <li class="<?php echo (getstr($current_page) == 'dialogue') ? 'current_page_item':'page_item'; ?>">
                        <a href="<?php echo site_url('dialogue'); ?>" title="Quaterly Performance and Developmental Dialogue"><span>Performance Dialogue</span></a>
                    </li>
                    <?php
                    // get the group name if its supervisor show this menu
                    if(strtolower($this->group->get_name($this->session->userdata('gid'))) == 'supervisor')
                    {
                    ?>
                        <li class="page_item">
                            <a href="<?php echo site_url('kpi/subordinate'); ?>" title=""><span>View Subordinates</span></a>
                        </li>
                    <?php
                    }
                    ?>
                    <?php } ?>
                </ul>
            </div>