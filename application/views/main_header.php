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
        } elseif ($student != null) {
            echo anchor('Student', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
        } else {
            echo anchor('Home', 'Halmstad Hogskolan - Prospects', 'class="navbar-brand"');
        }
        ?>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right navbar-collapse">
        <?php
        if ($user != null) {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?php echo $user->first_name . " " . $user->last_name; ?> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><?php echo anchor('Login/logout', '<i class="fa fa-sign-out fa-fw"></i> Log out'); ?></li>
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
                    <li><?php echo anchor('Login/logout', '<i class="fa fa-sign-out fa-fw"></i> Log out'); ?></li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <?php
        } else {
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
                <?php
                if ($user != null) {
                    switch ($user->level) {
                        case 1:
                            // Sysop
                            echo "<li>" . anchor('Sysop', '<span class="fa fa-home"></span> Home') . "</li>";
                            break;
                        case 2:
                            // Administrator
                            echo "<li>" . anchor('Admin', '<span class="fa fa-home"></span> Home') . "</li>";
                            echo "<li>" . anchor('Admin/emails', '<span class="fa fa-envelope"></span> E-mails') . "</li>";
                            break;
                        case 3:
                            // Analyst
                            echo "<li>" . anchor('Analyst', '<span class="fa fa-bullhorn"></span> Surveys') . "</li>";
                            echo "<li>" . anchor('Analyst/questions', '<span class="fa fa-question-circle"></span> Questions') . "</li>";
                            echo "<li>" . anchor('Analyst/analysis', '<span class="fa fa-binoculars"></span> Analysis') . "</li>";
                            break;
                        }
                } elseif ($student != null) {
                    echo "<li>" . anchor('Student', '<span class="fa fa-home"></span> Home') . "</li>";
                } else {
                    echo "<li>" . anchor('Home', '<span class="fa fa-home"></span> Home') . "</li>";
                }
                ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>