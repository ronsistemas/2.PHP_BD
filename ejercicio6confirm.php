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

    $ret=validate_ej6_data();    
    
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
                 if (verificarUsuarioExiste($pdo_conn, $data['emailemp']))
                 {
                     echo '<H4 class="ok">El usuario indicado existe.</H4>';
                     if (borrarUsuario($pdo_conn, $data['emailemp']))
                     {
                        echo '<H4 class="ok">El usuario se ha borrado.</H4>';
                     }
                     else
                     {
                         echo '<H4 class="err">El usuario no se ha borrado (puede que ya no exista).</H4>';
                     }
                 }
                 else
                 {
                     echo '<H4 class="err">El usuario indicado no existe.</H4>';
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
        include 'forms/ejercicio6_form.php';
    }

?>
        </body>
</html>
