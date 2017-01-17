<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$label_atr = ['class' => 'col-sm-2 control-label']; 
?>

<form class="form-horizontal" id="form-import" name="upload-file"  action="/php/contabilidad/pendientes/add_pendiente" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <?php echo form_label('Factura: ', 'factura', $label_atr); ?>
        <div class="col-md-6">
            <?php echo form_input(['name' => 'factura', 'class' => 'form-control', 'placeholder' => 'Datos de la factura', 'value' => set_value('factura')]); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo form_label('Família: ', 'familia', $label_atr); ?>
        <div class="col-md-6">
            <?php echo form_dropdown('familia',['0'=>'Centro','16'=>'Sanidad', '32'=>'Otros'],['16'],['class' => 'form-control', 'placeholder' => 'Famila', 'value' => set_value('familia')]); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2"> 
        </div>
        <div class="col-md-6">
            <label class="btn btn-default">
                Selecciona un archivo pdf
                <?php
                echo form_upload(['name' => 'userfile', 'class' => 'input form-control',
                    'placeholder' => 'Selecciona el fichero pdf', 'style' => 'display: none;',
                    'value' => set_value('userfile')]);
                ?>
            </label>
            <button id="btn-pendientes" class="btn btn-danger">Cargar</button>
        </div>
    </div>
  
    <div class="listado">
        <?php $i=0; ?>
        <?php foreach($lista_pendientes as $fila) {?>
           <?php if ($this->ion_auth->user()->row()->desde==0 OR  $this->ion_auth->user()->row()->desde==$fila->familia) { ?>
            <div class="row <?php echo ($i % 2 == 1 ? 'odd' : 'even bg-warning');?>">
                <div class='col-md-4'>
                    
                    <?php
                        $file = 'facturas/pend_'.$fila->id.'.pdf';
                        if (file_exists($file)) {
                            echo "<a href=\"/php/contabilidad/$file\" target='_blank'>";
                        }
                        echo $fila->factura;
                        if (file_exists($file)) {
                            echo "</a>";
                        }
                    ?>
                </div>
                <div class='col-md-2'>
                    <?php echo date("d/m/Y",strtotime($fila->fecha_subida));?>
                </div>
                <div class='col-md-2'>
                    <?php echo $fila->familia;?>
                </div>

                <div class='col-md-3'>
                    <?php if ($fila->estado==0) {?>
                    <a href="<?php echo site_url('pendientes/autoriza/'.$fila->id);?>" class="btn btn-success btn-xs"> autorizar pago </a>      
                    <?php } ?>
                    <?php if ($fila->estado==1 && $this->ion_auth->user()->row()->desde==0) {?>
                    <a href="<?php echo site_url('pendientes/copia/c'.$fila->id);?>" class="btn btn-info btn-xs"> copiar factura </a>     
                    <?php } ?>
                </div>
            </div>
           <?php $i++;}?>
        <?php } ?>
    </div>
   
    <!--   <label class="col-md-6 btn btn-default">
            Selecciona un archivo pdf <input name="userfile" type="file" class="input-sm " style="display: none;" >
        </label> -->
</form> 

