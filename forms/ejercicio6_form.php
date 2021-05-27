<H1>Borrar usuario.</H1>
<form action="ejercicio6.php" method="POST">
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
       
    <input type="submit" value="Enviar!">
</form>    


