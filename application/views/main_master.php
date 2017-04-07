<!DOCTYPE html>
<html>  
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{title}</title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>application/css/images/favicon.png">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/css/bootstrapnew.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/css/custom.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/css/fileinput.css">
        <link rel="stylesheet" type="text/css" href="https://jquery-ui-bootstrap.github.io/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.3.custom.css">
        <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>application/js/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
        </script>
    </head>
    <body>
        <div id="wrap">
            {header}
            {content}
        </div>
        {footer}
    </body>
</html>
