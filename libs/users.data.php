<?php

if (!defined ('USERS_DATA_PHP')): //Bloqueo para evitar redifinición de funciones
    
    define ('USERS_DATA_PHP',1,true);
    define ('VAL_DNI_OPTS',["options" => ["regexp" => "/^(\d{8}[a-zA-Z]{1}|[XxYyZz]{1}\d{7}[a-zA-Z]{1})$/"]]);
    define ('MAX_NOMBRE_SIZE',30,true);
    define ('MAX_APELLIDOS_SIZE',50,true);
    define ('MAX_EMAIL_SIZE',50,true);
    
    function trim2(&$var)
    {
        if (is_string($var)) $var=trim($var);
    }
    
    /**
     * Función destinada aprocesar el nombre recibido vía POST.
     */
    function procesarNombre (&$errors) {
            $sNombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            trim2($sNombre); //Se eliminan espacios solo si no es false o null
            if ($sNombre === false || $sNombre === null || strlen($sNombre) < 2) {
                $errors['nombre'] = 'El nombre no es válido.';
            } else if (strlen($sNombre)>MAX_NOMBRE_SIZE) {
                $errors['nombre'] = 'El nombre es demasiado extenso.';
            }
            return $sNombre;
    }
    
    function procesarApellidos (&$errors)
    {
            $sApellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
            trim2($sApellidos);
            if ($sApellidos === false || $sApellidos === null || strlen($sApellidos) < 2) {
                $errors['apellidos'] = 'Los apellidos no son válidos.';
            } else if (strlen($sApellidos)>MAX_APELLIDOS_SIZE) {
                $errors['apellidos'] = 'Los apellidos son demasiado extensos.';
            }
            return $sApellidos;
    }
    
    /**
     * Método que procesa el email recibido (si no es correcto retornará null).
     */
    function procesarEmail (&$errors, $fieldName='email', $feedbackFieldName=null) {
        // NO USAR FILTER_SATINIZE_EMAIL ya QUE PUEDE REGISTRAR EMAILS QUE EL USUARIO CREEN QUE SON OTROS            
            $sEmail=null;
            $feedbackFieldName=!is_null($feedbackFieldName)?$feedbackFieldName:$fieldName;
            if (isset($_POST[$fieldName])) {
                $sEmail = trim($_POST[$fieldName]);            
                $sEmail = filter_var(strtolower($sEmail), FILTER_VALIDATE_EMAIL);
                if (!$sEmail) {
                    $errors[$fieldName] = "El $feedbackFieldName no es válido.";
                } else if(strlen($sEmail)>MAX_EMAIL_SIZE) {
                    $errors[$fieldName] = "El $feedbackFieldName es demasiado extenso.";
                }
            }   
            else
            {
                $errors[$fieldName] = "El $feedbackFieldName no se ha proporcionado.";
            }
            return $sEmail;
    }
    
    function procesarDNINIE(&$errors) {
        $sDNI=filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
        trim2($sDNI);
        if ($sDNI === false || $sDNI === null || strlen($sDNI) < 3 || !filter_var($sDNI, FILTER_VALIDATE_REGEXP, VAL_DNI_OPTS)) {
            $errors['dni'] = 'El DNI/NIE no es válido.';
        }
        return $sDNI;
    }

    function procesarIrrd(&$errors) {
        $sIRRD=filter_input(INPUT_POST, 'irrd', FILTER_SANITIZE_STRING);
        trim2($sIRRD); //Se eliminan espacios solo si no es false o null
        if ($sIRRD === false || $sIRRD === null || !preg_match("/^[0-9]{8}$/", $sIRRD)) {
            $errors['irrd'] = 'El IRRD no es válido.';
        }
        return $sIRRD;
    }
    
    function procesarFecha(&$errors) {

        $sFecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);
        trim2($sFecha); //Se eliminan espacios solo si no es false o null
        if ($sFecha === false || $sFecha === null) {
            $errors['fecha'] = 'La fecha de validación no se ha indicado.';
        } else {
            if ($sFecha !== "INVALIDAR") {
                $pFecha = date_parse_from_format("j/m/Y", $sFecha);
                if ($pFecha['errors'] || $pFecha['warnings']) {
                    $errors['fecha'] = 'La fecha de validación no tiene el formato esperado.';
                }
            }
        }
        return isset($pFecha)?$pFecha:$sFecha;
    }

    /**
     * Recoge los datos de ejercicio2.php sanea y valida aquella parte que 
     * no tiene que ver con la base de datos.
     * @return un array vacío si no hay datos en $_POST, o bien, un array
     * con dos arrays en su interior si tiene datos (errors, data). 
     */
    function validate_registry_data() {        
        $ret=[];
        if (count($_POST)>0) { //Si hay parámetros.
            $errors = [];
            $data = [];
            //SANEADO del nombre
            $sNombre = procesarNombre($errors);
            
            //SANEADO de los apellidos
            $sApellidos = procesarApellidos($errors);           

            //SANEADO y VALIDACIÓN del email
            $sEmail = procesarEmail($errors);

            //SANEADO y VALIDACIÓN del dni
            $sDNI = procesarDNINIE($errors);

            //VALIDACIÓN del password
            if (!isset($_POST['password1'])) {
                $errors['password1'] = 'No se ha indicado el password.';
            } elseif (!isset($_POST['password2'])) {
                $errors['password2'] = 'No se ha indicado la repetición del password.';
            } else {
                $sPassword = trim($_POST['password1']);
                $sPassword2 = $_POST['password2'];
                if (empty($sPassword) || strlen($sPassword) < 8) {
                    $errors['password1'] = 'El password no es válido (tiene que tener una longitud mínima de 8).';
                }
                if ($sPassword !== $sPassword2)
                    $errors['password2'] = 'La repetición del password no coincide.';
            }

            if (!$errors) {
                $data["nombre"] = $sNombre;
                $data["apellidos"] = $sApellidos;
                $data["email"] = $sEmail;
                $data["dni"] = $sDNI;
                $data["password"] = $sPassword;
            }
            $ret=[$errors, $data];
        }
        return $ret;
    }

