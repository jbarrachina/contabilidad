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
            <h2>Listado</h2>
                <?php
                $grupo = "";
                $subgrupo = "";
                foreach ($records as $r) {
                    if ($r->grupo != $grupo) {
                        echo "<div class='row'> ";
                        echo "<div class='col-md-12'>";
                        echo "<h4 class='bg-primary'>",$r->grupo,"</h4>";
                        echo "</div>";
                        echo "</div>";
                        $grupo = $r->grupo;
                    }
                    if (isset($r->descripcion)) {
                        if ($r->descripcion != $subgrupo) {
                            echo "<div class='row'> ";
                            echo "<div class='col-md-11 col-md-offset-1'>";
                            echo "<h5 class='bg-info'>",$r->descripcion,"</h5>";
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
                            } else {
                                echo "<div class='row'> ";
                                echo "<div class='col-md-5 col-md-offset-6 bg-info'>";
                                echo "Total $subgrupo:";
                                echo "</div>";
                                echo "<div class='col-md-1 pull-right bg-info'>";
                                echo "<span class='pull-right'><strong class='bg-info'>", number_format($r->importe,2,',','.'), "</strong></span>";
                                echo "</div>";
                            }

                            echo "</div>";
                        }
                    } else {
                        echo "<div class='row'> ";
                        echo "<div class='bg-primary'>";
                        echo "<div class='col-md-4 col-md-offset-7 bg-primary'>";
                        echo "<h5 class='bg-primary'>Total $grupo: </ht>";
                        echo "</div>";
                        echo "<div class='col-md-1 bg-primary'><h5 class='pull-right bg-primary'>",number_format($r->importe,2,',','.'),"</h5>";
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