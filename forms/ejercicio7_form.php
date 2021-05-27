<H1>Validar usuario o invalidar usuario.</H1>
<form action="ejercicio7.php" method="POST">
    <label for="email">
        Email de usuario administrador:
    </label>        
    <input type="text" name="email" id="email" title="Introduce el email del administrador."
           value="">    
    <span class="error"><?php if (isset($errors['email'])) echo $errors['email']; ?></SPAN><BR>
     
    <label for="password">
        Contraseña actual del administrador:
    </label>
    <input type="password" name="password" id="password" value="">  
    <span class="error"><?php if (isset($errors['password'])) echo $errors['password']; ?></span><BR>
    
    <label for="tipolistado">
        Seleccione el tipo de listado:
    </label>
    <select name="tipolistado" id="tipolistado">
        <option value="ALL">Todos los usuarios</option>
        <option value="NOT_VALIDATED">Usuarios no validados</option>
        <option value="VALIDATED">Usuarios validados</option>
    </select>
    <span class="error"><?php if (isset($errors['tipolistado'])) echo $errors['tipolistado']; ?></span><BR>

    <input type="submit" value="Enviar!">
</form>    