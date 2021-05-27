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

    $ret=validate_ej5_data();    
    
    if (!empty($ret))            
    {
        list($errors,$data)=$ret;
    }
    if (!empty($ret) && !$errors)
    {
         $pdo_conn = connect();
         if ($pdo_conn) //Si hay conexión a la base de datos.
         {
             if (comprobarSuperusuario($pdo_conn, $data['email'], $data['password']))
             {
                 echo '<H4 class="ok">El usuario administrador es un superusuario.</H4>';
                 if (cambiarValidacionUsuario($pdo_conn, $data['emailemp'], $data['irrd'], $data['fecha']))
                 {
                     echo '<H4 class="ok">Se ha cambiado validación del usuario indicado.</H4>';
                 }
                 else
                 {
                     echo '<H4 class="err">No se ha cambiado validación del usuario indicado. Posiblemente, ya tiene esa fecha de validación.</H4>';
                 }
             }
             else
             {
                 echo '<H4 class="error">El usuario administrador indicado no es superusuario.</H4>';
             }
       
         } else
         {
            echo '<H4 class="error">No hay conexión con la base de datos.</H4>';
         }
    }
    else
    {
        include 'forms/ejercicio5_form.php';
    }

?>
        </body>
</html>
