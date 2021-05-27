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

    $ret=validate_registry_data();    

    if (!empty($ret))            
    {
        list($errors,$data)=$ret;
    }
    if (!empty($ret) && !$errors)
    {
         $pdo_conn = connect();
         if ($pdo_conn)
         {
         switch (registrarUsuario($pdo_conn,$data)) {
             case REGISTRY_SUCCESS:
                 echo '<H4 class="ok">Registro realizado con éxito. Debe esperar a que se le valide el usuario.</H4>';
                 break;
             case REGISTRY_FAIL_EXISTS:
                 echo '<H4 class="error">El usuario ya existe. No puede registrar dos veces el mismo email.</H4>';
                 break;
             default:
                 echo '<H4 class="error">Error general al registrar el usuario.</H4>';
                 break;
            }
         } else {
            echo '<H4 class="error">No hay conexión con la base de datos.</H4>';
         }
    }
    else
    {
        include 'forms/ejercicio2_form.php';
    }

?>
        </body>
</html>
