<?php

if ($_SESSION['valid_login']['designation'] == 'HR' && $this->userData[0]->status == '1') {
    $das = base_url() . 'dashboard';
?>
    <div class="sidebar-inner slimscroll">

        <div id="sidebar-menu" class="sidebar-menu">

            <ul>

                <li class="menu-title">

                    <span>Main</span>

                </li>
                <li>
                    <a href="<?= $das ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                </li>


                <li class="menu-title">

                    <span>Employees</span>

                </li>

                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Employees </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>
                            <a href="<?= base_url() . 'employee' ?>" class="<?= ($this->uri->segment(1) == 'employee' && $this->uri->segment(2) == '') ? 'active' : '' ?>">All Employees</a>

                        </li>
                        <li>
                            <a href="<?= base_url() . 'employee/deleted_employee' ?>" class="<?= ($this->uri->segment(2) == 'deleted_employee' && $this->uri->segment(1) == 'employee') ? 'active' : '' ?>">Deleted Employees</a>
                        </li>

                    </ul>

                </li>

                <li>
                    <a href="<?= base_url() . 'leave_application' ?>" class="<?= ($this->uri->segment(1) == 'leave_application') ? 'active' : '' ?>"><i class="la la-files-o"></i><span>Leaves</span>

                    </a>

                </li>
                <li>
                    <a href="<?= base_url() . 'leave_setting' ?>" class="<?= ($this->uri->segment(1) == 'leave_setting') ? 'active' : '' ?>"><i class="la la-files-o"></i><span>Settings</span></a>
                </li>
                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Attendance </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>

                            <a href="<?= base_url() . 'attendance/manage_attendance' ?>" class="<?= ($this->uri->segment(2) == 'manage_attendance') ? 'active' : '' ?>">Manage Attendance
                                <!-- (Admin) -->
                            </a>

                        </li>

                        <li>
                            <a href="<?= base_url() . 'attendance' ?>" class="<?= ($this->uri->segment(2) == 'emp_attendance' || $this->uri->segment(1) == 'attendance' && $this->uri->segment(2) == '') ? 'active' : '' ?>">Attendance
                                <!-- (Employee) -->
                            </a>

                        </li>

                    </ul>

                </li>





                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Report </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">
                        <!-- <li><a href="payments.php">Payments</a></li> -->

                        <li>
                            <a href="<?= base_url() . 'month_report' ?>" class="<?= ($this->uri->segment(1) == 'month_report') ? 'active' : '' ?>">Month Final Report</a>
                        </li>
                        <li>
                            <a href="<?= base_url() . 'settlement' ?>" class="<?= ($this->uri->segment(1) == 'settlement') ? 'active' : '' ?>">Settlment Record</a>
                        </li>


                    </ul>

                </li>


                <li>

                    <a href="<?= base_url() . 'leades' ?>" class="<?= ($this->uri->segment(1) == 'project') ? 'active' : '' ?>"><i class="la la-user-secret"></i> <span>Leads</span></a>

                </li>

                <li>
                    <a href="<?= base_url() . 'timesheet' ?>" class="<?= ($this->uri->segment(1) == 'timesheet') ? 'active' : '' ?>"><i class="la la-user-secret"></i><span>Reporting</span></a>
                </li>








                <li class="menu-title">

                    <span>HR</span>

                </li>
                <li><a href="<?= base_url() . 'expenses' ?>" class="<?= ($this->uri->segment(1) == 'expenses') ? 'active' : '' ?>"><i class="las la-file-invoice"></i><span>Expenses</span></a></li>




                <li>
                    <a href="<?= base_url() . 'emp_punching_status' ?>"><i class="fas fa-tachometer-alt"></i><span>Employee Punching Status</span></a>
                </li>





                <li class="menu-title">

                    <span>Other</span>

                </li>

                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Other </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>

                            <a href="<?= base_url() . 'holidays' ?>" class="<?= ($this->uri->segment(1) == 'holidays') ? 'active' : '' ?>">Holidays</a>

                        </li>



                        <li>

                            <a href="<?= base_url() . 'manage_saturday' ?>" class="<?= ($this->uri->segment(1) == 'manage_saturday') ? 'active' : '' ?>">Saturday</a>

                        </li>

                        <li>

                            <a href="<?= base_url() . 'department' ?>" class="<?= ($this->uri->segment(1) == 'department') ? 'active' : '' ?>">Technology</a>

                        </li>
                        <li>

                            <a href="<?= base_url() . 'designation' ?>" class="<?= ($this->uri->segment(1) == 'designation') ? 'active' : '' ?>">Designations</a>

                        </li>

                        <li>

                            <a href="<?= base_url() . 'thought' ?>" class="<?= ($this->uri->segment(1) == 'thought') ? 'active' : '' ?>">Thought</a>

                        </li>

                    </ul>

                </li>


            </ul>

        </div>

    </div>

<?php } else if ($_SESSION['valid_login']['designation'] == 'Admin' && $this->userData[0]->status == '1') {
    $das = base_url() . 'dashboard';
?>
    <div class="sidebar-inner slimscroll">

        <div id="sidebar-menu" class="sidebar-menu">

            <ul>

                <li class="menu-title">

                    <span>Main</span>

                </li>
                <li>
                    <a href="<?= $das ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                </li>


                <li class="menu-title">

                    <span>Employees</span>

                </li>

                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Employees </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>
                            <a href="<?= base_url() . 'employee' ?>" class="<?= ($this->uri->segment(1) == 'employee' && $this->uri->segment(2) == '') ? 'active' : '' ?>">All Employees</a>

                        </li>
                        <li>
                            <a href="<?= base_url() . 'employee/deleted_employee' ?>" class="<?= ($this->uri->segment(2) == 'deleted_employee' && $this->uri->segment(1) == 'employee') ? 'active' : '' ?>">Deleted Employees</a>
                        </li>

                    </ul>

                </li>


                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Leave </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>
                            <a href="<?= base_url() . 'leave_application' ?>" class="<?= ($this->uri->segment(1) == 'leave_application') ? 'active' : '' ?>"><span>Leaves</span>

                            </a>

                        </li>

                        <li>
                            <a href="<?= base_url() . 'bonus_leave' ?>" class="<?= ($this->uri->segment(1) == 'bonus_leave') ? 'active' : '' ?>"><span>Bonus Leave</span></a>
                        </li>
                    </ul>

                </li>



                <li>
                    <a href="<?= base_url() . 'leave_setting' ?>" class="<?= ($this->uri->segment(1) == 'leave_setting') ? 'active' : '' ?>"><i class="la la-files-o"></i><span>Settings</span></a>
                </li>

                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Attendance </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>

                            <a href="<?= base_url() . 'attendance/manage_attendance' ?>" class="<?= ($this->uri->segment(2) == 'manage_attendance') ? 'active' : '' ?>">Manage Attendance
                                <!-- (Admin) -->
                            </a>

                        </li>

                        <li>
                            <a href="<?= base_url() . 'attendance' ?>" class="<?= ($this->uri->segment(2) == 'emp_attendance' || $this->uri->segment(1) == 'attendance' && $this->uri->segment(2) == '') ? 'active' : '' ?>">Attendance
                                <!-- (Employee) -->
                            </a>

                        </li>

                    </ul>

                </li>





                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Report </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">
                        <!-- <li><a href="payments.php">Payments</a></li> -->

                        <li>
                            <a href="<?= base_url() . 'month_report' ?>" class="<?= ($this->uri->segment(1) == 'month_report') ? 'active' : '' ?>">Month Final Report</a>
                        </li>
                        <li>
                            <a href="<?= base_url() . 'settlement' ?>" class="<?= ($this->uri->segment(1) == 'settlement') ? 'active' : '' ?>">Settlment Record</a>
                        </li>


                    </ul>

                </li>


                <li>

                    <a href="<?= base_url() . 'leades' ?>" class="<?= ($this->uri->segment(1) == 'project') ? 'active' : '' ?>"><i class="la la-user-secret"></i> <span>Leads</span></a>

                </li>

                <li>
                    <a href="<?= base_url() . 'timesheet' ?>" class="<?= ($this->uri->segment(1) == 'timesheet') ? 'active' : '' ?>"><i class="la la-user-secret"></i><span>Reporting</span></a>
                </li>


                <li class="submenu">

                    <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>

                    <ul>


                        <li><a href="<?= base_url() . 'project' ?>" class="<?= ($this->uri->segment(1) == 'project') ? 'active' : '' ?>">Projects</a></li>


                        <li><a href="<?= base_url() . 'role_master' ?>" class="<?= ($this->uri->segment(1) == 'role_master') ? 'active' : '' ?>">Role</a></li>

                        <li><a href="<?= base_url() . 'domain_master' ?>" class="<?= ($this->uri->segment(1) == 'domain_master') ? 'active' : '' ?>">Domain</a></li>


                    </ul>

                </li>
                <li>
                    <a href="<?= base_url() . 'project/project_complete_task' ?>" class="<?= ($this->uri->segment(2) == 'project_complete_task') ? 'active' : '' ?>"><i class="fas fa-tasks"></i><span>All Tasks</span></a>
                </li>




                <li class="menu-title">

                    <span>HR</span>

                </li>
                <li><a href="<?= base_url() . 'expenses' ?>" class="<?= ($this->uri->segment(1) == 'expenses') ? 'active' : '' ?>"><i class="las la-file-invoice"></i><span>Expenses</span></a></li>




                <li>
                    <a href="<?= base_url() . 'emp_punching_status' ?>"><i class="fas fa-tachometer-alt"></i><span>Employee Punching Status</span></a>
                </li>





                <li class="menu-title">

                    <span>Other</span>

                </li>

                <li class="submenu">

                    <a href="#"><i class="la la-files-o"></i> <span> Other </span> <span class="menu-arrow"></span></a>

                    <ul style="display: none;">

                        <li>

                            <a href="<?= base_url() . 'holidays' ?>" class="<?= ($this->uri->segment(1) == 'holidays') ? 'active' : '' ?>">Holidays</a>

                        </li>



                        <li>

                            <a href="<?= base_url() . 'manage_saturday' ?>" class="<?= ($this->uri->segment(1) == 'manage_saturday') ? 'active' : '' ?>">Saturday</a>

                        </li>

                        <li>

                            <a href="<?= base_url() . 'department' ?>" class="<?= ($this->uri->segment(1) == 'department') ? 'active' : '' ?>">Technology</a>

                        </li>
                        <li>

                            <a href="<?= base_url() . 'designation' ?>" class="<?= ($this->uri->segment(1) == 'designation') ? 'active' : '' ?>">Designations</a>

                        </li>

                        <li>

                            <a href="<?= base_url() . 'thought' ?>" class="<?= ($this->uri->segment(1) == 'thought') ? 'active' : '' ?>">Thought</a>

                        </li>


                    </ul>

                </li>


            </ul>

        </div>

    </div>

<?php } else if ($_SESSION['valid_login']['designation'] == 'Employee' && $this->userData[0]->status == '1') {

    $das = base_url() . 'employee_dashboard';
?>
    <div class="sidebar-inner slimscroll">

        <div id="sidebar-menu" class="sidebar-menu">

            <ul>

                <li class="menu-title">

                    <span>Main</span>

                </li>
                <li>
                    <a href="<?= $das ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                </li>

                <li>
                    <a href="<?= base_url() . 'leave_application/emp_leave' ?>" class="<?= ($this->uri->segment(2) == 'emp_leave') ? 'active' : '' ?>"><i class="la la-files-o"></i><span>Leaves</span></a>

                </li>


                <li>
                    <a href="<?= base_url() . 'attendance' ?>" class="<?= ($this->uri->segment(2) == 'emp_attendance' || $this->uri->segment(1) == 'attendance' && $this->uri->segment(2) == '') ? 'active' : '' ?>"><i class="las la-user-clock"></i><span>Attendance</span>
                        <!-- (Employee) -->
                    </a>

                </li>

                <li><a href="<?= base_url() . 'project' ?>" class="<?= ($this->uri->segment(1) == 'project') ? 'active' : '' ?>"><i class="las la-project-diagram"></i><span>Projects</span></a></li>

                <li>

                    <a href="<?= base_url() . 'task' ?>" class="<?= ($this->uri->segment(1) == 'task') ? 'active' : '' ?>"><i class="la la-user-secret"></i> <span>My Task</span></a>

                </li>
                <li>
                    <a href="<?= base_url() . 'timesheet' ?>" class="<?= ($this->uri->segment(1) == 'timesheet') ? 'active' : '' ?>"><i class="la la-user-secret"></i><span>Reporting</span></a>
                </li>

                <?php if($_SESSION['valid_login']['project_manager'] == '1'){ ?>
                    <li>
                    <a href="<?= base_url() . 'project/project_complete_task' ?>" class="<?= ($this->uri->segment(2) == 'project_complete_task') ? 'active' : '' ?>"><i class="fas fa-tasks"></i><span>All Tasks</span></a>
                </li>
                <?php } ?>
                

            </ul>

        </div>

    </div>
<?php } else if ($_SESSION['valid_login']['designation'] == 'Manager') {
    $das = base_url() . 'employee_dashboard';
?>
    <div class="sidebar-inner slimscroll">

        <div id="sidebar-menu" class="sidebar-menu">

            <ul>

                <li class="menu-title">

                    <span>Main</span>

                </li>
                <li>
                    <a href="<?= $das ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                </li>

                <li>
                    <a href="<?= base_url() . 'leave_application/emp_leave' ?>" class="<?= ($this->uri->segment(2) == 'emp_leave') ? 'active' : '' ?>"><i class="la la-files-o"></i><span>Leaves</span></a>

                </li>


                <li>
                    <a href="<?= base_url() . 'attendance' ?>" class="<?= ($this->uri->segment(2) == 'emp_attendance' || $this->uri->segment(1) == 'attendance' && $this->uri->segment(2) == '') ? 'active' : '' ?>"><i class="las la-user-clock"></i><span>Attendance</span>
                        <!-- (Employee) -->
                    </a>

                </li>

                <li><a href="<?= base_url() . 'project' ?>" class="<?= ($this->uri->segment(1) == 'project') ? 'active' : '' ?>"><i class="las la-project-diagram"></i><span>Projects</span></a></li>

                <li>

                    <a href="<?= base_url() . 'task' ?>" class="<?= ($this->uri->segment(1) == 'task') ? 'active' : '' ?>"><i class="la la-user-secret"></i> <span>Task</span></a>

                </li>
                <li>
                    <a href="<?= base_url() . 'timesheet' ?>" class="<?= ($this->uri->segment(1) == 'timesheet') ? 'active' : '' ?>"><i class="la la-user-secret"></i><span>Reporting</span></a>
                </li>

            </ul>

        </div>

    </div>
<?php }else if($_SESSION['valid_login']['designation'] == 'Trainee'){
    $das = base_url() . 'employee_dashboard';
?>
    <div class="sidebar-inner slimscroll">

        <div id="sidebar-menu" class="sidebar-menu">

            <ul>

                <li class="menu-title">

                    <span>Main</span>

                </li>
                <li>
                    <a href="<?= $das ?>"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                </li>

                <li>
                    <a href="<?= base_url() . 'leave_application/emp_leave' ?>" class="<?= ($this->uri->segment(2) == 'emp_leave') ? 'active' : '' ?>"><i class="la la-files-o"></i><span>Leaves</span></a>

                </li>


                <li>
                    <a href="<?= base_url() . 'attendance' ?>" class="<?= ($this->uri->segment(2) == 'emp_attendance' || $this->uri->segment(1) == 'attendance' && $this->uri->segment(2) == '') ? 'active' : '' ?>"><i class="las la-user-clock"></i><span>Attendance</span>
                        <!-- (Employee) -->
                    </a>

                </li>

                <li><a href="<?= base_url() . 'project' ?>" class="<?= ($this->uri->segment(1) == 'project') ? 'active' : '' ?>"><i class="las la-project-diagram"></i><span>Projects</span></a></li>

                <li>

                    <a href="<?= base_url() . 'task' ?>" class="<?= ($this->uri->segment(1) == 'task') ? 'active' : '' ?>"><i class="la la-user-secret"></i> <span>My Task</span></a>

                </li>
                <li>
                    <a href="<?= base_url() . 'timesheet' ?>" class="<?= ($this->uri->segment(1) == 'timesheet') ? 'active' : '' ?>"><i class="la la-user-secret"></i><span>Reporting</span></a>
                </li>

                <?php if($_SESSION['valid_login']['project_manager'] == '1'){ ?>
                    <li>
                    <a href="<?= base_url() . 'project/project_complete_task' ?>" class="<?= ($this->uri->segment(2) == 'project_complete_task') ? 'active' : '' ?>"><i class="fas fa-tasks"></i><span>All Tasks</span></a>
                </li>
                <?php } ?>
                

            </ul>

        </div>

    </div>

<?php } ?> ?>