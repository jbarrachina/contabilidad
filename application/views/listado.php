                <?php
                $grupo = "";
                $subgrupo = "";
                $total = $records[count($records)-1]->importe; //el total de gasto
                
                foreach ($records as $r) {
                    if ($r->grupo != $grupo) {
                        echo "<div class='row'> ";
                        echo "<div class='col-md-12 bg-primary'>";
                        echo "<h4>",$r->grupo,"</h4>";
                        echo "</div>";
                        echo "</div>";
                        $grupo = $r->grupo;
                    }
                    if (isset($r->descripcion)) {
                        if ($r->descripcion != $subgrupo) {
                            echo "<div class='row'> ";
                            echo "<div class='col-md-11 col-md-offset-1 bg-warning'>";
                            echo "<h5>",$r->descripcion,"</h5>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='row'> ";
                            echo "<div class='col-md-9 col-md-offset-2'>";
                            //separar apunte de descripción.
                            $campos = explode(":", $r->apunte);
                            //enlace
                            $pagina = intdiv($campos[0],10)*10;
                            echo "<a href='/php/contabilidad/apuntes/pagina/".$pagina."'>{$campos[0]}</a> -> {$campos[1]}";
                            //echo $r->apunte;
                            echo "</div>";
                            echo "<div class='col-md-1 pull-right'>";
                            echo "<span class='pull-right'>",number_format($r->importe,2,',','.'),"</span>";
                            echo "</div>";
                            echo "</div>";
                            $subgrupo = $r->descripcion;
                            $i=1; //iniciar striped
                        } else {                           
                            if (isset($r->apunte)) {
                                 $i++; //iniciar striped
                                echo "<div class='row ".($i%2==0?'listado-striped':"")."'> ";
                                echo "<div class='col-md-9 col-md-offset-2'>";
                                //separar apunte de descripción.
                                $campos = explode(":", $r->apunte);
                                //enlace
                                $pagina = intdiv($campos[0],10)*10;
                               
                                echo "<a href='/php/contabilidad/apuntes/pagina/".$pagina."'>{$campos[0]}</a> -> {$campos[1]}";
                                //echo $r->apunte;
                                echo "</div>";
                                echo "<div class='col-md-1 pull-right'>";
                                echo "<span class='pull-right'>", number_format($r->importe,2,',','.'), "</span>";
                                echo "</div>";
                                echo "</div>";                            
                            } else {
                                echo "<div class='row'> ";
                                echo "<div class='col-md-4 col-md-offset-6 bg-info'>";
                                echo "Total $subgrupo:";
                                echo "</div>";
                                echo "<div class='col-md-2 pull-right bg-info'>";
                                echo "<span class='pull-right'><strong class='bg-info'>", number_format($r->importe,2,',','.'), "</strong></span>";
                                echo "<div class='col-md-2 bg-info'>",number_format($r->importe/$total*100,2,',','.'),"%";
                                echo "</div>";
                                echo "</div>"; 
                                echo "</div>";
                            }
                        }
                    } else {
                        echo "<div class='row '> ";
                        echo "<div class='bg-danger'>";
                        echo "<div class='col-md-4 col-md-offset-6 bg-danger'>";
                        echo "<h5>Total $grupo: </ht>";
                        echo "</div>";
                        echo "<div class='col-md-2 bg-danger'><h5 class='pull-right '>",number_format($r->importe,2,',','.'),"</h5>";
                        echo "<div class='col-md-2 bg-danger'><h6 class='pull-right '>",number_format($r->importe/$total*100,2,',','.'),"%</h6>";                       
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "\n";
                }
                ?>
            
        </div>
    </body>
</html>