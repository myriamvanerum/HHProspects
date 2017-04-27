<?php 
$user = $this->authex->getUserInfo(); 
$student = $this->authex->getStudentInfo();
?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?php
        if ($user != null) {
            switch ($user->level) {
                case 1:
                    // Sysop
                    echo anchor('Sysop', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
                    break;
                case 2:
                    // Administrator
                    echo anchor('Admin', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
                    break;
                case 3:
                    // Analyst
                    echo anchor('Analyst', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
                    break;
            }
        } elseif($student != null) {
            echo anchor('Student', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
        }
        else {
            echo anchor('Home', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
        }
        ?>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <?php
        if ($user != null) {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?php echo $user->first_name . " " . $user->last_name; ?> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><?php echo anchor('Login/logout', '<i class="fa fa-sign-out fa-fw"></i> Logout'); ?></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <?php
        } elseif ($student != null) {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?php echo $student->first_name . " " . $student->last_name; ?> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><?php echo anchor('Login/logout', '<i class="fa fa-sign-out fa-fw"></i> Logout'); ?></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <?php
        }
        else {
            ?>
            <li class="dropdown">
                <?php echo anchor('Login', '<i class="fa fa-user fa-fw"></i> Login', 'class="dropdown-toggle"'); ?>
            </li>
            <?php
        }
        ?>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li><?php echo anchor('Login_sysop', 'SYSOP Login'); ?></li>
                <li><?php echo anchor('Login_student', 'Student Login'); ?></li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="flot.html">Flot Charts</a>
                        </li>
                        <li>
                            <a href="morris.html">Morris.js Charts</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li><a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a></li>
                <li><a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a></li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>