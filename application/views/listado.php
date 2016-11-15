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
                            echo "<div class='col-md-10 col-md-offset-2'>";
                            echo "<h5 class='bg-info'>",$r->descripcion,"</h5>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='row'> ";
                            echo "<div class='col-md-6 col-md-offset-4'>";
                            echo $r->apunte;
                            echo "</div>";
                            echo "<div class='col-md-1 pull-right'>";
                            echo "<span class='pull-right'>",$r->importe,"</span>";
                            echo "</div>";
                            echo "</div>";
                            $subgrupo = $r->descripcion;
                        } else {
                            echo "<div class='row'> ";
                            if (isset($r->apunte)) {
                                echo "<div class='col-md-6 col-md-offset-4'>";
                                echo $r->apunte;
                                echo "</div>";
                                echo "<div class='col-md-1 pull-right'>";
                                echo "<span class='pull-right'>", $r->importe, "</span>";
                                echo "</div>";
                            } else {
                                echo "<div class='col-md-4 col-md-offset-7 bg-info'>";
                                echo "Total $subgrupo:";
                                echo "</div>";
                                echo "<div class='col-md-1 pull-right bg-info'>";
                                echo "<span class='pull-right'><strong class='bg-info'>", $r->importe, "</strong></span>";
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
                        echo "<div class='col-md-1 bg-primary'><h5 class='pull-right bg-primary'>",$r->importe,"</h5>";
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