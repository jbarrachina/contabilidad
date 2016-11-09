<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//pasamos el formato fecha del csv dd/mm/aaaa a aaaa-mm-dd de mysql
function convierteFecha($fechaOriginal) {
    $vector = explode('/', $fechaOriginal);
    return $vector[2] . "-" . $vector[1] . "-" . $vector[0];
}

/*
 * Pasa
 * 
 */

function replaceApuntes($campos) {
    if (count($campos) == 15) {
        for ($i = 0; $i < count($campos); $i++) {
            $campos[$i] = ($campos[$i] == "\"" ? substr($campos[$i], 1, -1) : $campos[$i]);
            switch ($i) {
                case 0:$anyo = $campos[0];
                    break;
                case 1:$apunte = $campos[1];
                    break;
                case 2:$fechaPago = convierteFecha($campos[2]);
                    break;
                case 3:$fechaApunte = convierteFecha($campos[3]);
                    break;
                case 4:$fechaFactura = ($campos[4] == "" ? NULL : convierteFecha($campos[4])); //hay valores vacios
                    break;
                case 5:$tipo = substr($campos[5], 1, -1); //quitamos las comillas
                    break;
                case 6:$recurso = substr($campos[6], 1, -1);
                    break;
                case 7:$destino = ($campos[7] == "" ? NULL : substr($campos[7], 1, -1));
                    break;
                case 8:$cuenta = ($campos[8] == "" ? NULL : substr($campos[8], 1, -1));
                    break;
                case 9:
                    $importe = (float) str_replace(',', '.', ($campos[9][0] == "\"" ? substr($campos[9], 1, -1) : $campos[9]));
                    break;
                case 10:$titular = ($campos[10] == "" ? NULL : substr($campos[10], 1, -1));
                    break;
                case 11:$concepto = ($campos[11] == "" ? NULL : substr($campos[11], 1, -1));
                    break;
                case 12:$tipoDocumento = ($campos[12] == "" ? NULL : substr($campos[12], 1, -1));
                    break;
            }
        }
    } else {
        // print_r($campos);
    }

    $host = "localhost";
    $db_name = "contabilidad";
    $username = "root";
    $password = "ausias";

    $conexion = new mysqli($host, $username, $password, $db_name);
    if ($conexion->connect_errno) {
// Si se produce algún error finaliza con mensaje de error
        die("Error de Conexión: " . $conexion->connect_error);
    }
    $conexion->set_charset('utf8');
    $query = <<<SQL
    UPDATE apuntes
        SET anyo= ?, apunte= ?, fechaPago= ?, fechaApunte= ?, fechaFactura= ?,
            tipo= ?, recurso= ?, destino= ?, cuenta= ?, importe= ?, titular= ?,
            tipoDocumento= ?, concepto= ?
SQL;

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("iisssssssssss", $anyo, $apunte, $fechaPago, $fechaApunte, $fechaFactura, $tipo, $recurso, $destino, $cuenta, $importe, $titular, $tipoDocumento, $concepto);
    if (!$stmt->execute()) {
        echo $stmt->error;
        $query = str_replace("UPDATE", "INSERT INTO", $query);
        $stmt->bind_param("iisssssssssss", $anyo, $apunte, $fechaPago, $fechaApunte, $fechaFactura, $tipo, $recurso, $destino, $cuenta, $importe, $titular, $tipoDocumento, $concepto);
        if (!$stmt->execute()) {
            echo $stmt->error;
        }
    }
}

//datos del arhivo
$nombre_archivo = $_FILES['userfile']['name'];
$tipo_archivo = $_FILES['userfile']['type'];
$tamano_archivo = $_FILES['userfile']['size'];
//compruebo si las características del archivo son las que deseo
if (!strpos($tipo_archivo, "csv") || ($tamano_archivo > 500000)) {
    echo "La extensión ($tipo_archivo) no es csv o el tamaño ($tamaño_archivo) de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .csv<br><li>se permiten archivos de 500 Kb máximo.</td></tr></table>";
} else {
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], 'files/' . $nombre_archivo)) {
        echo "El archivo ha sido cargado correctamente.<br>";
        $file = fopen('files/' . $nombre_archivo, "r");
        while (!feof($file)) {
            //replaceApuntes(explode("|", substr(fgets($file), 0, -1))); //quitamos el último carácter que es un espacio en blanco
            $apunte = substr(fgets($file), 0, -1);
            echo $apunte . "<br>";
            $campos = explode("|", $apunte);
            replaceApuntes($campos);
        }
        fclose($file);
    } else {
        echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
    }
} 