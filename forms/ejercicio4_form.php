<H1>Cambiar la contraseña.</H1>
<form action="ejercicio4.php" method="POST">
    <label for="email">
        Email:
    </label>        
    <input type="text" name="email" id="email" title="Introduce el email."
           value="">    
    <span class="error"><?php if (isset($errors['email'])) echo $errors['email']; ?></SPAN><BR>
     
    <label for="password">
        Contraseña actual:
    </label>
    <input type="password" name="password" id="password" value="">  
    <span class="error"><?php if (isset($errors['password'])) echo $errors['password']; ?></span><BR>
    
    <label for="password1">
        Nueva contraseña:
    </label>
    <input type="password" name="password1" id="password1" value="">  
    <span class="error"><?php if (isset($errors['password1'])) echo $errors['password1']; ?></span><BR>
    
    <label for="password2">
        Repetición nueva contraseña:
    </label>
    <input type="password" name="password2" id="password2" value="">  
    <span class="error"><?php if (isset($errors['password2'])) echo $errors['password2']; ?></span><BR>
    
    <input type="submit" value="Enviar!">
</form>    


