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
            <div class="row header">           
                <div class="col-md-5 buscar">
                    <form class="form-inline" name="search" action="/php/contabilidad/apuntes/search" method="POST"> 
                        <input placeholder="buscar" class="form-control" id="search" name="search" type="text"/>  
                        <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger" value="Buscar" />
                        <a href="<?php echo "/php/contabilidad/apuntes/pagina"; ?>" class="btn btn-primary">Mostrar todo</a>
                    </form>
                </div>
                <div class="col-md-3 buscar"> 
                    <form class="form-inline" name="upload-file"  action="/php/contabilidad/apuntes/importar" method="post" enctype="multipart/form-data">
                        <label class="btn btn-default btn-file">
                            Selecciona un archivo csv <input name="userfile" type="file" style="display: none;" >
                        </label>
                        <input type="submit" class="btn btn-danger" value="Enviar">
                    </form> 
                </div>
                <div class="col-md-2 buscar"> 
                     <a href="/php/contabilidad/apuntes/listado" class="btn btn-primary btn-xs">Resumen</a>
                     <a href="/php/contabilidad/fotocopias/familias/201601/<?php echo date('Ym'); ?>" class="btn btn-primary btn-xs">Fotocopias</a>
                </div>
                <div class="col-md-2">
                    <dl class="dl-horizontal pull-right">
                        <?php                       
                            echo "<dt><h4>Ingreso</h4></dt><dd><h4><span class='label label-success'>", number_format($total['Ingreso'], 2, ",", "."), "</span></h4></dd>";                   
                            echo "<dt><h4>Gasto</h4></dt><dd><h4><span class='label label-danger'>", number_format($total['Gasto'], 2, ',', '.'), "</span></h4></dd>";
                        ?>
                    </dl>
                </div>

            </div>
            <form name="tabla" action="/php/contabilidad/apuntes/accion" method="POST">          
                <div class="row bg-primary titulos">
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
                <?php
                if (isset($records)) {
                    $i = 1;
                    foreach ($records as $r) {
                        echo "<div class=\"" . ($i++ % 2 == 1 ? "odd" : "even bg-warning") . "\">";
                        echo "<div class='row'>\n";
                        $file = "facturas/16" . sprintf("%04d", $r->apunte) . ".pdf";
                        echo "<div class='col-md-1'><input type='text' size='4' name='apunte[]'  value='" . $r->apunte . "'></div>\n";
                        echo "<div class='col-md-1'>" . $r->fechaApunte . "<br>";
                        echo $r->fechaPago . "</div>\n";
                        echo "<div class='col-md-1'>" . $r->fechaFactura . "</div>\n";
                        echo "<div class='col-md-1'>" . $r->recurso . "-" . $r->tipo . "-" . $r->destino . "</div>\n";
                        echo "<div class='col-md-1 ", ($r->tipo == 'Ingreso') ? "text-danger" : "", " text-right'><strong>" . number_format($r->importe, 2, ',', '.') . "</strong></div>\n";
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
                            <button type="button" data-toggle="collapse" class="btn-des btn btn-xs btn-info pull-right" id="btn-des<?php echo $r->apunte; ?>" name="des<?php echo $r->apunte; ?>"
                                    data-target="#collapseExample<?php echo $r->apunte; ?>" aria-expanded="false" aria-controls="collapseExample<?php echo $r->apunte; ?>" 
                                    title='Desglose'>
                                <span class="badge"><?php echo substr_count($r->desglose, ':') / 2; ?></span>
                            </button>
                        </div>
                </div>
                <div class="row">
                    <div class="collapse col-md-6" id="collapseExample<?php echo $r->apunte; ?>">
                        <div class="well">
                            <dl class="dl-horizontal">
                                <?php
                                if ($r->desglose != "") {
                                    $filas = explode('|', $r->desglose);
                                    foreach ($filas as $fila) {
                                        list($codCuenta, $cuenta, $importe) = explode(':', $fila);
                                        echo "<dt id='dt{$r->apunte}-{$codCuenta}'>";     
                                        echo $cuenta, "</dt><dd id='dd{$r->apunte}-{$codCuenta}'>", $importe;
                                        echo " <button id='bt{$r->apunte}-{$codCuenta}' class='btn-delete-desglose btn btn-danger btn-xs'>x</button>";
                                        echo "</dd>";
                                    }
                                }
                                ?>
                            </dl>
                            <button type="button" class="btn-add" id="btn-add<?php echo $r->apunte; ?>" title="Añadir cuenta">+</button>                    
                        </div>
                    </div>
                </div>
            </div> <!-- fila doble -->
            <?php
        }//each
    }//if
    else {
        echo "<p> No se encuentran resultados </p>";
    }
    ?>

    <button id="btn-des" class="btn btn-primary" type="submit">Modificar</button>
</form>
<?php echo $this->pagination->create_links() ?>
</div>
</body>
</html>