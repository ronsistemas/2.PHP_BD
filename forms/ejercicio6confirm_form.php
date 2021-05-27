<p>¿Está seguro de que desea borrar al empleado con email <?=$data['emailemp'];?>?</p>
<form action="ejercicio6confirm.php" method="POST">      
    <input type="hidden" name="email" id="email" title="Introduce el email del administrador."
           value="<?=$data['email']?>">    
    

    <input type="hidden" name="password" id="password" 
           value="<?=$data['password']?>">  
      
    <input type="hidden" name="emailemp" id="emailemp" title="Introduce el email del empleado."
           value="<?=$data['emailemp']?>">    
       
    <input type="submit" value="Borrar empleado">
</form>    

<form action="ejercicio6.php" method="POST">          
    <input type="submit" value="¡Cancelar!">
</form>    
