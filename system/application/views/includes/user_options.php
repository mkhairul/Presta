                <!--
                <div class="user-options">
                  <?php echo $this->session->userdata('fullname'); ?>, <a href="<?php echo site_url('login/logout'); ?>">Logout</a>
                </div>-->
                <div class="user-options">
                    <ul>
                        <li><a href="<?php echo site_url('user/change_password'); ?>">Change Password</a></li>
                        <li><a href="<?php echo site_url('login/logout'); ?>">Logout</a></li>
                    </ul>
                </div>