<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Reset your password</h1>
            <p>Please fill in your password here. This will reset the password for <b><?php echo $email;?></b>.</p>
        </div>
    </div>
    <?php $attributes = array('name' => 'myform', 'method' => 'post');
    echo form_open('Login/change_password', $attributes);
    ?>
    <input class="form-control hidden" type="text" id="email" name="email" value="<?php echo $email;?>">
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <p><input class="form-control" type="password" id="password" name="password" required="" placeholder="Password"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <p><input class="form-control" type="password" id="passwordControl" name="passwordControl" required="" placeholder="Password control"></p>
        </div>
    </div>
    <?php
    if ($error === 1) {
        ?>
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Error!</strong> The passwords don't match. Please try again.
                </div>
            </div>
        </div>
        <?php
    }
    echo form_submit('passwordReset', 'Submit', "class='btn btn-primary'");
    ?>
    <?php
    echo form_close();
    ?>
    
</div>
