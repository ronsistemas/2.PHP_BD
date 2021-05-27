<H1>Validar usuario o invalidar usuario.</H1>
<form action="ejercicio5.php" method="POST">
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
    
    <label for="emailemp">
        Email del empleado:
    </label>        
    <input type="text" name="emailemp" id="emailemp" title="Introduce el email del empleado."
           value="">    
    <span class="error"><?php if (isset($errors['emailemp'])) echo $errors['emailemp']; ?></SPAN><BR>

    <label for="irrd">
        IRRD del empleado:
    </label>        
    <input type="text" name="irrd" id="irrd" title="Introduce el email del empleado."
           value="">    
    <span class="error"><?php if (isset($errors['irrd'])) echo $errors['irrd']; ?></SPAN><BR>
   
     <label for="fecha">
        Fecha efectiva de validación (o INVALIDAR para invalidar):
    </label>        
    <input type="text" name="fecha" id="fecha" title="Introduce el email del empleado."
           value="">    
    <span class="error"><?php if (isset($errors['fecha'])) echo $errors['fecha']; ?></SPAN><BR>
    
    <input type="submit" value="Enviar!">
</form>    


