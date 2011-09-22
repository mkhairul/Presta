            <div class="menu">
                <ul>
                    <li class="<?php echo (getstr($current_page) == 'dashboard') ? 'current_page_item':'page_item'; ?>">
                        <a href="<?php echo site_url('dashboard'); ?>"><span>Dashboard</span></a>
                    </li>
                    <li class="current_page_item">
                        <a href="#"><span>Scorecard</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('orgchart'); ?>"><span>Organisation Tree</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('user'); ?>" title="Manage Users"><span>Users</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('position'); ?>"><span>Positions</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('department'); ?>"><span>Departments</span></a>
                    </li>
                    <li class="page_item">
                        <a href="<?php echo site_url('group'); ?>"><span>Groups</span></a>
                    </li>
                </ul>
            </div>