<form>
    <dl class="dl-horizontal">
        <?php
        if ($desglose->desglose != "") {
            $filas = explode('|', $desglose->desglose);
            foreach ($filas as $fila) {
                list($codCuenta, $cuenta, $importe) = explode(':', $fila);
                echo "<dt>", $cuenta, "</dt><dd>", $importe, "</dd>";
                echo "<a href='/php/contabilidad/$codCuenta' class='btn btn-default'>borrar</a>";
            }
        }
        ?>
    </dl>
    <button type="button" class="btn-add" id="btn-add<?php echo $desglose->apunte;?>" title="Añadir cuenta">+</button>
</form>