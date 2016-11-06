<form action="/php/contabilidad/desglose/addDesglose" method="post" id="addDesglose">
    <input type="hidden" name="apunte" value="<?php echo $apunte;?>">
    <label for="cuenta">
        Cuenta:
    </label>
    <select id="cuenta" name="cuenta">
       <?php 
       foreach($cuentas as $cuenta){
           echo '<option value="'.$cuenta->conCuenta.'">'.$cuenta->descripcion.'</option>';
       }
       ?>
    </select>
    <label for="importe">
        Importe:
    </label>
    <input type="text" id="importe" name="importe"/> 
    <div class="ui-state-error ui-corner-all" id="contenedorError">
        <p>
            <span class="ui-icon ui-icon-alert iconoError"></span>
            <strong>Atención:</strong><span id="error"></span>
        </p>
    </div>
    

</form>

