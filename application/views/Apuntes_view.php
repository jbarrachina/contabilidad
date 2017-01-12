
            
            <div class="row sub-header">    
                <div class="header">
                    <div class="col-md-4 buscar">
                        <form class="form-inline" name="search" action="/php/contabilidad/apuntes/search" method="POST"> 
                            <input placeholder="buscar" class="form-control input-sm" id="search" name="search" type="text"/>  
                            <input id="btn_search" name="btn_search" type="submit" class="btn btn-danger btn-sm" value="Buscar" />
                            <a href="<?php echo "/php/contabilidad/apuntes/pagina"; ?>" class="btn btn-primary btn-sm">Todo</a>
                        </form>
                    </div>
                    <div class="col-md-3 buscar"> 
                        <form class="form-inline" id="form-import" name="upload-file"  action="/php/contabilidad/apuntes/importar" method="post" enctype="multipart/form-data">
                            <label class="btn btn-default">
                                <small>
                                Selecciona un archivo csv <input name="userfile" type="file" class="input-sm" style="display: none;" >
                                </small>
                            </label>              
                        </form> 
                        <button id="btn-importar" class="btn btn-danger btn-xs">Importar</button>
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
                    <div class="col-md-1" id="year">
                        <br>
                        <a href="/php/contabilidad/apuntes/change_year/2016" class="btn btn-<?php echo $this->session->userdata('anyo') === '2016' ? 'primary' : 'default'; ?> btn-xs change_year">2016</a>
                        <a href="/php/contabilidad/apuntes/change_year/2017" class="btn btn-<?php echo $this->session->userdata('anyo') === '2017' ? 'primary' : 'default'; ?> btn-xs change_year">2017</a>            
                    </div>
                </div> 
            </div>
            <div class="row"></div>
            <div class="row bg-primary titulos">
                <div class="col-md-1"><h4>Orden</h4></div>
                <div class="col-md-1"><h4>Apunte Pago</h4></div>
                <div class="col-md-1"><h4>Fecha Factura</h4></div>
                <div class="col-md-1"><h4>Tipo</h4></div>
                <div class="col-md-5"><h4>Concepto</h4></div>
                <div class="col-md-3"><h4>Observaciones</h4></div>                                    
            </div>
                <?php
                if (isset($records)) {
                    $i = 1;
                    foreach ($records as $r) {?>
                        <div class="<?php echo ($i % 2 == 1 ? 'odd' : 'even bg-warning');?>">
                            <div class='row <?php echo ($i % 2 == 1 ? 'odd' : 'even bg-warning');?>'>
                                <?php $file = "facturas/16" . sprintf("%04d", $r->apunte) . ".pdf";?>
                                <div class="col-md-1">
                                    <input type="text" class="input-sm" size="4" name="apunte[]"  value="<?php echo $r->apunte;?>">
                                </div>
                                <div class='col-md-1'>
                                    <?php echo $r->fechaApunte;?><br>
                                    <?php echo $r->fechaPago;?>
                                </div>
                                <div class='col-md-1'>
                                    <?php echo $r->fechaFactura?>
                                </div>
                                <div class='col-md-1'>
                                    <?php echo $r->recurso . "-" . $r->tipo . "-" . $r->destino;?><br>
                                </div>
                                <div class='col-md-5'>
                                    <?php echo $r->concepto;?><br>                                  
                                    <?php echo $r->titular;?> <br>
                                    <?php echo $r->cuenta;?> 
                                </div>
                                <div class='col-md-3'>
                                    <?php
                                    if (file_exists($file)) {
                                        echo "<a href=\"/php/contabilidad/$file\" target='_blank'>";
                                    }
                                    echo $r->tipoDocumento;
                                    if (file_exists($file)) {
                                        echo "</a>";
                                    }
                                    ?>
                                </div>    
                                    <div class="input-group">
                                        <input id="<?php echo "it-observaciones-" . $r->apunte; ?>" type="text" class="it-observaciones input-sm"  value="<?php echo $r->observaciones; ?>">
                                        <button id="<?php echo "btuo-" . $r->apunte; ?>" class="btn-update-observaciones btn btn-xs">
                                            <span class='glyphicon glyphicon-save' aria-hidden='true'></span>
                                        </button>
                                        <button type="button" data-toggle="collapse" class="btn-des btn btn-xs btn-info" id="btn-des<?php echo $r->apunte; ?>" name="des<?php echo $r->apunte; ?>"
                                                data-target="#collapseExample<?php echo $r->apunte; ?>" aria-expanded="false" aria-controls="collapseExample<?php echo $r->apunte; ?>" 
                                                title="Desglose>
                                                <span class="badge"><?php echo substr_count($r->desglose, ':') / 2; ?></span>
                                        </button>
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
                           </div>
                        <?php
                        $i++;
                        }//each
            }//if
    else {
        echo "<p> No se encuentran resultados </p>";
    }
    echo $this->pagination->create_links() ?>
    </div>        
</body>
</html>