/**
     * Recoge los datos de ejercicio3.php sanea y valida aquella parte que 
     * no tiene que ver con la base de datos.
     * @return un array vacío si no hay datos en $_POST, o bien, un array
     * con dos arrays en su interior si tiene datos (errors, data). 
     */
    function validate_ej3_data() {        
        $ret=[];
        if (count($_POST)>0) { //Si hay parámetros.
            $errors = [];
            $data = [];
            
            //SANEADO y VALIDACIÓN del email
            $sEmail = procesarEmail($errors);
            
            //VALIDACIÓN del password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'No se ha indicado el password.';
            } 
            elseif (strlen($_POST['password'])<8)
            {
                $errors['password'] = 'Password incorrecto (longitud mínima no alcanzada).';
            }
            else
            {
                $sPassword=$_POST['password'];
            }

            if (!$errors) {
                $data["email"] = $sEmail;
                $data["password"] = $sPassword;
            }
            $ret=[$errors, $data];
        }
        return $ret;
    }

/**
     * Recoge los datos de ejercicio4.php sanea y valida aquella parte que 
     * no tiene que ver con la base de datos.
     * @return un array vacío si no hay datos en $_POST, o bien, un array
     * con dos arrays en su interior si tiene datos (errors, data). 
     */
    function validate_ej4_data() {        
        $ret=[];
        if (count($_POST)>0) { //Si hay parámetros.
            $errors = [];
            $data = [];
            
            //SANEADO y VALIDACIÓN del email
            $sEmail = procesarEmail($errors);
            
            //VALIDACIÓN del password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'No se ha indicado el password.';
            } 
            elseif (strlen($_POST['password'])<8)
            {
                $errors['password'] = 'Password incorrecto (longitud mínima no alcanzada).';
            }
            else {
                $sPassword=$_POST['password'];
            }

            //VALIDACIÓN del nuevo password
            if (!isset($_POST['password1'])) {
                $errors['password1'] = 'No se ha indicado el password.';
            } elseif (!isset($_POST['password2'])) {
                $errors['password2'] = 'No se ha indicado la repetición del password.';
            } else {
                $sPassword1 = trim($_POST['password1']);
                $sPassword2 = $_POST['password2'];
                if (empty($sPassword1) || strlen($sPassword1) < 8) {
                    $errors['password1'] = 'El password no es válido (tiene que tener una longitud mínima de 8).';
                }
                if ($sPassword1 !== $sPassword2)
                    $errors['password2'] = 'La repetición del password no coincide.';
            }
            
            if (!$errors) {
                $data["email"] = $sEmail;
                $data["password"] = $sPassword;
                $data["newpassword"] = $sPassword1;                
            }
            $ret=[$errors, $data];
        }
        return $ret;
    }
    
       /**
     * Recoge los datos de ejercicio5.php sanea y valida aquella parte que 
     * no tiene que ver con la base de datos.
     * @return un array vacío si no hay datos en $_POST, o bien, un array
     * con dos arrays en su interior si tiene datos (errors, data). 
     */
    function validate_ej5_data() {        
        $ret=[];
        if (count($_POST)>0) { //Si hay parámetros.
            $errors = [];
            $data = [];
          
            //SANEADO y VALIDACIÓN del email del administrador
            $sEmail = procesarEmail($errors);
            
            //SANEADO y VALIDACIÓN del email del empleado
            $sEmailemp = procesarEmail($errors,'emailemp','email del empleado');                 
            
            //VALIDACIÓN del password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'No se ha indicado el password.';
            } 
            elseif (strlen($_POST['password'])<8)
            {
                $errors['password'] = 'Password incorrecto (longitud mínima no alcanzada).';
            }
            else
                $sPassword=$_POST['password'];

            //Validación del IRRD
            $sIRRD = procesarIrrd($errors);
            
            //Validación de la fecha
            $sFecha= procesarFecha($errors);
            
            if (!$errors) {
                $data["email"] = $sEmail;
                $data["emailemp"] = $sEmailemp;
                $data["password"] = $sPassword;
                $data["irrd"] = $sIRRD;
                $data["fecha"] = $sFecha;
            }
            $ret=[$errors, $data];
        }
        return $ret;
    }
       /**
     * Recoge los datos de ejercicio6.php sanea y valida aquella parte que 
     * no tiene que ver con la base de datos.
     * @return un array vacío si no hay datos en $_POST, o bien, un array
     * con dos arrays en su interior si tiene datos (errors, data). 
     */
    function validate_ej6_data() {        
        $ret=[];
        if (count($_POST)>0) { //Si hay parámetros.
            $errors = [];
            $data = [];
          
             //SANEADO y VALIDACIÓN del email del administrador
            $sEmail = procesarEmail($errors);
            
            //SANEADO y VALIDACIÓN del email del empleado
            $sEmailemp = procesarEmail($errors,'emailemp','email del empleado');      
            
            //VALIDACIÓN del password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'No se ha indicado el password.';
            } 
            elseif (strlen($_POST['password'])<8)
            {
                $errors['password'] = 'Password incorrecto (longitud mínima no alcanzada).';
            }
            else
                $sPassword=$_POST['password'];
                        
            if (!$errors) {
                $data["email"] = $sEmail;
                $data["emailemp"] = $sEmailemp;
                $data["password"] = $sPassword;
            }
            $ret=[$errors, $data];
        }
        return $ret;
    }
    
        /**
     * Recoge los datos de ejercicio6.php sanea y valida aquella parte que 
     * no tiene que ver con la base de datos.
     * @return un array vacío si no hay datos en $_POST, o bien, un array
     * con dos arrays en su interior si tiene datos (errors, data). 
     */
    function validate_ej7_data() {        
        $ret=[];
        if (count($_POST)>0) { //Si hay parámetros.
            $errors = [];
            $data = [];
          
            //SANEADO y VALIDACIÓN del email del administrador
            $sEmail = procesarEmail($errors);                      
            
            //VALIDACIÓN del password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'No se ha indicado el password.';
            } 
            elseif (strlen($_POST['password'])<8)
            {
                $errors['password'] = 'Password incorrecto (longitud mínima no alcanzada).';
            }
            else
                $sPassword=$_POST['password'];
                        
            //VALIDACIÓN del tipo de listado
            if (!isset($_POST['tipolistado'])){
                $errors['tipolistado'] = 'No se ha indicado el tipo de listado.';
            } 
            elseif (!in_array($_POST['tipolistado'], ["ALL","NOT_VALIDATED","VALIDATED"]))
            {
                $errors['tipolistado']='La opción indicada no es válida.';
            }
            else
                $sTipoListado=$_POST['tipolistado'];
                
                
            
            
            if (!$errors) {
                $data["email"] = $sEmail;
                $data["password"] = $sPassword;
                $data["tipolistado"] = $sTipoListado;
            }
            $ret=[$errors, $data];
        }
        return $ret;
    }
    
    
endif;