<H1>Formulario para obtener código de validación.</H1>
<form action="ejercicio3.php" method="POST">
    <label for="email">
        Email:
    </label>        
    <input type="text" name="email" id="email" title="Introduce el email."
           value="">    
    <span class="error"><?php if (isset($errors['email'])) echo $errors['email']; ?></SPAN><BR>
     
    <label for="password">
        Contraseña:
    </label>
    <input type="password" name="password" id="password" value="">  
    <span class="error"><?php if (isset($errors['password'])) echo $errors['password']; ?></span><BR>
    
    <input type="submit" value="Enviar!">
</form>    


