<?php //$gebruiker = $this->authex->getUserInfo(); ?>
<?php 
function echoActiveClass($pagina)
{
    
}
?>
<nav class="navbar navbar-inverse header">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php echo anchor('Homepagina', "<span class='glyphicon glyphicon-globe'></span> De Weide Wereld", 'class="navbar-brand"'); ?>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
                <li <?=echoActiveClass("home")?>><?php echo anchor('Homepagina', "Home"); ?></li>
                <li> <?php echo anchor('Workshop/filter/', "Workshops"); ?></li>
            <?php
                    echo '<ul class="nav navbar-nav navbar-right">';
                    echo '<li>' . anchor('Inloggen/loginscherm', 'Inloggen') . '</li>';
                    echo '</ul>';

                ?>

        </div>
    </div>
</nav>