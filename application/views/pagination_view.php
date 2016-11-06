

<html>
    <head>
        <title>Codelgniter pagination</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="main">
            <div id="content">
                <h3 id='form_head'>Codelgniter Pagination Example </h3><br/>
                <hr>
                <div id="form_input">
                    <?php
// Show data
                    foreach ($results as $data) {
                        echo "<label> Apunte </label>" . "<div class='input_text'>" . $data->apunte . "</div>"
                        . "<label> F. Pago </label> " . "<div class='input_name'>" . $data->fechaPago . "</div>"
                        . "<label> F. Apunte </label>" . "<div class='input_email'>" . $data->fechaApunte . "</div>"
                        . "<label> F. Factura No </label>" . "<div class='input_num'>" . $data->fechaFactura . "</div>"
                        . "<label> Titular </label> " . "<div class='input_country'>" . $data->titular . "</div>";
                    }
                    ?>
                </div>
                <div id="pagination">
                    <ul class="tsc_pagination">

                        <!-- Show pagination links -->
                        <?php
                        foreach ($links as $link) {
                            echo "<li>" . $link . "</li>";
                        }
                        ?>
                </div>
            </div>
        </div>
    </body>
</html>

