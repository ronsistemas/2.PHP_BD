<?php
include_once 'conf/db.conf.php';
include_once 'libs/conn.php';
include_once 'libs/users.dao.php';
include_once 'libs/users.data.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .error {color:red;font-weight: bold}
            .ok {color:green;font-weight: bold}
        </style>
    </head>
    
    <body>
        <H1>Autor: Profesor</H1>
<?php

    $ret=validate_ej3_data();    

    if (!empty($ret))            
    {
        list($errors,$data)=$ret;
    }
    if (!empty($ret) && !$errors)
    {
         $pdo_conn = connect();
         if ($pdo_conn) //Si hay conexión a la base de datos.
         {
             $irrd=obtenerIRRD($pdo_conn,$data);
             if ($irrd===false)
             {
                 echo '<H4 class="error">No se ha podido obtener el IRRD.</H4>';
             }
             else 
             {
                 echo "<H4 class=\"ok\">El IRRD es $irrd.</H4>";

             } 
         } else
         {
            echo '<H4 class="error">No hay conexión con la base de datos.</H4>';
         }
    }
    else
    {
        include 'forms/ejercicio3_form.php';
    }

?>
        </body>
</html>
