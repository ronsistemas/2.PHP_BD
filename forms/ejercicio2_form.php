<H1>Formulario de registro en el servicio.</H1>
<form action="ejercicio2.php" method="POST">
    <label for="nombre">
        Nombre:
    </label>    
    <input type="text" name="nombre" id="nombre" title="Introduce tu nombre." 
           value="<?php if (!isset($errors['nombre']) && isset ($_POST['nombre'])) echo $_POST['nombre']; ?>">    
    <span class="error"><?php if (isset($errors['nombre'])) echo $errors['nombre']; ?></SPAN>
    <BR>        
    
    <label for="apellidos">
        Apellidos:
    </label> 
    <input type="text" name="apellidos" id="apellidos" title="Introduce tus apellidos."
           value="<?php if (!isset($errors['apellidos']) && isset ($_POST['apellidos'])) echo $_POST['apellidos']; ?>">    
    <span class="error"><?php if (isset($errors['apellidos'])) echo $errors['apellidos']; ?></SPAN><BR>
    
    <label for="email">
        Email:
    </label>        
    <input type="text" name="email" id="email" title="Introduce el email."
           value="<?php if (!isset($errors['email']) && isset ($_POST['email'])) echo $_POST['email']; ?>">    
    <span class="error"><?php if (isset($errors['email'])) echo $errors['email']; ?></SPAN><BR>
    
    <label for="dni">
        DNI:
    </label>
    <input type="text" name="dni" id="dni" title="Introduce el dni."
           value="<?php if (!isset($errors['dni']) && isset ($_POST['dni'])) echo $_POST['dni']; ?>">    
    <span class="error"><?php if (isset($errors['dni'])) echo $errors['dni']; ?></SPAN><BR>
     
    <label for="password1">
        Contraseña:
    </label>
    <input type="password" name="password1" id="password1" value="">  
    <span class="error"><?php if (isset($errors['password1'])) echo $errors['password1']; ?></span><BR>
    
    <label for="password2">
        Repite la contraseña:
    </label>
    <input type="password" name="password2" id="password2" value=""> 
    <span class="error"><?php if (isset($errors['password2'])) echo $errors['password2']; ?></span><br>
    
    <input type="submit" value="Enviar!">
</form>    


