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

