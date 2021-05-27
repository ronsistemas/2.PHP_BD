<?php

/**
  CREATE TABLE usuarios (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(30) NOT NULL,
  apellidos varchar(50) NOT NULL,
  email varchar(50) UNIQUE NOT NULL,
  dni varchar(10) UNIQUE NOT NULL,
  password varchar(128) NOT NULL,
  irrd varchar(32) UNIQUE NOT NULL,
  creacion timestamp NOT NULL DEFAULT current_timestamp(),
  validacion datetime,
  superuser boolean NOT NULL DEFAULT false
  );
 */
if (!defined('USERS_DAO_PHP')): //Bloqueo para evitar redifinición de funciones

    define('USERS_DAO_PHP', 1, true);

    define('REGISTRY_SUCCESS', 1, true);
    define('REGISTRY_FAIL_EXISTS', 2, true);
    define('REGISTRY_FAIL_UNKNOWN', 3, true);

    function registrarUsuario(PDO $pdo, $datos) {
        $ret = REGISTRY_FAIL_UNKNOWN;
        $sql = 'INSERT INTO usuarios (nombre, apellidos, email, dni, password, irrd)'
                . ' VALUES (:nombre, :apellidos, :email, :dni, SHA2(:password,0), :irrd)';

        $stmtdat['nombre'] = $datos['nombre'];
        $stmtdat['apellidos'] = $datos['apellidos'];
        $stmtdat['email'] = $datos['email'];
        $stmtdat['dni'] = $datos['dni'];
        $stmtdat['password'] = $datos['email'] . $datos['password'];
        $stmtdat['irrd'] = '' . random_int(0, 9);
        while (strlen($stmtdat['irrd']) < 8) {
            $stmtdat['irrd'] .= random_int(0, 9);
        }
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $ret = REGISTRY_SUCCESS;
            }
            $pdo->commit();
        } catch (PDOException $ex) {
            if ($ex->getCode() == "23000")
                $ret = REGISTRY_FAIL_EXISTS;
            $pdo->rollBack();
        }
        return $ret;
    }

    function obtenerIRRD(PDO $pdo, $datos) {
        $sql = 'SELECT irrd FROM usuarios WHERE email=:email and password=SHA2(:password,0)';

        $stmtdat['email'] = $datos['email'];
        $stmtdat['password'] = $datos['email'] . $datos['password'];

        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $stmt->bindColumn("irrd", $irrd);
                if (!$stmt->fetch(PDO::FETCH_ASSOC))
                    $ret = false;
                else
                    $ret = $irrd;
            }
        } catch (PDOException $ex) {
            $ret = false;
        }
        return $ret;
    }

    function cambiarPassword(PDO $pdo, $datos) {
        $sql = 'UPDATE usuarios SET password=SHA2(:newpassword,0), irrd=:irrd WHERE email=:email and password=SHA2(:password,0)';

        $stmtdat['email'] = $datos['email'];
        $stmtdat['password'] = $datos['email'] . $datos['password'];
        $stmtdat['newpassword'] = $datos['email'] . $datos['newpassword'];
        $stmtdat['irrd'] = '' . random_int(0, 9);
        while (strlen($stmtdat['irrd']) < 8) {
            $stmtdat['irrd'] .= random_int(0, 9);
        }

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $ret = $stmt->rowCount() == 1;
            } else
                $ret = false;
            $pdo->commit();
        } catch (PDOException $ex) {
            $ret = false;
            $pdo->rollBack();
        }
        return $ret;
    }

    function comprobarSuperusuario(PDO $pdo, $email, $password) {
        $sql = 'SELECT superuser FROM usuarios WHERE email=:email and password=SHA2(:password,0)';

        $stmtdat['email'] = $email;
        $stmtdat['password'] = $email . $password;

        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $stmt->bindColumn("superuser", $superuser);
                if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $ret = false;
                } else {
                    $ret = $superuser;
                }
            }
        } catch (PDOException $ex) {
            $ret = false;
        }
        return $ret;
    }

    function cambiarValidacionUsuario(PDO $pdo, $emailemp, $irrd, $fecha) {
        
        $stmtdat['emailemp'] = $emailemp;
        $stmtdat['irrd'] = $irrd;
        if ($fecha === 'INVALIDAR') {
            $sql = 'UPDATE usuarios SET validacion=NULL WHERE email=:emailemp and irrd=:irrd and superuser=false';
        } elseif (is_array($fecha) && isset($fecha['year'],$fecha['month'],$fecha['day'])) {
            $sql = 'UPDATE usuarios SET validacion=:fecha WHERE email=:emailemp and irrd=:irrd and superuser=false';
            $stmtdat['fecha'] = $fecha['year'] . '-' . $fecha['month'] . '-' . $fecha['day'];
        } else {
            return false;
        }

        $ret = false;
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $ret = $stmt->rowCount() == 1;
            }
            $pdo->commit();
        } catch (PDOException $ex) {
            $pdo->rollBack();
        }
        return $ret;
    }

    function verificarUsuarioExiste(PDO $pdo, $email) {
        $sql = 'SELECT count(*) as recuento FROM usuarios WHERE email=:email';

        $stmtdat['email'] = $email;

        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $stmt->bindColumn("recuento", $recuento);
                if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                    $ret = false;
                } else {
                    $ret = $recuento > 0;
                }
            }
        } catch (PDOException $ex) {
            $ret = false;
        }
        return $ret;
    }

    function borrarUsuario(PDO $pdo, $emailemp) {
        $sql = 'DELETE FROM usuarios WHERE email=:emailemp';

        $stmtdat['emailemp'] = $emailemp;

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute($stmtdat)) {
                $ret = $stmt->rowCount() == 1;
            } else {
                $ret = false;
            }
            $pdo->commit();
        } catch (PDOException $ex) {
            $ret = false;
            $pdo->rollBack();
        }
        return $ret;
    }

    function obtenerListadoUsuario(PDO $pdo, $filtro) {
        $sqlfilter = ['NOT_VALIDATED' => 'WHERE validacion IS NULL',
            'VALIDATED' => 'WHERE validacion IS NOT NULL'];

        $sql = 'SELECT nombre,apellidos,email,dni,date_format(creacion,"%d/%m/%Y") as creacion'
                . ',date_format(validacion,"%d/%m/%Y") as validacion,superuser,irrd FROM usuarios '
                . (array_key_exists($filtro, $sqlfilter) ? $sqlfilter[$filtro] : '');

        try {
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute()) {
                $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            $ret = false;
        }
        return $ret;
    }



endif;
