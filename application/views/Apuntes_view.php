<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang=""es>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/black-tie/jquery-ui.css" />

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">

        <script src="/php/contabilidad/js/scripts.js" type="text/javascript"></script>
        <title>Apuntes</title>
    </head>
    <body>
        <div class="container">
            <form name="tabla" action="/php/contabilidad/apuntes/accion" method="POST">          
                <div class="row bg-primary">
                    <div class="col-md-1"><br><h4>Orden</h4></div>
                    <div class="col-md-1"><h4>Apunte Pago</h4></div>
                    <div class="col-md-1"><h4>Fecha Factura</h4></div>
                    <div class="col-md-1"><br><h4>Tipo</h4></div>
                    <div class="col-md-1"><br><h4>Importe</h4></div>
                    <div class="col-md-3"><br><h4>Concepto</h4></div>
                    <div class="col-md-2"><br><h4>Observaciones</h4></div>
                    <div class="col-md-1"><br><h4>Documento</h4></div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row"><br></div>
                <?php
                foreach ($records as $r) {
                    echo "<div class='row'>\n";
                    $file = "facturas/16" . sprintf("%04d", $r->apunte) . ".pdf";
                    echo "<div class='col-md-1'><input type='text' size='4' name='apunte[]'  value='" . $r->apunte . "'></div>\n";
                    echo "<div class='col-md-1'>" . $r->fechaApunte . "<br>";
                    echo $r->fechaPago . "</div>\n";
                    echo "<div class='col-md-1'>" . $r->fechaFactura . "</div>\n";
                    echo "<div class='col-md-1'>" . $r->recurso . "-" . $r->tipo . "-" . $r->destino . "</div>\n";
                    echo "<div class='col-md-1 text-right'><strong>" . $r->importe . "</strong></div>\n";
                    echo "<div class='col-md-3'>" . $r->concepto . "<br>";
                    echo $r->titular . "</div>\n";
                    echo "<div class='col-md-2'><input type='text' name='observaciones[]'  value='" . $r->observaciones . "'></div>";
                    echo "<div class='col-md-1'>";
                    if (file_exists($file)) {
                        echo "<a href=\"/php/contabilidad/$file\">";
                    }
                    echo $r->tipoDocumento;
                    if (file_exists($file)) {
                        echo "</a>";
                    }
                    echo "</div>\n";
                    ?>
                    <div class="col-md-1">
                        <button type="button" data-toggle="collapse" class="btn-des btn btn-info" id="btn-des<?php echo $r->apunte; ?>" name="des<?php echo $r->apunte; ?>"
                                data-target="#collapseExample<?php echo $r->apunte; ?>" aria-expanded="false" aria-controls="collapseExample<?php echo $r->apunte; ?>" 
                                title='Desglose'>
                        </button>
                    </div>
            </div> <!--row -->
            <div class="row">
                <div class="collapse col-md-6" id="collapseExample<?php echo $r->apunte; ?>">
                    <div class="well">
                          <dl class="dl-horizontal">
                                <?php
                                if ($r->desglose != "") {
                                    $filas = explode('|', $r->desglose);
                                    foreach ($filas as $fila) {
                                        list($codCuenta, $cuenta, $importe) = explode(':', $fila);
                                        echo "<dt>", $cuenta, "</dt><dd>", $importe, "</dd>";
                                    }
                                }
                                ?>
                            </dl>
                            <button type="button" class="btn-add" id="btn-add<?php echo $r->apunte;?>" title="Añadir cuenta">+</button>                    
                    </div>
                </div>
            </div>
            <?php
        }//each
        ?>
        <button id="btn-des" class="btn btn-primary" type="submit">Modificar</button>
    </form>
    <?php echo $this->pagination->create_links() ?>
</div>
</body>
</html>