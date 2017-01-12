<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>    
    <body>
<div class="container">
    <div class="row">
        <div class="col-md-3 bg-primary">
            <img  src="http://www.ausiasmarch.net/sites/default/files/logo_blanco_0.png"/>
        </div>
        <div class="col-md-6">
            <h2 class="text-primary text-center"><?php echo lang('login_heading');?></h2>
        </div>
    </div>

<?php $label_atr = ['class' => 'col-sm-2 control-label']; ?>

<h4><?php echo lang('login_subheading');?></h4>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login",['class' => 'form-horizontal']);?>

<div class="form-group">
    <?php echo form_label(lang('login_identity_label'), 'identity', $label_atr); ?>
    <div class="col-md-6">
        <?php echo form_input($identity); ?>
    </div>
</div>

<div class="form-group">
    <?php echo form_label(lang('login_password_label'), 'password', $label_atr); ?>
    <div class="col-md-6">
        <?php echo form_input($password); ?>
    </div>
</div>

<div class="form-group">
    <?php echo form_label(lang('login_remember_label'), 'remember', $label_atr); ?>
    <div class="col-md-6">
        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
    </div>
</div>
    
 <?php echo form_submit('submit', lang('login_submit_btn'),"class='btn btn-primary'");?>

<?php echo form_close();?>

<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

        </div>
    </body>
</html>