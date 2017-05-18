<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Forgot your password?</h1>
            <p>Please fill in your password here. An e-mail will be sent to change your password.</p>
        </div>
    </div>
    <?php $attributes = array('name' => 'myform', 'method' => 'post');
    echo form_open('Login/check_email', $attributes);
    ?>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <p><input class="form-control" type="email" id="emailadres" name="email" required="" placeholder="E-mail"></p>
        </div>
    </div>
    <?php
    if ($error === 1) {
        ?>
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Error!</strong> This e-mail address doesn't exist within our database.
                </div>
            </div>
        </div>
        <?php
    }
    echo form_submit('passwordReset', 'Send', "class='btn btn-primary'");
    ?>
    <a id="back" class="btn btn-default" href="javascript:history.go(-1);">Back</a>
    <?php
    echo form_close();
    ?>
    
</div>
