<!--Login page for student-->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Student login</h1>
        </div>
    </div>
    <?php
    $attributes = array('name' => 'loginForm');
    echo form_open('Login_student/login', $attributes);
    $error = json_decode($error);
    ?>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <p><input class="form-control" type="email" id="email" name="email" required="" placeholder="E-mail"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <p><input class="form-control" type="password" id="password" name="password" required="" placeholder="Password"></p>
        </div>
    </div>
    <?php
    if ($error === 1) {
        ?>
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Error!</strong> Wrong e-mail address or password. Please check your e-mail after 3 failed attempts.
                </div>
            </div>
        </div>
        <?php
    }
    echo form_submit('loginSubmit', 'Login', "class='btn btn-primary'");
    echo form_close();
    ?>
</div>
