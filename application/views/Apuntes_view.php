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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
        <title>Apuntes</title>
    </head>
    <body>
        <div class="container">
            <form name="tabla" action="/php/contabilidad/apuntes/accion" method="POST">
                <table class="table table-striped table-condensed" >
                    <?php
                    echo "<tr>";
                    echo "<th>Orden</th>";
                    echo "<th>Fecha Apunte</th>";
                    echo "<th>Fecha Pago</th>";
                    echo "<th>Fecha Factura</th10>";
                    echo "<th>tipo</th>";
                    echo "<th>A/B</th>";
                    echo "<th>Caja/Banco</th>";
                    echo "<th>Importe</th>";
                    echo "<th>Concepto</th>";
                    echo "<th>Titular</th>";
                    echo "<th>Observaciones</th>";
                    echo "<th>Documento</th>";
                    echo "</tr>";
                    foreach ($records as $r) {
                        echo "<tr>";
                        $file = "facturas/16" . sprintf("%04d", $r->apunte) . ".pdf";
                        echo "<td><input type='text' size='4' name='apunte[]'  value='". $r->apunte."'</td>";
                        echo "<td>" . $r->fechaApunte . "</td>";
                        echo "<td>" . $r->fechaPago . "</td>";
                        echo "<td>" . $r->fechaFactura . "</td>";
                        echo "<td>" . $r->tipo . "</td>";
                        echo "<td>" . $r->recurso . "</td>";
                        echo "<td>" . $r->destino . "</td>";
                        echo "<td>" . $r->importe . "</td>";
                        echo "<td>" . $r->concepto . "</td>";
                        echo "<td>" . $r->titular . "</td>";
                        echo "<td><input type='text' name='observaciones[]'  value='" . $r->observaciones . "'></td>";
                        echo "<td>";
                        if (file_exists($file)) {
                            echo "<a href=\"$file\">";
                        }
                        echo $r->tipoDocumento;
                        if (file_exists($file)) {
                            echo "</a>";
                        }
                        echo "</td>";
                        echo "</tr>\n";
                    }
                    ?>
                </table>
                <input type="submit" name="Guardar">
            </form>
            <?php echo $this->pagination->create_links() ?>
        </div>
    </body>
</html>

