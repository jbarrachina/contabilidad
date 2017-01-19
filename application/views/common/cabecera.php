<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css" />        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="/php/contabilidad/css/estilos.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="/php/contabilidad/js/scripts.js" type="text/javascript"></script>
        <title><?php echo $title; ?></title>
    </head>    
<body>
<div class="container">
    <div class="row header">
        <div class="header">
            <div class="col-md-3 header">
                <img  src="http://www.ausiasmarch.net/sites/default/files/logo_blanco_0.png"/>
            </div>
            <div class="col-md-6">
                <h2 class="text-center"><?php echo $title; ?></h2>
            </div>
            <div class="col-md-3">
                <h5 class="text-muted">
                    <?php echo $this->ion_auth->user()->row()->last_name, ', ' . $this->ion_auth->user()->row()->first_name; ?>
                    <a class="text-muted" href='<?php echo site_url(); ?>/auth/logout' >
                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                    </a>
                </h5>
            </div>
        </div>
    </div>
    <div id="logo-navigation" class="logo-navigation">
        <div class="row logo-navigation">
            <div class="col-md-12">
                <ul class="menu">
                    
                    <li class="menu">
                        <a href="/php/contabilidad/apuntes">Apuntes</a>
                    </li>
                    <li class="menu">
                        <a href="/php/contabilidad/apuntes/listado">Resumen</a>
                    </li>
                    <li class="menu">
                        <a href="/php/contabilidad/fotocopias/familias/201601/<?php echo date('Ym'); ?>">Fotocopias</a>
                    </li>
                    <li class="menu">
                        <a href="/php/contabilidad/pendientes">Facturas pendientes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    


