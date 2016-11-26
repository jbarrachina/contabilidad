<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css" />

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="/php/contabilidad/css/estilos.css">
        <script src="/php/contabilidad/js/scripts.js" type="text/javascript"></script>
        <title>Apuntes</title>
    </head>
    <body>
        <div class="container">
            <div class="header">
            <div class="row">
                <h2> Fotocopias por familias/departamento </h2>
            </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-2">
                        <h4>
                        Nombre
                        </h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-right">
                        nº copias
                        </h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-right">
                        nº folios
                        </h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="text-right">
                        gastos
                        </h4>
                    </div>
                </div>
            <?php
            $fotocopias = 0;
            $folios = 0;
            $coste = 0;
            $i=0;
            foreach ($gastos as $fila){
                ?>
                <div class="row <?php echo $i%2==0?'bg-info':'';?>">
                    <div class="col-md-2">
                        <?php echo $fila->apellido1.', '.$fila->nombre; ?>
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <?php echo number_format($fila->copias,2,',','.');
                            $fotocopias+=$fila->copias; ?>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <?php echo number_format($fila->hojas,2,',','.');
                            $folios+=$fila->hojas; ?>
                        </p>
                    </div>
                    <div class="col-md-2">
                        <p class="text-right">
                            <?php echo number_format($fila->coste,2,',','.');
                            $coste+=$fila->coste; ?>
                        </p>
                    </div>
                </div>
                
                <?php
                $i++;
            }
            ?>
                <div class="row">
                    <div class="col-md-2">
                        Total: 
                    </div>
                    <div class="col-md-2">
                        <p class="text-right "><strong>
                        <?php echo number_format($fotocopias,2,',','.');?>
                        </strong></p>
                    </div>
                    <div class="col-md-2"><strong>
                        <p class="text-right">
                        <?php echo number_format($folios,2,',','.');?>
                        </strong></p>
                    </div>
                    <div class="col-md-2">
                        <p class="text-right"><strong>
                        <?php echo number_format($coste,2,',','.');?>
                            </strong></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

